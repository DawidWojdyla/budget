<?php
class Incomes
{
	private $dbo = null;
	
	function __construct($dbo)
	{
		$this->dbo = $dbo;
	}
	
	function addNewIncomeToBase($income)
	{
		if( !$this->dbo) return SERVER_ERROR;
		
		$query  = $this->dbo -> prepare ("INSERT INTO `incomes` VALUES (NULL, :userId, :categoryId, :amount, :date, :comment)");
		$query -> bindValue (':userId', $income->getUserId(), PDO::PARAM_INT);
		$query -> bindValue (':categoryId', $income->getCategoryId(), PDO::PARAM_INT);
		$query -> bindValue (':amount', $income->getAmount(), PDO::PARAM_STR);
		$query -> bindValue (':date', $income->getIncomeDate(), PDO::PARAM_STR);
		$query -> bindValue (':comment', $income->getComment(), PDO::PARAM_STR);
		
		if ($query -> execute()){
		unset($_SESSION['amountSes']);
		unset($_SESSION['dateSes']);
		unset($_SESSION['categorySes']);
		unset($_SESSION['commentSes']);
		return ACTION_OK;
		}
		else return ACTION_FAILED;	
	}
	
	function deleteIncome($incomeId)
	{
		$query = "DELETE FROM `incomes` WHERE id=$incomeId";
		
		if ($this->dbo->exec($query) !== false) return ACTION_OK;
		else return ACTION_FAILED;	
	}
	
	function updateIncome($income)
	{
		
		$query = $this -> dbo -> prepare ("UPDATE `incomes` SET income_category_assigned_to_user_id=:categoryId, amount=:amount, date=:date, comment=:comment WHERE id=:incomeId");
		$query -> bindValue (':categoryId', $income->getCategoryId(), PDO::PARAM_INT);
		$query -> bindValue (':amount', $income->getAmount(), PDO::PARAM_STR);
		$query -> bindValue (':date', $income->getIncomeDate(), PDO::PARAM_STR);
		$query -> bindValue (':comment', $income->getComment(), PDO::PARAM_STR);
		$query -> bindValue (':incomeId', $income->getId(), PDO::PARAM_STR);
		
		if ($query -> execute()) return ACTION_OK;
		else return ACTION_FAILED;	
	}
	
	function editIncome($id)
	{
		if (!isset($_POST['amount']) || !isset($_POST['date']) || !isset($_POST['comment']) || !isset($_POST['categoryId']))
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
		
		$income = new Income($id, $_SESSION['loggedUser']->id, $amount, $date, $categoryId, $comment);
		return $this->updateIncome($income);
	}
	
	function addNewIncome()
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
			
			 if ($dateDifference > 366)
			{
				$isAllOk = false;
				$_SESSION['dateError'] = "Możesz dodać przychód maksymalnie sprzed roku!";
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
		
		$comment = isset($_POST['comment']) ? filter_input(INPUT_POST, 'comment') : "";
		
		$_SESSION['dateSes'] = $_POST['date'];
		$_SESSION['amountSes'] = $_POST['amount'];
		$_SESSION['commentSes'] = $comment;
	
		if (!$isAllOk) return FORM_DATA_MISSING;
		
		$newIncome = new Income(NULL, $_SESSION['loggedUser']->id, $amount, $date, (int)$_POST['category'], $comment);
		return $this->addNewIncomeToBase($newIncome);
	}
	
	function returnCategoriesArray()
	{
		$categories = array();
		
		if($result = $this->dbo->query("SELECT id, name, position FROM incomes_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} ORDER BY position"))
			$categories = $result->fetchAll(PDO::FETCH_OBJ);
		return $categories;
	}
	
	function returnCategoriesArrayExceptOthers()
	{
		$categories = array();
		
		if($result = $this->dbo->query("SELECT id, name, position FROM incomes_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name <> 'Inne' ORDER BY position"))
			$categories = $result->fetchAll(PDO::FETCH_OBJ);
		return $categories;
	}
	
	function returnLastAddedIncomes($lastAddedIncomesAmount)
	{
		$lastAddedIncomes = array();
		
		if($result = $this->dbo->query("SELECT incomes.id, incomes_category_assigned_to_users.name, incomes.amount, incomes.date FROM incomes, incomes_category_assigned_to_users WHERE incomes.user_id={$_SESSION['loggedUser']->id} AND incomes_category_assigned_to_users.id=incomes.income_category_assigned_to_user_id ORDER BY incomes.id DESC LIMIT {$lastAddedIncomesAmount}"))
			$lastAddedIncomes = $result->fetchAll(PDO::FETCH_OBJ);
		return $lastAddedIncomes;
	}
	
	function returnCategorySumArray($incomes)
	{
		$incomeCategorySum = array();		
		foreach ($incomes as $income) {
			$incomeCategorySum [$income->categoryName] = isset($incomeCategorySum[$income->categoryName]) ?  $income -> amount + $incomeCategorySum [$income -> categoryName] : $income -> amount;
		}	
		return $incomeCategorySum;
	}
	
	function showIncomeAddingForm()
	{
		$categories = $this->returnCategoriesArray();
			
		include 'scripts/fadeInScripts.php';
		include 'templates/incomeAddingForm.php';
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

	//function groupSortedIncomesByCategoryId($incomes)
	//{
		//uasort($incomes, function($a, $b)
		//{
			//return strcmp($a->categoryId, $b->categoryId);
			//return $a->categoryId > $b->categoryId;
			// if($a->categoryId != $b->categoryId)
			//{
				//return strcmp($a->categoryId, $b->categoryId);
			//}
			//return $a->incomeDate - $b->incomeDate;
			//return $a->categoryId - $b->categoryId;
			
		//});
		
		//$result = array();
		//foreach ($incomes as $income) {
			//$result[$income->categoryId][] = $income;
		//}
		//return $result;
		
	//}
	
	function returnIncomesFromChosenPeriod()
	{
		$query = $this->dbo->query("SELECT incomes.id as incomeId, incomes_category_assigned_to_users.name as categoryName, incomes_category_assigned_to_users.id as categoryId, incomes.amount, incomes.date as incomeDate, incomes.comment FROM incomes, incomes_category_assigned_to_users WHERE incomes.user_id={$_SESSION['loggedUser']->id}  AND incomes_category_assigned_to_users.id=incomes.income_category_assigned_to_user_id AND incomes.date BETWEEN '{$_SESSION['dateFrom']}' AND '{$_SESSION['dateTo']}' ORDER BY incomes.{$_SESSION['sortColumn']} {$_SESSION['sortType']}");
		$incomes = $query->fetchAll(PDO::FETCH_OBJ);
		
		$this->groupSortedIncomesByCategoryIdWithBubbleSort($incomes);
		
		return $incomes;
	}
	
	function checkIfCategoryNameExists($categoryName)
	{
		$query = $this->dbo->query("SELECT id from incomes_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name='{$categoryName}'");
		if ($query-> rowCount()) return true;
		return false;
	}
	
	function addNewIncomeCategory()
	{
		if( !$this->dbo) return SERVER_ERROR;
		if (!isset($_POST['newCategoryName']) || $_POST['newCategoryName'] == '') return FORM_DATA_MISSING;
	  
		$newCategoryName = filter_input(INPUT_POST, 'newCategoryName');
		$newCategoryName = mb_convert_case($newCategoryName, MB_CASE_TITLE, "UTF-8");
		
		if($this->checkIfCategoryNameExists($newCategoryName)) return CATEGORY_NAME_ALREADY_EXISTS;
	  
		if(!$query = $this->dbo->query("SELECT id, position FROM incomes_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name='Inne'"))
			return ACTION_FAILED;
		
		$otherCategoryData = $query ->fetch(PDO::FETCH_OBJ);
		
		if(!$query = $this->dbo->query("UPDATE incomes_category_assigned_to_users SET position=position+1 WHERE id={$otherCategoryData->id}"))
			return ACTION_FAILED;
				
		$query = $this->dbo->prepare("INSERT INTO incomes_category_assigned_to_users (id, user_id, name, position) VALUES (NULL, {$_SESSION['loggedUser']->id}, :newCategoryName, {$otherCategoryData->position})");
		$query->bindValue(':newCategoryName', $newCategoryName, PDO::PARAM_STR);	
		
		if (!$query -> execute()) return ACTION_FAILED;
		return ACTION_OK;	  
	}
	
	function setNewCategoryName($categoryId , $categoryName)
	{
		if($this->checkIfCategoryNameExists($categoryName)) return CATEGORY_NAME_ALREADY_EXISTS;
		
		$query = $this->dbo->prepare("UPDATE incomes_category_assigned_to_users SET name=:categoryName WHERE id=:categoryId");
		$query->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);	
		$query->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);	
		
		if ($query -> execute()) return ACTION_OK;
		else return ACTION_FAILED;	  
	}
	
	function deleteCategory($id)
	{
		if(!$query = $this->dbo->query("SELECT name, position FROM incomes_category_assigned_to_users WHERE id={$id}"))
			return ACTION_FAILED;
		$category = $query ->fetch(PDO::FETCH_OBJ);
		
		$this->dbo->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$this->dbo->beginTransaction();
		
		if(!$this->dbo->query("UPDATE incomes SET comment=CONCAT(comment, ' (','{$category->name}',')') WHERE income_category_assigned_to_user_id={$id}"))
			return ACTION_FAILED;
		
		if(!$query = $this->dbo->query("SELECT id FROM incomes_category_assigned_to_users WHERE user_id={$_SESSION['loggedUser']->id} AND name='Inne'"))
			return ACTION_FAILED;
		$otherCategoryData = $query ->fetch(PDO::FETCH_OBJ);
		
		if(!$this->dbo->query("UPDATE incomes SET income_category_assigned_to_user_id={$otherCategoryData->id} WHERE income_category_assigned_to_user_id={$id}"))
			return ACTION_FAILED;
		
		if(!$this->dbo->query("UPDATE incomes_category_assigned_to_users SET position=position-1 WHERE user_id={$_SESSION['loggedUser']->id} AND  position > {$category->position}"))
			return ACTION_FAILED;
		
		$query = "DELETE FROM incomes_category_assigned_to_users WHERE id=$id";
		
		if (!$this->dbo->exec($query)) return ACTION_FAILED;
		
		$this->dbo->commit();
		
		return ACTION_OK;
	}
	
	function editCategoryPositions()
	{
		$this->dbo->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$this->dbo->beginTransaction();
		
		foreach($_POST['incomeCategories'] as $categoryId => $incomeCategoryPosition)
		{
			if(!$this->dbo->query("UPDATE incomes_category_assigned_to_users SET position='{$incomeCategoryPosition}' WHERE id={$categoryId}"))
				return ACTION_FAILED;
		}
		
		$this->dbo->commit();
		
		return ACTION_OK;
	}
}
?>