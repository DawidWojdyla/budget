<?php
class Expenses
{
	private $dbo = null;
	
	function __construct($dbo)
	{
		$this->dbo = $dbo;
	}
	
	function addNewExpenseToBase($expense)
	{
		if( !$this->dbo) return SERVER_ERROR;
		
		$query  = $this->dbo -> prepare ("INSERT INTO `expenses` VALUES (NULL, :userId, :categoryId, :paymentMethodId, :amount, :date, :comment)");
		$query -> bindValue (':userId', $expense->getUserId(), PDO::PARAM_INT);
		$query -> bindValue (':categoryId', $expense->getCategoryId(), PDO::PARAM_INT);
		$query -> bindValue (':paymentMethodId', $expense->getPaymentMethodId(), PDO::PARAM_INT);
		$query -> bindValue (':amount', $expense->getAmount(), PDO::PARAM_STR);
		$query -> bindValue (':date', $expense->getExpenseDate(), PDO::PARAM_STR);
		$query -> bindValue (':comment', $expense->getComment(), PDO::PARAM_STR);
		
		if ($query -> execute()){
		unset($_SESSION['amountSes']);
		unset($_SESSION['paymentSes']);
		unset($_SESSION['dateSes']);
		unset($_SESSION['categorySes']);
		unset($_SESSION['paymentMethodSes']);
		unset($_SESSION['commentSes']);
		return ACTION_OK;
		}
		else return ACTION_FAILED;	
	}
	
	function deleteExpense($expenseId)
	{
		$query = "DELETE FROM `expenses` WHERE id=$expenseId";
		
		if ($this->dbo->exec($query) !== false) return ACTION_OK;
		else return ACTION_FAILED;	
		
	}
	
	function updateExpense($expense)
	{
		$query = $this -> dbo -> prepare ("UPDATE `expenses` SET expense_category_assigned_to_user_id=:categoryId, payment_method_assigned_to_user_id=:paymentMethodId, amount=:amount, date=:date, comment=:comment WHERE id=:expenseId");
		$query -> bindValue (':categoryId', $expense->getCategoryId(), PDO::PARAM_INT);
		$query -> bindValue (':paymentMethodId', $expense->getPaymentMethodId(), PDO::PARAM_INT);
		$query -> bindValue (':amount', $expense->getAmount(), PDO::PARAM_STR);
		$query -> bindValue (':date', $expense->getExpenseDate(), PDO::PARAM_STR);
		$query -> bindValue (':comment', $expense->getComment(), PDO::PARAM_STR);
		$query -> bindValue (':expenseId', $expense->getId(), PDO::PARAM_STR);
		
		if ($query -> execute()) return ACTION_OK;
		else return ACTION_FAILED;	
	}
	
		function editExpense($id)
	{
		if (!isset($_POST['amount']) || !isset($_POST['date']) || !isset($_POST['comment']) || !isset($_POST['categoryId']) ||  !isset($_POST['paymentMethodId']))
			return FORM_DATA_MISSING;
		
		$amount = filter_input(INPUT_POST, 'amount');
	    $amountChecker = new Amount();
		if(!$amountChecker -> checkAmount($amount))
			return INVALID_DATA;
		
		if ($_POST['date'] =="")
			return FORM_DATA_MISSING;
		
		$date = filter_input(INPUT_POST, 'date');
		
		 if ($date > date('Y-m-d'))
			return INVALID_DATA;
		
		$comment = filter_input(INPUT_POST, 'comment');
		$categoryId = (int) $_POST['categoryId'];
		if($categoryId < 1)
			return INVALID_DATA;
		
		$paymentMethodId = (int) $_POST['paymentMethodId'];
		if($paymentMethodId < 1)
			return INVALID_DATA;
		
		$expense = new Expense($id, $_SESSION['loggedUser']->id, $amount, $date, $paymentMethodId, $categoryId, $comment);
		return $this->updateExpense($expense);

	}
	
	function addNewExpense()
	{
		if (!isset($_POST['amount']) || !isset($_POST['date']))
			return FORM_DATA_MISSING;
		
		$isAllOk = true;
		
		$amount = filter_input(INPUT_POST, 'amount');
		
		$amountChecker = new Amount();
		if(!$isAllOk = $amountChecker -> checkAmount($amount))
		$_SESSION ['amountError'] = "Wprowadź poprawną kwotę!";	
		
		if ($_POST['date'] =="")
		{
			$isAllOk = false;
			$_SESSION['dateError'] = "Musisz podać datę!";
		}
		else{
			$date = filter_input(INPUT_POST, 'date');
			$dateDifference = (strtotime(date('Y-m-d')) - strtotime($date)) / (60*60*24);
			
			 if ($dateDifference > 90)
			{
				$isAllOk = false;
				$_SESSION['dateError'] = "Możesz dodać przychód maksymalnie sprzed 90 dni!";
			}  
			else if ($date > date('Y-m-d'))
			{
				$isAllOk = false;
				$_SESSION['dateError'] = "Nie mów hop Panie Marty Mcfly! ;)";
			} 	
		}
	
		if (!isset($_POST['category']))
		{
			$isAllOk = false;
			$_SESSION['categoryError'] = "Zaznacz odpowiednią kategorię!";
		}
		else $_SESSION['categorySes'] = $_POST['category'];
		
		if (!isset($_POST['paymentMethod']))
		{
			$isAllOk = false;
			$_SESSION['paymentMethodError'] = "Zaznacz metodę płatności!";
		}
		else $_SESSION['paymentMethodSes'] = $_POST['paymentMethod'];
		
		$comment = isset($_POST['comment']) ? filter_input(INPUT_POST, 'comment') : "";
		
		$_SESSION['dateSes'] = $_POST['date'];
		$_SESSION['amountSes'] = $_POST['amount'];
		$_SESSION['commentSes'] = $comment;
	
		if (!$isAllOk) return FORM_DATA_MISSING;
		
		$newExpense = new Expense(NULL, $_SESSION['loggedUser']->id, $amount, $date, (int)$_POST['paymentMethod'], (int)$_POST['category'], $comment);
		return $this->addNewExpenseToBase($newExpense);
	}
	
	function returnCategoriesArrayExceptOthers()
	{
		$categories = array();
		
		if($result = $this->dbo->query("SELECT `id`, `name`, `position`, `limit` FROM expenses_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name <> 'Inne' ORDER BY position"))
			$categories = $result->fetchAll(PDO::FETCH_OBJ);
		
		return $categories;
	}
	
	function returnCategoriesArray()
	{
		$categories = array();
		
		if($result = $this->dbo->query("SELECT `id`, `name`, `position`, `limit` FROM expenses_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} ORDER BY position"))
			$categories = $result->fetchAll(PDO::FETCH_OBJ);
		
		return $categories;
	}
	
	function returnLastAddedExpenses($lastAddedExpensesAmount)
	{
		$lastAddedExpenses = array();
		
		if($result = $this->dbo->query("SELECT expenses.id, expenses_category_assigned_to_users.name, expenses.amount, expenses.date FROM expenses, expenses_category_assigned_to_users WHERE expenses.user_id={$_SESSION['loggedUser']->id} AND expenses_category_assigned_to_users.id=expenses.expense_category_assigned_to_user_id ORDER BY expenses.id DESC LIMIT {$lastAddedExpensesAmount}"))
			$lastAddedExpenses = $result->fetchAll(PDO::FETCH_OBJ);
		return $lastAddedExpenses;
	}
	
	
	function returnCategorySumArray($expenses)
	{
		$expenseCategorySum = array();		
		foreach ($expenses as $expense) {
			$expenseCategorySum [$expense->categoryName] = isset($expenseCategorySum[$expense->categoryName]) ?  $expense -> amount + $expenseCategorySum [$expense -> categoryName] : $expense -> amount;
		}	
		return $expenseCategorySum;
	}
	
	function returnPaymentMethodsArray()
	{
		$paymentMethods = array();
		
		if($result = $this->dbo->query("SELECT id, name, position FROM payment_methods_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} ORDER BY position"))
			$paymentMethods = $result->fetchAll(PDO::FETCH_OBJ);
		
		return $paymentMethods;
	}
	
	function returnPaymentMethodsArrayExceptOther()
	{
		$paymentMethods = array();
		
		if($result = $this->dbo->query("SELECT id, name, position FROM payment_methods_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name <> 'Inny' ORDER BY position"))
			$paymentMethods = $result->fetchAll(PDO::FETCH_OBJ);
		
		return $paymentMethods;
	}
	
	
	function showExpenseAddingForm()
	{
		$categories = $this -> returnCategoriesArray();
		$paymentMethods = $this -> returnPaymentMethodsArray();
			
		include 'scripts/fadeInScripts.php';
		include 'scripts/expenseAddingFormScripts.php';
		include 'templates/expenseAddingForm.php';
	}
	
	function groupSortedIncomesByCategoryIdWithBubbleSort(&$my_array )
	{
		do
		{
			$swapped = false;
			for( $i = 0, $c = count($my_array) - 1; $i < $c; $i++ )
			{
				if( $my_array[$i]->categoryId > $my_array[$i + 1]->categoryId )
				{
					$temp = $my_array[$i + 1];
					$my_array[$i + 1] = $my_array[$i];
					$my_array[$i] = $temp;
				
					$swapped = true;
				}
			}
		}
		while($swapped);
	}
	
	/*function groupSortedIncomesByCategoryId(&$expenses)
	{
		usort($expenses, function($a, $b)
		{
		return strcmp($a->categoryId, $b->categoryId);
		});
	}*/
	
	function returnExpensesFromChosenPeriod()
	{
		$query = $this -> dbo -> query("SELECT expenses.id as expenseId, expenses_category_assigned_to_users.name as categoryName, expenses_category_assigned_to_users.id as categoryId, expenses.payment_method_assigned_to_user_id as paymentMethodId, payment_methods_assigned_to_users.name as paymentMethodName, expenses.amount, expenses.date as expenseDate, expenses.comment FROM expenses, expenses_category_assigned_to_users, payment_methods_assigned_to_users WHERE expenses.user_id={$_SESSION['loggedUser']->id}  AND expenses_category_assigned_to_users.id=expenses.expense_category_assigned_to_user_id AND expenses.payment_method_assigned_to_user_id=payment_methods_assigned_to_users.id AND expenses.date BETWEEN '{$_SESSION['dateFrom']}' AND '{$_SESSION['dateTo']}' ORDER BY expenses.{$_SESSION['sortColumn']} {$_SESSION['sortType']}");
		$expenses = $query->fetchAll(PDO::FETCH_OBJ);
		
		$this->groupSortedIncomesByCategoryIdWithBubbleSort($expenses);
		
		return $expenses;
	}
	
	function checkIfCategoryNameExists($categoryName)
	{
		$query = $this->dbo->query("SELECT id from expenses_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name='{$categoryName}'");
		if ($query-> rowCount()) return true;
		return false;
	}
	
	function checkIfPaymentMethodNameExists($categoryName)
	{
		$query = $this->dbo->query("SELECT id from payment_methods_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name='{$categoryName}'");
		if ($query-> rowCount()) return true;
		return false;
	}
	
	function addNewExpenseCategory()
	{
		if( !$this->dbo) return SERVER_ERROR;
		if (!isset($_POST['newCategoryName']) || $_POST['newCategoryName'] == '') return FORM_DATA_MISSING;
	  
		$newCategoryName = filter_input(INPUT_POST, 'newCategoryName');
		$newCategoryName = mb_convert_case($newCategoryName, MB_CASE_TITLE, "UTF-8");
	  
		if($this->checkIfCategoryNameExists($newCategoryName)) return CATEGORY_NAME_ALREADY_EXISTS;
	  
		if(!$query = $this->dbo->query("SELECT id, position FROM expenses_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name='Inne'"))
			return ACTION_FAILED;
		
		$otherCategoryData = $query ->fetch(PDO::FETCH_OBJ);
		
		if(!$query = $this->dbo->query("UPDATE expenses_category_assigned_to_users SET position=position+1 WHERE id={$otherCategoryData->id}"))
			return ACTION_FAILED;
				
		$query = $this->dbo->prepare("INSERT INTO expenses_category_assigned_to_users (id, user_id, name, position) VALUES (NULL, {$_SESSION['loggedUser']->id}, :newCategoryName, {$otherCategoryData->position})");
		$query->bindValue(':newCategoryName', $newCategoryName, PDO::PARAM_STR);	
		
		if (!$query -> execute()) return ACTION_FAILED;
		return ACTION_OK;	  
	}
	
	function addNewPaymentMethod()
	{
		if( !$this->dbo) return SERVER_ERROR;
		if (!isset($_POST['newCategoryName']) || $_POST['newCategoryName'] == '') return FORM_DATA_MISSING;
	  
		$newCategoryName = filter_input(INPUT_POST, 'newCategoryName');
		$newCategoryName = mb_convert_case($newCategoryName, MB_CASE_TITLE, "UTF-8");
	  
		if($this->checkIfPaymentMethodNameExists($newCategoryName)) return CATEGORY_NAME_ALREADY_EXISTS;
	  
		if(!$query = $this->dbo->query("SELECT id, position FROM payment_methods_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name='Inny'"))
			return ACTION_FAILED;
		
		$otherCategoryData = $query ->fetch(PDO::FETCH_OBJ);
		
		if(!$query = $this->dbo->query("UPDATE payment_methods_assigned_to_users SET position=position+1 WHERE id={$otherCategoryData->id}"))
			return ACTION_FAILED;
				
		$query = $this->dbo->prepare("INSERT INTO payment_methods_assigned_to_users (id, user_id, name, position) VALUES (NULL, {$_SESSION['loggedUser']->id}, :newCategoryName, {$otherCategoryData->position})");
		$query->bindValue(':newCategoryName', $newCategoryName, PDO::PARAM_STR);	
		
		if (!$query -> execute()) return ACTION_FAILED;
		return ACTION_OK;	  
	}
	
	function setNewCategoryName($categoryId , $categoryName)
	{
		if($this->checkIfCategoryNameExists($categoryName)) return CATEGORY_NAME_ALREADY_EXISTS;
		
		$query = $this->dbo->prepare("UPDATE expenses_category_assigned_to_users SET name=:categoryName WHERE id=:categoryId");
		$query->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);	
		$query->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);	
		
		if (!$query -> execute()) return ACTION_FAILED;
		return ACTION_OK;	  
	}
	
	function setNewCategoryLimit($categoryId, $categoryLimit)
	{
		$query = $this->dbo->prepare("UPDATE `expenses_category_assigned_to_users` SET `limit`=:categoryLimit WHERE id=:categoryId");
		$query->bindValue(':categoryLimit', $categoryLimit, PDO::PARAM_INT);	
		$query->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);	
		
		if (!$query -> execute()) return ACTION_FAILED;
		return ACTION_OK;	  	
	}
	
	function setNewPaymentMethodName($categoryId , $categoryName)
	{
		if($this->checkIfPaymentMethodNameExists($categoryName)) return CATEGORY_NAME_ALREADY_EXISTS;
		
		$query = $this->dbo->prepare("UPDATE payment_methods_assigned_to_users SET name=:categoryName WHERE id=:categoryId");
		$query->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);	
		$query->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);	
		
		if (!$query -> execute()) return ACTION_FAILED;
		return ACTION_OK;	  
	}
	
	function deleteCategory($id)
	{
		if(!$query = $this->dbo->query("SELECT name, position FROM expenses_category_assigned_to_users WHERE id={$id}"))
			return ACTION_FAILED;
		$category = $query ->fetch(PDO::FETCH_OBJ);
		
		$this->dbo->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$this->dbo->beginTransaction();
		
		if(!$this->dbo->query("UPDATE expenses SET comment=CONCAT(comment, ' (','{$category->name}',')') WHERE expense_category_assigned_to_user_id={$id}"))
			return ACTION_FAILED;
		
		if(!$query = $this->dbo->query("SELECT id FROM expenses_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name='Inne'"))
			return ACTION_FAILED;
		$otherCategoryData = $query ->fetch(PDO::FETCH_OBJ);
		
		if(!$this->dbo->query("UPDATE expenses SET expense_category_assigned_to_user_id={$otherCategoryData->id} WHERE expense_category_assigned_to_user_id={$id}"))
			return ACTION_FAILED;
		
		if(!$this->dbo->query("UPDATE expenses_category_assigned_to_users SET position=position-1 WHERE user_id={$_SESSION['loggedUser']->id} AND  position > {$category->position}"))
			return ACTION_FAILED;
		
		$query = "DELETE FROM expenses_category_assigned_to_users WHERE id=$id";
		
		if (!$this->dbo->exec($query)) return ACTION_FAILED;
		
		$this->dbo->commit();
		
		return ACTION_OK;
	}
	
	function deletePaymentMethodCategory($id)
	{
		if(!$query = $this->dbo->query("SELECT name, position FROM payment_methods_assigned_to_users WHERE id={$id}"))
			return ACTION_FAILED;
		$category = $query ->fetch(PDO::FETCH_OBJ);
		
		$this->dbo->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$this->dbo->beginTransaction();
		
		if(!$this->dbo->query("UPDATE expenses SET comment=CONCAT(comment, ' [','{$category->name}',']') WHERE payment_method_assigned_to_user_id={$id}"))
			return ACTION_FAILED;
		
		if(!$query = $this->dbo->query("SELECT id FROM payment_methods_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name='Inny'"))
			return ACTION_FAILED;
		$otherCategoryData = $query ->fetch(PDO::FETCH_OBJ);
		
		if(!$this->dbo->query("UPDATE expenses SET payment_method_assigned_to_user_id={$otherCategoryData->id} WHERE payment_method_assigned_to_user_id={$id}"))
			return ACTION_FAILED;
		
		if(!$this->dbo->query("UPDATE payment_methods_assigned_to_users SET position=position-1 WHERE user_id={$_SESSION['loggedUser']->id} AND  position > {$category->position}"))
			return ACTION_FAILED;
		
		$query = "DELETE FROM payment_methods_assigned_to_users WHERE id=$id";
		
		if (!$this->dbo->exec($query)) return ACTION_FAILED;
		
		$this->dbo->commit();
		
		return ACTION_OK;
	}
	
	function editCategoryPositions()
	{
		$this->dbo->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$this->dbo->beginTransaction();
		
		foreach($_POST['expenseCategories'] as $categoryId => $expenseCategoryPosition)
		{
			if(!$this->dbo->query("UPDATE expenses_category_assigned_to_users SET position='{$expenseCategoryPosition}' WHERE id={$categoryId}"))
				return ACTION_FAILED;
		}
		
		$this->dbo->commit();
		
		return ACTION_OK;
	}
	

	function editPaymentMethodPositions()
	{
		$this->dbo->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$this->dbo->beginTransaction();
		
		foreach($_POST['paymentMethods'] as $paymentMethodId => $paymentMethodPosition)
		{
			if(!$this->dbo->query("UPDATE payment_methods_assigned_to_users SET position='{$paymentMethodPosition}' WHERE id={$paymentMethodId}"))
				return ACTION_FAILED;
		}
		
		$this->dbo->commit();
		
		return ACTION_OK;
	}
	
	function returnExpenseCategorySumOfChosenPeriod()
	{
		if(isset($_POST['categoryId']) || isset($_POST['month']) || isset($_POST['year']))
		{
			$categoryId = (int)$_POST['categoryId'];
		
			if($query = $this->dbo->query("SELECT COALESCE(SUM(expenses.amount),0) as categorySum FROM expenses WHERE expense_category_assigned_to_user_id ={$categoryId} AND YEAR(expenses.date)={$_POST['year']} AND MONTH(expenses.date)={$_POST['month']}"))
			{
				$result = $query->fetch(PDO::FETCH_OBJ);
				
				return $result->categorySum;
			}
		}
	}
	
}
?>