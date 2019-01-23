<script type="text/javascript">

var isDataEditShown = false;
var isNameEditFormShown = false;
var isPasswordEditFormShown = false;

var areCategoryTypesShown = false;

var areIncomeCategoriesShown = false;
var areExpenseCategoriesShown = false;
var arePaymentMethodsShown = false;

var isIncomeCategoryPositionsEditFormShown = false;
var isExpenseCategoryPositionsEditFormShown = false;
var isPaymentMethodPositionsEditFormShown = false;

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
		document.getElementById("name").style.display = "none";
		document.getElementById("nameEditForm").style.display = "inline";
		 isNameEditFormShown = true;
	}
	else
	{
		document.getElementById("nameEditForm").style.display = "none";
		document.getElementById("name").style.display = "inline";
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
	var categoryTypes = document.getElementsByClassName('categoryTypes');
	
	if(!areCategoryTypesShown)
	{
		for (var i = 0; i < categoryTypes.length; ++i) 
		{
			categoryTypes[i].style.display= 'table-row';
		}
		document.getElementById("categoriesDownArrow").style.display="none";
		areCategoryTypesShown = true;
	}
	else
	{
		for (var i = 0; i < categoryTypes.length; ++i) 
		{
			categoryTypes[i].style.display= 'none';
		}
		document.getElementById("categoriesDownArrow").style.display="block";
		areCategoryTypesShown = false;
		
		if(areIncomeCategoriesShown) showIncomeCategories();
		if(areExpenseCategoriesShown) showExpenseCategories();
		if(arePaymentMethodsShown) showPaymentMethods();
	}
}


function showIncomeCategories()
{
	if(!areIncomeCategoriesShown)
	{
		document.getElementById("incomeCategories").style.display = "table";
		areIncomeCategoriesShown = true;
	}
	else
	{
		document.getElementById("incomeCategories").style.display = "none";
		areIncomeCategoriesShown = false;
	
		if(isIncomeCategoryPositionsEditFormShown) showIncomeCategoryPositionsEditForm();
	}
}

function showExpenseCategories()
{
	if(!areExpenseCategoriesShown)
	{
		document.getElementById("expenseCategories").style.display = "table";
		areExpenseCategoriesShown = true;
	}
	else
	{
		document.getElementById("expenseCategories").style.display = "none";
		areExpenseCategoriesShown = false;
		
		if(isExpenseCategoryPositionsEditFormShown) showExpenseCategoryPositionsEditForm();
	}
}


function showPaymentMethods()
{
	if(!arePaymentMethodsShown)
	{
		document.getElementById("paymentMethods").style.display = "table";
		arePaymentMethodsShown = true;
	}
	else
	{
		document.getElementById("paymentMethods").style.display = "none";
		arePaymentMethodsShown = false;
		
		if(isPaymentMethodPositionsEditFormShown) showPaymentMethodPositionsEditForm();
	}
}

function showIncomeCategoryPositionsEditForm()
{
	var positions = document.getElementsByClassName('incomeCategoryPosition');
	var editIcons = document.getElementsByClassName('incomeEditIcons');
	
	if(!isIncomeCategoryPositionsEditFormShown)
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'table-cell';
		}
		for (var i = 0; i < editIcons.length; ++i) 
		{
			editIcons[i].style.display= 'none';
		}
		isIncomeCategoryPositionsEditFormShown = true;
	}
	else
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'none';
		}
		for (var i = 0; i < editIcons.length; ++i) 
		{
			editIcons[i].style.display= 'table-cell';
		}
		isIncomeCategoryPositionsEditFormShown = false;
	}
}

function showExpenseCategoryPositionsEditForm()
{
	var positions = document.getElementsByClassName('expenseCategoryPosition');
	var editIcons = document.getElementsByClassName('expenseEditIcons');
	
	if(!isExpenseCategoryPositionsEditFormShown)
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'table-cell';
		}
		for (var i = 0; i < editIcons.length; ++i) 
		{
			editIcons[i].style.display= 'none';
		}
		isExpenseCategoryPositionsEditFormShown = true;
	}
	else
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'none';
		}
		for (var i = 0; i < editIcons.length; ++i) 
		{
			editIcons[i].style.display= 'table-cell';
		}
		isExpenseCategoryPositionsEditFormShown = false;
	}
}

function showPaymentMethodPositionsEditForm()
{
	var positions = document.getElementsByClassName('paymentMethodPosition');
	var editIcons = document.getElementsByClassName('paymentMethodEditIcons');
	
	if(!isPaymentMethodPositionsEditFormShown)
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'table-cell';
		}
		for (var i = 0; i < editIcons.length; ++i) 
		{
			editIcons[i].style.display= 'none';
		}
		isPaymentMethodPositionsEditFormShown = true;
	}
	else
	{
		for (var i = 0; i < positions.length; ++i) 
		{
			positions[i].style.display= 'none';
		}
		for (var i = 0; i < editIcons.length; ++i) 
		{
			editIcons[i].style.display= 'table-cell';
		}
		isPaymentMethodPositionsEditFormShown = false;
	}
}

function closeModal(modalId)
{
	$('#'+modalId).modal('hide');
}

function removeItem(id)
{
	//highlightItem(id);
	var modalBody = 'Czy napewno chcesz usunąć wybraną kategorię?';
	modalBody += '<form action="index.php?action=removeCategory" method="post"><div class="buttons editButtons"><input type="hidden" name="itemToBeRemoved" value="'+id+'"><input type="submit" class="add" value="Tak"><input class="cancel" value="Anuluj" type="button" onclick="closeModal(\'modal\');" /></div></form>';
	
	document.getElementById("modalBody").innerHTML = modalBody;
	$('#modal').modal('show');
}




/*function showNewIncomeCategoryAddingForm()
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
			document.getElementById(id).innerHTML = '<div class="buttons editButtons"><input type="submit" class="add" value="Edytuj" onclick="showCategoryEditNameForm(\''+id+'\');"><input class="cancel" value="Usuń" type="button" onclick="showRemoveConfirmation(\''+id+'\');" /></div>';
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
		document.getElementById(id).innerHTML = '<form action="index.php?action=removeCategory" method="post"><div style="font-size: 16px; color: black; line-height: 15px;">Czy na pewno chcesz usunąć wybraną kategorię?</div><div class="buttons editButtons"><input type="hidden" name="itemToBeRemoved" value="'+id+'"><input type="submit" class="add" value="Tak"><input class="cancel" value="Anuluj" type="button" onclick="showCategoryEditOptions(\''+id+'\');" /></div></form>';
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
} */

function showNewCategoryAddingForm(actionName)
{
	var modalBody = '<form action="index.php?action='+actionName+'" method="post"><input class="commentGetting categoryNameGetting" type="text" name="newCategoryName" placeholder="Podaj nazwę kategorii" autocomplete="off"><div class="editButtons buttons" style="text-align: center;"><input type="submit" class="add" value="Dodaj"><input class="cancel" value="Anuluj" type="button" onclick="closeModal(\'modal\');"></div></form>';
	
	document.getElementById("modalBody").innerHTML = modalBody;
	$('#modal').modal('show');
}

function showCategoryEditNameForm(id)
{
	var categoryName = document.getElementById(id).innerHTML;
	
	var modalBody = '<form action="index.php?action=editCategoryName" method="post"><input class="commentGetting categoryNameGetting" type="text" name="newCategoryName" autocomplete="off" placeholder="Podaj nową nazwę" value="'+categoryName+'"><input type="hidden" name="typeOfCategory" value="'+id.substr(0,1)+'"><input type="hidden" name="categoryId" value="'+id.substr(1)+'"><div class="buttons editButtons"><input type="submit" class="add"  value="Zapisz"><input class="cancel" value="Anuluj" type="button" onclick="closeModal(\'modal\');"></div></form>';
	
	document.getElementById("modalBody").innerHTML = modalBody;
	$('#modal').modal('show');
}

function showLastAddedItemsShowLinks()
{
	if(document.getElementById("lastAddedIncomesShowLink").style.display =="none")
	{
		document.getElementById("lastAddedIncomesShowLink").style.display = "table-row";
		document.getElementById("lastAddedExpensesShowLink").style.display = "table-row";
		document.getElementById("incomeDownArrow").style.display="none";
	}
	else
	{
		document.getElementById("lastAddedIncomesShowLink").style.display="none";
		document.getElementById("lastAddedExpensesShowLink").style.display="none";
		document.getElementById("incomeDownArrow").style.display="inline";
		if(areLastAddedIncomesShown) showLastAddedIncomes();
		if(areLastAddedExpensesShown) showLastAddedExpenses();
			
	}
}

function showLastAddedIncomes()
{
	if(!areLastAddedIncomesShown)
	{
		document.getElementById("lastAddedIncomesEdit").style.display="table";
		areLastAddedIncomesShown = true;
	}
	else
	{
		document.getElementById("lastAddedIncomesEdit").style.display="none";
		areLastAddedIncomesShown = false;
	}
}

function showLastAddedExpenses()
{
	if(!areLastAddedExpensesShown)
	{
		document.getElementById("lastAddedExpensesEdit").style.display="table";
		areLastAddedExpensesShown = true;
	}
	else
	{
		document.getElementById("lastAddedExpensesEdit").style.display="none";
		areLastAddedExpensesShown = false;
	}
}

</script>