<?php
class Registration
{
  private $dbo = null;
  private $fields = array();
  
  function __construct($dbo)
  {
    $this->dbo = $dbo;
	$this->initFields();
  }
  
   function initFields()
  {
    $this->fields['username'] = new FormInput('username', 'Nazwa użytkownika');
    $this->fields['password'] = new FormInput('password', 'Hasło', '', 'password');
    $this->fields['password2'] = new FormInput('password2', 'Powtórz hasło', '', 'password');
  }
  
  function showRegistrationForm()
  {
	  foreach($this->fields as $name => $field){
      $field->value = isset($_SESSION['formData'][$name]) ? $_SESSION['formData'][$name] : '';
		}
		$formData = $this->fields;
		if(isset($_SESSION['formData'])){
		  unset($_SESSION['formData']);
		}
	
		include 'templates/registrationForm.php'; 
  }
	
	function registerUser()
	{
		foreach($this->fields as $name => $val){
			if(!isset($_POST[$name])){
			return FORM_DATA_MISSING;
		}
    }
   
    //Odczyt i przefiltrowanie danych z formularza
    $fieldsFromForm = array();
    $emptyFieldDetected = false;
    foreach($this->fields as $name => $val){
      if($val->type != 'password'){
        $fieldsFromForm[$name] = filter_input(INPUT_POST, $name, 
                                 FILTER_SANITIZE_SPECIAL_CHARS);
		$fieldsFromForm[$name] = $this->dbo->quote($fieldsFromForm[$name]);
      } else {
	   $fieldsFromForm[$name] = $_POST[$name];
      }

      if($fieldsFromForm[$name] == '' && $val->required){
        $emptyFieldDetected = true;
      }
    }
    
    //Sprawdzenie czy wykryto puste pola
    if($emptyFieldDetected){
      unset($fieldsFromForm['password']);
      unset($fieldsFromForm['password2']);
      $_SESSION['formData'] = $fieldsFromForm;
      return FORM_DATA_MISSING;
    }
	
	if (strlen($_POST['username']) < 2 || strlen($_POST['username']) > 20){
		unset($fieldsFromForm['password']);
		unset($fieldsFromForm['password2']);
		$_SESSION['formData'] = $fieldsFromForm;
		return USERNAME_LENGTH_ERROR;
	}
	if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 20){
		unset($fieldsFromForm['password']);
		unset($fieldsFromForm['password2']);
		$_SESSION['formData'] = $fieldsFromForm;
		return PASSWORD_LENGTH_ERROR;
	}
	
	 //Sprawdzenie czy podany username jest już w bazie
	
	$query = "SELECT `id` FROM `users` WHERE `username`={$fieldsFromForm['username']}";
	$result = $this->dbo->query($query);
	
	if ($result -> rowCount()){
		unset($fieldsFromForm['password']);
		unset($fieldsFromForm['password2']);
		$_SESSION['formData'] = $fieldsFromForm;
      return USER_NAME_ALREADY_EXISTS;
	}
	
    //Sprawdzenie zgodności hasła z obu pól
    if($fieldsFromForm['password'] != $fieldsFromForm['password2']){
      unset($fieldsFromForm['password']);
      unset($fieldsFromForm['password2']);
      $_SESSION['formData'] = $fieldsFromForm;
      return PASSWORDS_DO_NOT_MATCH;
    }
    unset($fieldsFromForm['password2']);
    unset($this->fields['password2']);
	
	$secretKey = "6LeFT1sUAAAAAH9WeHLHKGgFSql-lBJ1WYr_541D";
	$checkReCaptcha = file_get_contents('https://google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
	$respond = json_decode($checkReCaptcha);
	if(!$respond->success){
		unset($fieldsFromForm['password']);
		$_SESSION['formData'] = $fieldsFromForm;
		return NO_CAPTCHA;
	}
    
    //Zakodowanie hasła.
	$fieldsFromForm['password'] = password_hash($fieldsFromForm['password'], PASSWORD_DEFAULT);
	$fieldsFromForm['password'] = $this->dbo->quote($fieldsFromForm['password']);

    
    //Przygotowanie ciągów nazw pól i wartości pól dla zapytania SQL
    $fieldsNames = '`'.implode('`, `', array_keys($this->fields)).'`';
    $fieldsVals = implode(',', $fieldsFromForm);
    
    //Formowanie i wykonanie zapytania
    $query = "INSERT INTO users ($fieldsNames) VALUES ($fieldsVals)";
	
	
	if(($this->dbo->exec($query)) !== false){
		
		$this->dbo->query("SET @userId=LAST_INSERT_ID()");
		$this->dbo->query("INSERT INTO expenses_category_assigned_to_users (user_id, name, position) SELECT @userId, name, position FROM expenses_category_default");
		$this->dbo->query("INSERT INTO incomes_category_assigned_to_users (user_id, name, position) SELECT @userId, name, position FROM incomes_category_default");
		$this->dbo->query("INSERT INTO payment_methods_assigned_to_users (user_id, name, position) SELECT @userId, name, position FROM payment_methods_default");	
		return ACTION_OK;
		}
	else{
			 unset($fieldsFromForm['password']);
			$_SESSION['formData'] = $fieldsFromForm;
			return ACTION_FAILED;
		}
  }
  
}