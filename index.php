<?php
include 'constants.php';
spl_autoload_register('classLoader');
session_start();

try{
	$portal = new Portal("localhost", "root", "", "budget");
	
	$action = 'showRegistrationForm';
	if (isset($_GET['action'])){
    $action = $_GET['action'];
  }
  
   $message = $portal -> getMessage();
   $delay = $portal -> getDelay();
   
    if (($action == 'showRegistrationForm' || $action == 'registerUser') && $portal->loggedUser){
    header('Location:index.php?action=showMenu');
    return;
  }
  
  
    switch($action){
		case 'login' : 
			switch($portal->login()):
				case ACTION_OK : 
					$portal->setMessage('Zalogowanie prawidłowe.');
					$portal->hideMessageAfterTime(3000);
					header('Location:index.php?action=showMenu');
					return;
				case NO_LOGIN_REQUIRED : 
					$portal->setMessage('Najpierw proszę się wylogować.');
					$portal->hideMessageAfterTime(3000);
					header('Location:index.php?action=showMenu');
					return;
				case ACTION_FAILED :
				case FORM_DATA_MISSING :
					$portal->setMessage('Błędna nazwa użytkownika lub hasło.');
					break;
				default:
					$portal->setMessage('Błąd serwera. Zalogowanie nie jest obecnie możliwe.');
			endswitch;
			header('Location:index.php?action=showRegistrationForm');
			break;
		case 'logout':
			$portal->logout();
			header('Location:index.php?action=showRegisterationForm');
			break;
		case 'registerUser':
			switch ($portal->registerUser()):
				case ACTION_OK:
				  $portal->setMessage('Rejestracja prawidłowa. Możesz się teraz zalogować.');
				  break;
				case FORM_DATA_MISSING:
				  $portal->setMessage('Proszę wypełnić wszystkie pola formularza!');
				  break;
				case PASSWORDS_DO_NOT_MATCH:
				  $portal->setMessage('Hasło musi być takie samo w obu polach!');
				  break;
				case NO_CAPTCHA:
				  $portal->setMessage('Potwierdź, że nie jesteś bootem!');
				  break;
				case USERNAME_LENGTH_ERROR:
				  $portal->setMessage("Nazwa użytkownika musi zawierać 2 - 20 znaków!");
				  break;
				case PASSWORD_LENGTH_ERROR:
				  $portal->setMessage("Hasło musi zawierać 6-20 znaków!");
				  break;
				case USER_NAME_ALREADY_EXISTS:
				  $portal->setMessage('Podana nazwa użytkownika jest już zajęta!');
				  break;
				case ACTION_FAILED:
				  $portal->setMessage('Obecnie rejestracja nie jest możliwa.');
				  break;
				case SERVER_ERROR:
				default:
				  $portal->setMessage('Błąd serwera!');
			endswitch;
			header('Location:index.php?action=showRegistrationForm');
			break;
		case 'addNewIncome':
			switch ($portal -> addNewIncome()):
				case ACTION_OK:
					$portal->setMessage('Dodano nowy przychód.');
					$portal->hideMessageAfterTime(3000);
					header('Location:index.php?action=showMenu');
					return;
				case FORM_DATA_MISSING:
					$portal->setMessage('Proszę wypełnić poprawnie wymagane pola formularza!');
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie dodanie przychodu nie jest możliwe.');
					$portal->hideMessageAfterTime(3000);
					break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showIncomeAddingForm');
			break;
		case 'addNewExpense':
			switch ($portal -> addNewExpense()):
				case ACTION_OK:
					$portal->setMessage('Dodano nowy wydatek.');
					$portal->hideMessageAfterTime(3000);
					header('Location:index.php?action=showMenu');
					return;
				case FORM_DATA_MISSING:
					$portal->setMessage('Proszę wypełnić poprawnie wymagane pola formularza!');
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie dodanie wydatku nie jest możliwe.');
					$portal->hideMessageAfterTime(3000);
					break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showExpenseAddingForm');
			break;
		case 'removeItem':
			switch($portal->removeItem()):
				case ACTION_OK:
					$portal->setMessage('Wybrana pozycja została pomyślnie usunięta.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie usunięcie wybranej pozycji nie jest możliwe.');
					$portal->hideMessageAfterTime(3000);
					break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showBalance');
			break;
		case 'deleteExpense':
			//
			break;
		case 'updateItem':
			switch($portal->updateItem()):
				case ACTION_OK:
					$portal->setMessage('Wybrana pozycja została pomyślnie edytowana.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie edycja wybranej pozycji nie jest możliwa.');
					$portal->hideMessageAfterTime(3000);
					break;
				case FORM_DATA_MISSING:
				case INVALID_DATA:
				  $portal->setMessage('Nie zapisano z powodu braku danych lub ich niepoprawności.');
				  $portal->hideMessageAfterTime(3000);
				  break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showBalance');
			break;
		case 'setNewUsername':
			switch($portal->setNewUsername()):
				case ACTION_OK:
					$portal->setMessage('Nazwa użytkownika została pomyślnie zmieniona.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie zmiana nazwy użytkownika nie jest możliwa.');
					$portal->hideMessageAfterTime(3000);
					break;
				case USERNAME_LENGTH_ERROR:
				  $portal->setMessage("Nazwa użytkownika musi zawierać 2 - 20 znaków!");
				  $portal->hideMessageAfterTime(6000);
				  break;
				case USER_NAME_ALREADY_EXISTS:
				  $portal->setMessage('Podana nazwa użytkownika jest już zajęta!');
				  $portal->hideMessageAfterTime(6000);
				  break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		case 'editCategoryName':
			switch($portal->editCategoryName()):
				case ACTION_OK:
					$portal->setMessage('Nazwa kategorii została pomyślnie zmieniona.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie zmiana nazwy kategorii nie jest możliwa.');
					$portal->hideMessageAfterTime(3000);
					break;
				case FORM_DATA_MISSING:
				  $portal->setMessage('Nie zapisano z powodu braku danych.');
				  $portal->hideMessageAfterTime(3000);
				  break;
				case CATEGORY_NAME_ALREADY_EXISTS:
				  $portal->setMessage('Kategoria o takiej nazwie już istnieje!');
				  $portal->hideMessageAfterTime(6000);
				  break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		case 'editIncomeCategoriesPositions':
			switch($portal->editIncomeCategoriesPositions()):
				case ACTION_OK:
					$portal->setMessage('Pomyślnie zmieniono kolejność kategorii.');
					$portal->hideMessageAfterTime(3000);
					break;
				case CATEGORY_POSITIONS_ARE_NOT_UNIQUE:
					$portal->setMessage('Nie można dwóch kategorii przypisać do tej samej pozycji.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie nie można zmienić kolejności kategorii.');
					$portal->hideMessageAfterTime(3000);
					break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		case 'editExpenseCategoriesPositions':
			switch($portal->editExpenseCategoriesPositions()):
				case ACTION_OK:
					$portal->setMessage('Pomyślnie zmieniono kolejność kategorii.');
					$portal->hideMessageAfterTime(3000);
					break;
				case CATEGORY_POSITIONS_ARE_NOT_UNIQUE:
					$portal->setMessage('Nie można dwóch lub więcej kategorii przypisać do tej samej pozycji.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie nie można zmienić kolejności kategorii.');
					$portal->hideMessageAfterTime(3000);
					break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		case 'removeCategory':
			switch($portal->removeCategory()):
				case ACTION_OK:
					$portal->setMessage('Wybrana kotegoria została pomyślnie usunięta');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie usunięcie wybranej kategorii nie jest możliwe');
					$portal->hideMessageAfterTime(3000);
					break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		case 'removeLastAddedIncomes':
			switch($portal->removeLastAddedIncomes()):
				case ACTION_OK:
					$portal->setMessage('Pomyślnie usunięto wszystkie zaznaczone przychody.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Usunięcie wszystkich zaznaczonych przychodów nie było możliwe.');
					$portal->hideMessageAfterTime(3000);
					break;
				case FORM_DATA_MISSING:
					$portal->setMessage('Brak zaznaczonych przychodów do usunięcia.');
					$portal->hideMessageAfterTime(3000);
					break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		case 'removeLastAddedExpenses':
			switch($portal->removeLastAddedExpenses()):
				case ACTION_OK:
					$portal->setMessage('Pomyślnie usunięto wszystkie zaznaczone wydatki.');
					$portal->hideMessageAfterTime(3000);
					break;
				case FORM_DATA_MISSING:
					$portal->setMessage('Brak zaznaczonych wydatków do usunięcia.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Usunięcie wszystkich zaznaczonych wydatków nie było możliwe.');
					$portal->hideMessageAfterTime(3000);
					break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		case 'addNewIncomeCategory':
			switch($portal->addNewIncomeCategory()):
				case ACTION_OK:
					$portal->setMessage('Pomyślnie dodano nową kategorię przychodów.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie dodanie nowej kategorii nie jest możliwe.');
					$portal->hideMessageAfterTime(3000);
					break;
				case FORM_DATA_MISSING:
					$portal->setMessage('Nie dodano nowej kategorii z powodu braku danych.');
					$portal->hideMessageAfterTime(3000);
					break;
				case CATEGORY_NAME_ALREADY_EXISTS:
				  $portal->setMessage('Kategoria o takiej nazwie już istnieje!');
				  break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		case 'addNewExpenseCategory':
			switch($portal->addNewExpenseCategory()):
				case ACTION_OK:
					$portal->setMessage('Pomyślnie dodano nową kategorię wydatków.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie dodanie nowej kategorii nie jest możliwe.');
					$portal->hideMessageAfterTime(3000);
					break;
				case FORM_DATA_MISSING:
					$portal->setMessage('Nie dodano nowej kategorii z powodu braku danych.');
					$portal->hideMessageAfterTime(3000);
					break;
				case CATEGORY_NAME_ALREADY_EXISTS:
				  $portal->setMessage('Kategoria o takiej nazwie już istnieje!');
				  $portal->hideMessageAfterTime(6000);
				  break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		case 'setNewPassword':
			switch($portal->setNewPassword()):
				case ACTION_OK:
					$portal->setMessage('Hasło zostało pomyślnie zmienione.');
					$portal->hideMessageAfterTime(3000);
					break;
				case ACTION_FAILED:
					$portal->setMessage('Obecnie zmiana hasła nie jest możliwa.');
					$portal->hideMessageAfterTime(3000);
					break;
				case PASSWORD_LENGTH_ERROR:
				  $portal->setMessage("Hasło musi zawierać 6 - 20 znaków!");
				  $portal->hideMessageAfterTime(6000);
				  break;
				case WRONG_PASSWORD;
				  $portal->setMessage('Podałeś błędnie dotychczasowe hasło!');
				  $portal->hideMessageAfterTime(6000);
				  break;  
				case PASSWORDS_DO_NOT_MATCH;
				  $portal->setMessage('Podane hasła nie są identyczne!');
				  $portal->hideMessageAfterTime(6000);
				  break;
				case SERVER_ERROR:
				default:
					$portal->setMessage('Błąd serwera!');
					$portal->hideMessageAfterTime(3000);
			endswitch;
			header('Location:index.php?action=showSettings');
			break;
		default:
			include 'templates/mainTemplate.php';
	}
}
catch(Exception $e){
  echo 'Błąd: ' . $e->getMessage();
  //exit('Portal chwilowo niedostępny');
}

function classLoader($className){
  if(file_exists("classes/$className.php")){
    require_once("classes/$className.php");
  } else{
    throw new Exception("Brak pliku z definicją klasy.");
  }
}
	
?>