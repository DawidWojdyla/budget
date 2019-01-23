<?php
class Portal extends MyDB
{
	public $loggedUser = null;
	
	function __construct($host, $user, $password, $dbName, $dbType= 'mysql', $charset ='utf8')
	{
		$this->dbo = $this->initDB($host, $user, $password, $dbName, $dbType= 'mysql', $charset ='utf8');
		$this->loggedUser = $this->getActualUser();
	}
	
	function getActualUser()
	{
		if(isset($_SESSION['loggedUser'])) 
			return $_SESSION['loggedUser'];
		else 
			return null;
	}
	
	function setMessage($message)
	{
		$_SESSION['message'] = $message;
	}
  
	function getMessage()
	{
		if(isset($_SESSION['message'])){
			$message = $_SESSION['message'];
			unset($_SESSION['message']);
			return $message;
		}
		else
			return null;
	}
	
	function hideMessageAfterTime($delay)
	{
		$_SESSION['delay'] = $delay;
	}
	
	function getDelay()
	{
		if(isset($_SESSION['delay'])){
			$delay = $_SESSION['delay'];
			unset($_SESSION['delay']);
			return $delay;
		}
		else
			return null;
	}

	function login()
	{
		if( !$this->dbo) return SERVER_ERROR;
		if ($this->loggedUser) return NO_LOGIN_REQUIRED;
		 
		if (!isset($_POST["username"]) || !isset($_POST["password"])) return FORM_DATA_MISSING;
		
		$username = filter_input(INPUT_POST, 'username');
		$password = filter_input(INPUT_POST, 'password');
		
		$usernameLength = mb_strlen($username, 'utf8');
		$passwordLength = mb_strlen($password, 'utf8');
		
		if($usernameLength < 2 || $usernameLength >20 || $passwordLength < 6 || $passwordLength > 20)
		  return ACTION_FAILED;
	  
		$query = "SELECT `id`, `password` FROM `users` WHERE `username`=:username";
		$PDOstatement = $this->dbo->prepare($query);
		$PDOstatement -> bindValue(':username', $username, PDO::PARAM_STR);

		if(!$PDOstatement->execute())
			return SERVER_ERROR;
		
		if(!$result = $PDOstatement->fetch(PDO::FETCH_NUM))
		  return ACTION_FAILED;
		
		 if(!password_verify($password, $result[1]))
			return ACTION_FAILED;
		 
		$_SESSION['loggedUser'] = new User($result[0], $username);
		return ACTION_OK;
	}
	  
	function logout()
	{
		$this->loggedUser = null;
		if (isset($_SESSION['loggedUser']))
		unset($_SESSION['loggedUser']);
	}
	  
	function addNewIncome()
	{
		if (!$this->loggedUser)  return LOGIN_REQUIRED;
		$incomes = new Incomes ($this->dbo);
		return $incomes -> addNewIncome();
	}
	
	function addNewExpense()
	{
		if (!$this->loggedUser)  return LOGIN_REQUIRED;
		
		$expenses = new Expenses ($this->dbo);
		return $expenses->addNewExpense();
	}
  
	function showIncomeAddingForm()
	{
		if(!$this->dbo) return SERVER_ERROR;
		if (!$this->loggedUser)  return LOGIN_REQUIRED;
		$incomes = new Incomes ($this->dbo);
		return $incomes->showIncomeAddingForm();
	}
  
	function showExpenseAddingForm()
	{
		if(!$this->dbo) return SERVER_ERROR;
		if (!$this->loggedUser)  return LOGIN_REQUIRED;
		
		$expenses = new Expenses ($this->dbo);
		return $expenses->showExpenseAddingForm();
	}

	function showRegistrationForm()
	{
		$registration = new Registration($this->dbo);
		return $registration->showRegistrationForm();
	}
	
	function registerUser()
	{
		if(!$this->dbo) return SERVER_ERROR;
		$registration = new Registration($this->dbo);
		return $registration->registerUser();
	}
  
	function showMenu()
	{
		if ($this->loggedUser)  return ACTION_OK;
		else return ACTION_FAILED;
	}
	
	function setBalancePeriod()
	{	
		if(isset($_POST['period']))
		{
			switch($_POST['period'])
			{
				case 'Poprzedni miesiąc': 
					$_SESSION['dateFrom'] = date('Y-m-d', strtotime('first day of previous month'));
					$_SESSION['dateTo'] = date('Y-m-d', strtotime('last day of previous month'));
					$_SESSION['whatPeriod'] = $_POST['period'];
					break;
				case 'Bieżący rok': 
					$_SESSION['dateFrom'] = date('Y-01-01');
					$_SESSION['dateTo'] = date('Y-m-d');
					$_SESSION['whatPeriod'] = $_POST['period'];
					break;
				case 'Pokaż': 
					$_SESSION['dateFrom'] = $_POST ['dateFrom'];
					$_SESSION['dateTo'] = $_POST['dateTo'];
					$_SESSION['whatPeriod'] = substr(str_replace('-', '/', $_POST ['dateFrom']),2).' - '.substr(str_replace('-', '/', $_POST ['dateTo']),2);
					break;
				case 'Bieżący miesiąc':
				default: 
					$_SESSION['dateTo'] = date('Y-m-d');
					$_SESSION['dateFrom'] = date('Y-m-01');
					$_SESSION['whatPeriod'] = 'Bieżący miesiąc';
					break;
			}		
		}
		else
		{
			$_SESSION['dateFrom'] = date('Y-m-01');
			$_SESSION['dateTo'] = date('Y-m-d');
			$_SESSION['whatPeriod'] = "Bieżący miesiąc";
		}
	}
	
	function setStatementSorting()
	{
		if(isset($_POST['whatSorting']))
		{
			//$_SESSION['whatSorting'] = $_POST['whatSorting'];
			
			switch($_POST['whatSorting'])
			{
				case 'rosnąca data': 
					$_SESSION['sortColumn'] ='date';
					$_SESSION['sortType'] = 'ASC';
					break;
				case 'malejąca kwota': 
					$_SESSION['sortColumn'] = 'amount';
					$_SESSION['sortType'] = 'DESC';
					break;
				case 'rosnąca kwota': 
					$_SESSION['sortColumn'] = 'amount';
					$_SESSION['sortType'] = 'ASC';
					break;
				default: 
					$_SESSION['sortColumn'] = 'date';
					$_SESSION['sortType'] = 'DESC';
					break;
			}		
		}
		else
		{
			$_SESSION['sortColumn'] = 'date';
			$_SESSION['sortType'] = 'DESC';
		}
	}
  
	function showBalance()
	{
		if(!$this->dbo) return SERVER_ERROR;
		if (!$this->loggedUser)  return LOGIN_REQUIRED;
		
		$this->setBalancePeriod();
		$this->setStatementSorting();
		
		$incomes = new Incomes($this->dbo);
		$chosenIncomes = $incomes -> returnIncomesFromChosenPeriod();
		$incomeCategories = $incomes -> returnCategoriesArray();
		$incomeCategorySum = $incomes -> returnCategorySumArray($chosenIncomes);
		$allIncomesSum = array_sum($incomeCategorySum);
		
		$expenses = new Expenses($this->dbo);
		$chosenExpenses = $expenses -> returnExpensesFromChosenPeriod();
		$expensesCategories = $expenses -> returnCategoriesArray();
		$paymentMethods = $expenses -> returnPaymentMethodsArray();
		$expenseCategorySum = $expenses->returnCategorySumArray($chosenExpenses);
		$allExpensesSum = array_sum($expenseCategorySum);
			
		include 'scripts/balanceScripts.php';
		include 'scripts/charPie.php';
		include 'templates/dropDownMenuOfSorting.php';
		include 'templates/dropDownMenu.php';
		include 'templates/balance.php';
	  
  }
	
	function removeItem()
	{
		if( !$this->dbo) return SERVER_ERROR;
		
		if(!isset($_POST['itemToBeRemoved'])) return ACTION_FAILED;
		
		$id = (int)(substr($_POST['itemToBeRemoved'], 1));
		
		if(substr($_POST['itemToBeRemoved'], 0, 1) == 'i')
		{
			$incomes = new Incomes($this->dbo);
			return $incomes -> deleteIncome($id);
		}
		else if(substr($_POST['itemToBeRemoved'], 0, 1) == 'e')
		{
			$expenses = new Expenses($this->dbo);
			return $expenses -> deleteExpense($id);
		}
		else return ACTION_FAILED;
	}
	
	function updateItem()
	{
		//$_SESSION['showLastChosenPeriod'] = true;
		
		if( !$this->dbo) return SERVER_ERROR;
		
		if(!isset($_POST['itemToBeUpdated'])) return ACTION_FAILED;
		
		$id = (int)(substr($_POST['itemToBeUpdated'], 1));
		
		if(substr($_POST['itemToBeUpdated'], 0, 1) == 'i')
		{
			$incomes = new Incomes($this->dbo);
			return $incomes -> editIncome($id);
		}
		else if(substr($_POST['itemToBeUpdated'], 0, 1) == 'e')
		{
			$expenses = new Expenses($this->dbo);
			return $expenses -> editExpense($id);
		}
		else return ACTION_FAILED;
	}
	
	function showSettings()
	{
		if(!$this->dbo) return SERVER_ERROR;
		if (!$this->loggedUser)  return LOGIN_REQUIRED;
		
		$incomes = new Incomes($this->dbo);
		$incomesCategories = $incomes->returnCategoriesArrayExceptOthers();
		$incomeCategoriesAmount  = count($incomesCategories);
		
		$expenses = new Expenses($this->dbo);
		$expenseCategories = $expenses->returnCategoriesArrayExceptOthers();
		$expenseCategoriesAmount = count($expenseCategories);
		
		$paymentMethods = $expenses->returnPaymentMethodsArrayExceptOther();
		$paymentMethodsAmount = count($paymentMethods);
		
		
		$lastIncomes = $incomes->returnLastAddedIncomes(5);
		$lastExpenses = $expenses->returnLastAddedExpenses(5);
		

		include 'scripts/settingsScripts.php';
		include 'templates/settings.php';
	}
	
	function removeLastAddedIncomes()
	{
		if( !$this->dbo) return SERVER_ERROR;
		
		if(!isset($_POST['lastIncomes'])) return FORM_DATA_MISSING;
		
		$incomes = new Incomes($this->dbo);
		
		foreach($_POST['lastIncomes'] as $lastIncomeId)
		{
			if(!$incomes->deleteIncome($lastIncomeId))
				return ACTION_FAILED;
		}
		
		return ACTION_OK;
	}
	
	function removeLastAddedExpenses()
	{
		if( !$this->dbo) return SERVER_ERROR;
		
		if(!isset($_POST['lastExpenses'])) return FORM_DATA_MISSING;
		
		$expenses = new Expenses($this->dbo);
		
		foreach($_POST['lastExpenses'] as $lastExpenseId)
		{
			if(!$expenses->deleteExpense($lastExpenseId))
				return ACTION_FAILED;
		}
		
		return ACTION_OK;
	}	
	
	function setNewUsername()
	{	
		if( !$this->dbo) return SERVER_ERROR;
	  
		if(!isset($_POST['username'])) return FORM_DATA_MISSING;
		
		if($_POST['username'] == $_SESSION['loggedUser']->username) return ACTION_OK;
		
		if (strlen($_POST['username']) < 2 || strlen($_POST['username']) > 20) return USERNAME_LENGTH_ERROR;
		
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
		
		$query = $this->dbo->query("SELECT id FROM users WHERE username = '{$username}'");
		
		if ($query-> rowCount()) return USER_NAME_ALREADY_EXISTS;
		
		$query = $this -> dbo -> prepare ("UPDATE users SET username=:name WHERE id={$this->loggedUser->id}");
		$query -> bindValue(':name', $username, PDO::PARAM_STR);
		if (!$query -> execute()) return ACTION_FAILED;
		$_SESSION['loggedUser']->username = $username;
		return ACTION_OK;
  }
  
  function setNewPassword()
	{	
		if( !$this->dbo) return SERVER_ERROR;
	  
		if(!isset($_POST['newPassword']) || !isset($_POST['newPassword2']) || !isset($_POST['currentPassword'])) return FORM_DATA_MISSING;
	
		$currentPassword = filter_input(INPUT_POST, 'currentPassword');
		$query = $this->dbo->query("SELECT password FROM users WHERE id={$this->loggedUser->id}");
		$result = $query ->fetch();
		
		if (!password_verify($currentPassword, $result['password'])) return WRONG_PASSWORD;
		
		if (strlen($_POST['newPassword']) < 6 || strlen($_POST['newPassword']) >20) return PASSWORD_LENGTH_ERROR;
			
		if($_POST['newPassword'] != $_POST['newPassword2']) return PASSWORDS_DO_NOT_MATCH;
				
		$newHashPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
					
		$query = $this->dbo->prepare("UPDATE users SET password=:newPassword WHERE id={$this->loggedUser->id}");
		$query -> bindValue(':newPassword', $newHashPassword, PDO::PARAM_STR);		
		
		if ($query -> execute()) return ACTION_OK;
		else return ACTION_FAILED;	
  }
  
  function editCategoryName()
  {
	  
	  if(!$this->dbo) return SERVER_ERROR;
	  if(!isset($_POST['newCategoryName']) || !isset($_POST['categoryId']) || $_POST['newCategoryName'] == '') return FORM_DATA_MISSING;
	  if($_POST['categoryId'] < 1) return ACTION_FAILED;
	  
	  $categoryId = (int) $_POST['categoryId'];
	  $newCategoryName = mb_convert_case($_POST['newCategoryName'], MB_CASE_TITLE, "UTF-8");
	  
	  if($_POST['typeOfCategory'] == 'i')
	  {
		  $incomes = new Incomes($this->dbo);
		  return $incomes->setNewCategoryName($categoryId , $newCategoryName);
	  }
	  else if($_POST['typeOfCategory'] == 'e')
	  {
		  $expenses = new Expenses($this->dbo);
		  return $expenses->setNewCategoryName($categoryId , $newCategoryName);
	  }
	  else if($_POST['typeOfCategory'] == 'p')
	  {
		  $expenses = new Expenses($this->dbo);
		  return $expenses->setNewPaymentMethodName($categoryId , $newCategoryName);
	  }
	  else return ACTION_FAILED;
  }
  
  	function removeCategory()
	{
		if( !$this->dbo) return SERVER_ERROR;
		
		if(!isset($_POST['itemToBeRemoved'])) return ACTION_FAILED;
		
		$id = (int)(substr($_POST['itemToBeRemoved'], 1));
		
		if(substr($_POST['itemToBeRemoved'], 0, 1) == 'i')
		{
			$incomes = new Incomes($this->dbo);
			return $incomes -> deleteCategory($id);
		}
		else if(substr($_POST['itemToBeRemoved'], 0, 1) == 'e')
		{
			$expenses = new Expenses($this->dbo);
			return $expenses -> deleteCategory($id);
		}
		else if(substr($_POST['itemToBeRemoved'], 0, 1) == 'p')
		{
			$expenses = new Expenses($this->dbo);
			return $expenses -> deletePaymentMethodCategory($id);
		}
		else return ACTION_FAILED;
	}
  
  
  function addNewIncomeCategory()
  {
	  $incomes = new Incomes($this->dbo);
	  return $incomes->addNewIncomeCategory();
  }
  
  
  function addNewExpenseCategory()
  {
	  $expenses = new Expenses($this->dbo);
	  return $expenses->addNewExpenseCategory();
  }
  
  function addNewPaymentMethod()
  {
	  $expenses = new Expenses($this->dbo);
	  return $expenses->addNewPaymentMethod();	  
  }
  
  function editIncomeCategoriesPositions()
  {
	  if( !$this->dbo) return SERVER_ERROR;
	  
	  if($_POST['incomeCategories'] !== array_unique($_POST['incomeCategories']))
		  return CATEGORY_POSITIONS_ARE_NOT_UNIQUE;
		  
	  $incomes = new Incomes($this->dbo);
	  return $incomes->editCategoryPositions();
  }
  
  function editExpenseCategoriesPositions()
  {
	  if( !$this->dbo) return SERVER_ERROR;
	  
	  if($_POST['expenseCategories'] !== array_unique($_POST['expenseCategories']))
		  return CATEGORY_POSITIONS_ARE_NOT_UNIQUE;
		  
	  $expenses = new Expenses($this->dbo);
	  return $expenses->editCategoryPositions();
  }
  
  function editPaymentMethodsPositions()
  {
	  if( !$this->dbo) return SERVER_ERROR;
	  
	  if($_POST['paymentMethods'] !== array_unique($_POST['paymentMethods']))
		  return CATEGORY_POSITIONS_ARE_NOT_UNIQUE;
		  
	  $expenses = new Expenses($this->dbo);
	  return $expenses->editPaymentMethodPositions();
  }
  
}
?>