<script type="text/javascript">

var isDataEditShown = false;
var isNameEditFormShown = false;
var isPasswordEditFormShown = false;

var areCategoryTypesShown = false;

var areIncomeCategoriesShown = false;
var areExpenseCategoriesShown = false;

var isIncomeCategoryPositionsEditFormShown = false;
var isExpenseCategoryPositionsEditFormShown = false;

var isNewIncomeCategoryAddingFormShown = false;
var isNewExpenseCategoryAddingFormShown = false;

var lastChosenCategoryId = null;

var areLastAddedIncomesShown = false;
var areLastAddedExpensesShown = false;


function showDataEdition()
{
	if(!isDataEditShown)
	{
		document.getElementById("dataEdit").style.display = "inline";
		document.getElementById("dataDownArrow").style.display="none";
		 isDataEditShown = true;
	}
	else
	{
		document.getElementById("dataEdit").style.display = "none";
		document.getElementById("dataDownArrow").style.display="inline";
		isDataEditShown = false;
		
		if(isNameEditFormShown) showNameEditForm();
		if(isPasswordEditFormShown) showPasswordEditForm();
	}	
}

function showNameEditForm()
{
	if(!isNameEditFormShown)
	{
		document.getElementById("nameEditForm").style.display = "inline";
		 isNameEditFormShown = true;
	}
	else
	{
		document.getElementById("nameEditForm").style.display = "none";
		isNameEditFormShown = false;
	}	
}

function showPasswordEditForm()
{
	if(!isPasswordEditFormShown)
	{
		document.getElementById("passwordEditForm").style.display = "inline";
		 isPasswordEditFormShown = true;
	}
	else
	{
		document.getElementById("passwordEditForm").style.display = "none";
		isPasswordEditFormShown = false;
	}	
}


function showCategoryTypes()
{
	if(!areCategoryTypesShown)
	{
		document.getElementById("categoryTypes").style.display = "inline";
		document.getElementById("categoriesDownArrow").style.display="none";
		areCategoryTypesShown = true;
	}
	else
	{
		document.getElementById("categoryTypes").style.display = "none";
		document.getElementById("categoriesDownArrow").style.display="inline";
		areCategoryTypesShown = false;
		
		if(areIncomeCategoriesShown) showIncomeCategories();
		if(areExpenseCategoriesShown) showExpenseCategories();
	}
}

function showIncomeCategories()
{
	if(!areIncomeCategoriesShown)
	{
		document.getElementById("incomeCategories").style.display = "inline";
		document.getElementById("incomeCategoriesEditOption").style.display = "inline";
		areIncomeCategoriesShown = true;
	}
	else
	{
		document.getElementById("incomeCategories").style.display = "none";
		document.getElementById("incomeCategoriesEditOption").style.display = "none";
		areIncomeCategoriesShown = false;
		
		if(isIncomeCategoryPositionsEditFormShown) showIncomeCategoryPositionsEditForm();
		if(isNewIncomeCategoryAddingFormShown) showNewIncomeCategoryAddingForm();
		if(lastChosenCategoryId.substr(0,1) == 'i') showCategoryEditOptions(lastChosenCategoryId);
	}
}

function showExpenseCategories()
{
	if(!areExpenseCategoriesShown)
	{
		document.getElementById("expenseCategories").style.display = "inline";
		document.getElementById("expenseCategoriesEditOption").style.display = "inline";
		areExpenseCategoriesShown = true;
	}
	else
	{
		document.getElementById("expenseCategories").style.display = "none";
		document.getElementById("expenseCategoriesEditOption").style.display = "none";
		areExpenseCategoriesShown = false;
		
		if(isExpenseCategoryPositionsEditFormShown) showIncomeCategoryPositionsEditForm();
		if(isNewExpenseCategoryAddingFormShown) showNewIncomeCategoryAddingForm();
		if(lastChosenCategoryId.substr(0,1) == 'e') showCategoryEditOptions(lastChosenCategoryId);
	}
}

function showIncomeCategoryPositionsEditForm()
{
	var positions = document.getElementsByClassName('incomeCategoryPosition');
	
	if(!isIncomeCategoryPositionsEditFormShown)
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'inline';
		}
		isIncomeCategoryPositionsEditFormShown = true;
	}
	else
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'none';
		}
		isIncomeCategoryPositionsEditFormShown = false;
	}
}

function showExpenseCategoryPositionsEditForm()
{
	var positions = document.getElementsByClassName('expenseCategoryPosition');
	
	if(!isExpenseCategoryPositionsEditFormShown)
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'inline';
		}
		isExpenseCategoryPositionsEditFormShown = true;
	}
	else
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'none';
		}
		isExpenseCategoryPositionsEditFormShown = false;
	}
}

function showNewIncomeCategoryAddingForm()
{
	if(!isNewIncomeCategoryAddingFormShown)
	{
		document.getElementById("newIncomeCategoryAddingForm").style.display="inline";
		isNewIncomeCategoryAddingFormShown = true;
	}
	else
	{
		document.getElementById("newIncomeCategoryAddingForm").style.display="none";
		isNewIncomeCategoryAddingFormShown = false;
	}	
}

function showNewExpenseCategoryAddingForm()
{
	if(!isNewExpenseCategoryAddingFormShown)
	{
		document.getElementById("newExpenseCategoryAddingForm").style.display="inline";
		isNewExpenseCategoryAddingFormShown = true;
	}
	else
	{
		document.getElementById("newExpenseCategoryAddingForm").style.display="none";
		isNewExpenseCategoryAddingFormShown = false;
	}	
}

function showCategoryEditOptions(id)
{
	 if(lastChosenCategoryId != id && lastChosenCategoryId != null)
		{
			document.getElementById(lastChosenCategoryId).innerHTML = '';
			highlightItem(lastChosenCategoryId);
		}
		 if (document.getElementById(id).innerHTML == '')
		 {
			document.getElementById(id).innerHTML = '<div class="buttons editButtons" style="margin-top:-4px; margin-bottom:-1px;"><input type="submit" class="add" value="Edytuj" onclick="showCategoryEditNameForm(\''+id+'\');"><input class="cancel" value="Usuń" type="button" onclick="showRemoveConfirmation(\''+id+'\');" /></div>';
			highlightItem(id);
			lastChosenCategoryId = id;
		}
		else{
			document.getElementById(id).innerHTML = '';
			highlightItem(id);
			lastChosenCategoryId = null;
		}
}

function showRemoveConfirmation(id)
	{
		document.getElementById(id).innerHTML = '<form action="index.php?action=removeCategory" method="post"><div style="font-size: 16px; color: black; margin-bottom:-10px; line-height: 15px;">Czy na pewno chcesz usunąć wybraną kategorię?</div><div class="buttons editButtons" style="margin-bottom:-4px;"><input type="hidden" name="itemToBeRemoved" value="'+id+'"><input type="submit" class="add" value="Tak"><input class="cancel" value="Anuluj" type="button" onclick="showCategoryEditOptions(\''+id+'\');" /></div></form>';
	}

function highlightItem(id)
	{
		if(document.getElementById(id+'s').style.color != "red"){
			document.getElementById(id+'s').style.color = "red";
		}
		else{
			document.getElementById(id+'s').style.color = "#333";
		}
	}
	

function showCategoryEditNameForm(id)
{
	document.getElementById(id).innerHTML = '<form action="index.php?action=editCategoryName" method="post"><input class="commentGetting" type="text" name="newCategoryName" placeholder="Podaj nową nazwę" ><input type="hidden" name="typeOfCategory" value="'+id.substr(0,1)+'"><input type="hidden" name="categoryId" value="'+id.substr(1)+'"><div class="buttons editButtons noMargin"><input type="submit" value="Zapisz"><input class="cancel" value="Anuluj" type="button" onclick="showCategoryEditOptions(\''+id+'\');"></div></form>';
}

function showLastAddedIncomes()
{
	if(!areLastAddedIncomesShown)
	{
		document.getElementById("lastAddedIncomesEdit").style.display="inline";
		document.getElementById("incomeDownArrow").style.display="none";
		areLastAddedIncomesShown = true;
	}
	else
	{
		document.getElementById("lastAddedIncomesEdit").style.display="none";
		document.getElementById("incomeDownArrow").style.display="inline";
		areLastAddedIncomesShown = false;
	}
}

function showLastAddedExpenses()
{
	if(!areLastAddedExpensesShown)
	{
		document.getElementById("lastAddedExpensesEdit").style.display="inline";
		document.getElementById("expenseDownArrow").style.display="none";
		areLastAddedExpensesShown = true;
	}
	else
	{
		document.getElementById("lastAddedExpensesEdit").style.display="none";
		document.getElementById("expenseDownArrow").style.display="inline";
		areLastAddedExpensesShown = false;
	}
}


</script>