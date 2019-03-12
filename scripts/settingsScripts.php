<script type="text/javascript">

var fadeInTime = 500;
var fadeOutTime = 200;

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
		$('#dataEdit').slideDown(fadeInTime);
		$('#dataDownArrow').slideUp(fadeInTime);
		isDataEditShown = true;
	}
	else
	{
		$('#dataDownArrow').slideDown(fadeOutTime);
		$('#dataEdit').slideUp(fadeOutTime);
		isDataEditShown = false;
		
		if(isNameEditFormShown) showNameEditForm();
		if(isPasswordEditFormShown) showPasswordEditForm();
	}	
}

function showNameEditForm()
{
	if(!isNameEditFormShown)
	{
		$('#name').fadeOut(fadeOutTime, function(){
			$('#nameEditForm').fadeIn(fadeOutTime); 
			isNameEditFormShown = true;
		});
		 
	}
	else
	{
		$('#nameEditForm').fadeOut(fadeOutTime, function(){
			$('#name').fadeIn(fadeOutTime); 
			isNameEditFormShown = false;
		});
	}	
}

function showPasswordEditForm()
{
	if(!isPasswordEditFormShown)
	{
		$('#passwordEditForm').fadeIn(fadeInTime);
		 isPasswordEditFormShown = true;
	}
	else
	{
		$('#passwordEditForm').fadeOut(fadeOutTime);
		isPasswordEditFormShown = false;
	}	
}


function showCategoryTypes()
{
	//var categoryTypes = document.getElementsByClassName('categoryTypes');
	
	if(!areCategoryTypesShown)
	{
		
		$('#categorriesDiv').slideDown(fadeInTime);
		$('#categoriesDownArrow').slideUp(fadeInTime);	
		areCategoryTypesShown = true;
		
	}
	else
	{
		$('#categoriesDownArrow').slideDown(fadeOutTime);
		$('#categorriesDiv').slideUp(fadeOutTime);	
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
		$('#incomeCategories').fadeIn(fadeInTime);
		areIncomeCategoriesShown = true;
	}
	else
	{
		$('#incomeCategories').fadeOut(fadeOutTime);
		areIncomeCategoriesShown = false;
		if(isIncomeCategoryPositionsEditFormShown) showIncomeCategoryPositionsEditForm();
	}
}

function showExpenseCategories()
{
	if(!areExpenseCategoriesShown)
	{
		$('#expenseCategories').fadeIn(fadeInTime);
		areExpenseCategoriesShown = true;
	}
	else
	{
		$('#expenseCategories').fadeOut(fadeOutTime);
		areExpenseCategoriesShown = false;
		
		if(isExpenseCategoryPositionsEditFormShown) showExpenseCategoryPositionsEditForm();
	}
}


function showPaymentMethods()
{
	if(!arePaymentMethodsShown)
	{
		$('#paymentMethods').fadeIn(fadeInTime);		
		arePaymentMethodsShown = true;
	}
	else
	{
		$('#paymentMethods').fadeOut(fadeOutTime);
		arePaymentMethodsShown = false;
		
		if(isPaymentMethodPositionsEditFormShown) showPaymentMethodPositionsEditForm();
	}
}

function showIncomeCategoryPositionsEditForm()
{
	if(!isIncomeCategoryPositionsEditFormShown)
	{
		$('.incomeEditIcons').fadeOut(fadeOutTime, function(){
			$('.incomeCategoryPosition').fadeIn(fadeInTime); 
			isIncomeCategoryPositionsEditFormShown = true;
		});
	}
	else
	{
		$('.incomeCategoryPosition').fadeOut(fadeOutTime, function(){
			$('.incomeEditIcons').fadeIn(fadeInTime); 
			isIncomeCategoryPositionsEditFormShown = false;
		});
	}
}

function showExpenseCategoryPositionsEditForm()
{
	if(!isExpenseCategoryPositionsEditFormShown)
	{
		$('.expenseEditIcons').fadeOut(fadeOutTime, function(){
			$('.expenseCategoryPosition').fadeIn(fadeInTime); 
			isExpenseCategoryPositionsEditFormShown = true;
		});
	}
	else
	{
		$('.expenseCategoryPosition').fadeOut(fadeOutTime, function(){
			$('.expenseEditIcons').fadeIn(fadeInTime); 
			isExpenseCategoryPositionsEditFormShown = false;
		});
	}
}

function showPaymentMethodPositionsEditForm()
{
	if(!isPaymentMethodPositionsEditFormShown)
	{
		$('.paymentMethodEditIcons').fadeOut(fadeOutTime, function(){
			$('.paymentMethodPosition').fadeIn(fadeInTime); 
			isPaymentMethodPositionsEditFormShown = true;
		});
	}
	else
	{
		$('.paymentMethodPosition').fadeOut(fadeOutTime, function(){
			$('.paymentMethodEditIcons').fadeIn(fadeInTime); 
			isPaymentMethodPositionsEditFormShown = false;
		});
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
	if(document.getElementById("lastAddedItems").style.display =="none")
	{
		$('#lastAddedItems').slideDown(fadeInTime);
		$('#incomeDownArrow').slideUp(fadeInTime);
	}
	else
	{
		$('#lastAddedItems').slideUp(fadeOutTime);
		$('#incomeDownArrow').slideDown(fadeOutTime);
		if(areLastAddedIncomesShown) showLastAddedIncomes();
		if(areLastAddedExpensesShown) showLastAddedExpenses();
	}
	
	
	
	/*
	
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
	
	*/
}

function showLastAddedIncomes()
{
	if(!areLastAddedIncomesShown)
	{
		$('#lastAddedIncomesEdit').fadeIn(fadeInTime);
		//document.getElementById("lastAddedIncomesEdit").style.display="table";
		areLastAddedIncomesShown = true;
	}
	else
	{
		$('#lastAddedIncomesEdit').fadeOut(fadeOutTime);
		//document.getElementById("lastAddedIncomesEdit").style.display="none";
		areLastAddedIncomesShown = false;
	}
}

function showLastAddedExpenses()
{
	if(!areLastAddedExpensesShown)
	{
		$('#lastAddedExpensesEdit').fadeIn(fadeInTime);
		areLastAddedExpensesShown = true;
	}
	else
	{
		$('#lastAddedExpensesEdit').fadeOut(fadeOutTime);
		areLastAddedExpensesShown = false;
	}
}

</script>