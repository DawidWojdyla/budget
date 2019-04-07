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

var areLastAddedItemsShowLinksShown = false;
var areLastAddedIncomesShown = false;
var areLastAddedExpensesShown = false;


function showDataEdition()
{
	if(!isDataEditShown)
	{
		if(areCategoryTypesShown) showCategoryTypes();
		if(areLastAddedItemsShowLinksShown) showLastAddedItemsShowLinks();
		$('#dataEdit').slideDown(fadeInTime);
		document.getElementById("dataEditLink").className = "tableHead pointer borderWhenHover";
		isDataEditShown = true;
	}
	else
	{
		$('#dataEdit').slideUp(fadeOutTime);
		document.getElementById("dataEditLink").className = "editClick tableHead";
		isDataEditShown = false;
		
		if(isNameEditFormShown) showNameEditForm();
		if(isPasswordEditFormShown) showPasswordEditForm();
	}	
}

function showNameEditForm()
{
	if(!isNameEditFormShown)
	{
		if(isPasswordEditFormShown) showPasswordEditForm();
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
		if(isNameEditFormShown) showNameEditForm();
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
		if(isDataEditShown) showDataEdition();
		if(areLastAddedItemsShowLinksShown) showLastAddedItemsShowLinks();
		$('#categorriesDiv').slideDown(fadeInTime);
		document.getElementById("categoryEditLink").className = "tableHead pointer borderWhenHover";
		areCategoryTypesShown = true;
		
	}
	else
	{
		$('#categorriesDiv').slideUp(fadeOutTime);	
		document.getElementById("categoryEditLink").className = "editClick tableHead";
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
		//if(areExpenseCategoriesShown) showExpenseCategories();
		//if(arePaymentMethodsShown) showPaymentMethods();
		$('#incomeCategories').fadeIn(fadeInTime);
		document.getElementById("incomeCategoriesShowLink").className = " tableHead link pointer borderWhenHover";
		areIncomeCategoriesShown = true;
	}
	else
	{
		$('#incomeCategories').fadeOut(fadeOutTime);
		document.getElementById("incomeCategoriesShowLink").className = "attributes editClick";
		areIncomeCategoriesShown = false;
		if(isIncomeCategoryPositionsEditFormShown) showIncomeCategoryPositionsEditForm();
	}
}

function showExpenseCategories()
{
	if(!areExpenseCategoriesShown)
	{
		//if(areIncomeCategoriesShown) showIncomeCategories();
		//if(arePaymentMethodsShown) showPaymentMethods();
		$('#expenseCategories').fadeIn(fadeInTime);
		document.getElementById("expenseCategoriesShowLink").className = " tableHead link pointer borderWhenHover";
		areExpenseCategoriesShown = true;
	}
	else
	{
		$('#expenseCategories').fadeOut(fadeOutTime);
		document.getElementById("expenseCategoriesShowLink").className = "attributes editClick";
		areExpenseCategoriesShown = false;
		
		if(isExpenseCategoryPositionsEditFormShown) showExpenseCategoryPositionsEditForm();
	}
}


function showPaymentMethods()
{
	if(!arePaymentMethodsShown)
	{
		//if(areIncomeCategoriesShown) showIncomeCategories();
		//if(areExpenseCategoriesShown) showExpenseCategories();
		$('#paymentMethods').slideDown(fadeInTime);		
		document.getElementById("paymentMethodsShowLink").className = " tableHead link pointer borderWhenHover";
		arePaymentMethodsShown = true;
	}
	else
	{
		$('#paymentMethods').slideUp(fadeOutTime);
		document.getElementById("paymentMethodsShowLink").className = "attributes editClick";
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
	var modalBody = '<div class="tableHead">Usunąć wybraną kategorię?</div>';
	modalBody += '<form action="index.php?action=removeCategory" method="post"><div class="buttons editButtons"><input type="hidden" name="itemToBeRemoved" value="'+id+'"><button type="submit" class="add noLeftBorder"><span class="glyphicon glyphicon-ok nav-icon"></span> Tak</button><button class="cancel noRightBorder" type="button" onclick="closeModal(\'modal\');" /><span class="glyphicon glyphicon-remove nav-icon"></span> Anuluj</button></div></form>';
	
	document.getElementById("modalBody").innerHTML = modalBody;
	$('#modal').modal('show');
}

function showNewCategoryAddingForm(actionName)
{
	var modalBody = '<div class="tableHead">Nowa kategoria</div><form action="index.php?action='+actionName+'" method="post"><input class="commentGetting categoryNameGetting" type="text" name="newCategoryName" placeholder="Podaj nazwę kategorii" autocomplete="off" required><div class="editButtons buttons" style="text-align: center; margin-top: 25px;"><button type="submit" class="add noLeftBorder"><span class="glyphicon glyphicon-plus nav-icon"></span> Dodaj</button><button class="cancel noRightBorder" type="button" onclick="closeModal(\'modal\');"><span class="glyphicon glyphicon-remove nav-icon"></span> Anuluj</button></div></form>';
	
	document.getElementById("modalBody").innerHTML = modalBody;
	$('#modal').modal('show');
}

function showCategoryEditForm(id)
{
	var categoryName = document.getElementById(id).innerHTML;
	
	var modalBody = '<div class="tableHead">Edycja kategorii</div><form id="categoryEditForm" method="post"><input class="commentGetting categoryNameGetting" type="text" id="newCategoryName" name="newCategoryName" autocomplete="off" placeholder="Podaj nową nazwę" value="'+categoryName+'" required><input type="hidden" name="oldCategoryName" value="'+categoryName+'"><input type="hidden" name="typeOfCategory" value="'+id.substr(0,1)+'"><input type="hidden" name="categoryId" value="'+id.substr(1)+'">';
	
	if(id.substr(0,1) == 'e')
	{
		modalBody += '<div class="checkbox" style="margin-bottom:-1px;" onclick="enableCategoryLimit();"><label><input type="checkbox" name="limitCheckbox" id="limitCheckbox" ';
		var limitInputStatus = "disabled"
		var limitValue = '';
		var oldLimitValueInput = '';
		if(document.getElementById(id+'limit').innerHTML !== '')
		{
			modalBody += 'checked';
			limitValue = document.getElementById(id+'limit').innerHTML;
			limitValue = limitValue.substr(6);
			limitValue = Number(limitValue);
			limitInputStatus = "";
			oldLimitValueInput = '<input type="hidden" name="oldCategoryLimit" value="'+limitValue+'">';
		}
		modalBody += '>Włącz limit dla kategorii</label></div>';
		modalBody += oldLimitValueInput;
		modalBody += '<input class="commentGetting categoryNameGetting" type="number" id="newCategoryLimit" name="newCategoryLimit" value="'+limitValue+'" '+limitInputStatus+'>';
	}
	modalBody += '<div class="buttons editButtons" style="margin-top: 25px;"><button class="add noLeftBorder" type="button" onclick="sendCategoryEditForm(\''+id+'\');"><span class="glyphicon glyphicon-ok nav-icon"></span> Zapisz</button><button type="button" class="cancel noRightBorder" onclick="closeModal(\'modal\');"><span class="glyphicon glyphicon-remove nav-icon"></span> Anuluj</button></div></form>';
	
	document.getElementById("modalBody").innerHTML = modalBody;
	$('#modal').modal('show');
}

function enableCategoryLimit()
{
	/*$("#limitCheckbox").click(function(){   
		if ($(this).is(':checked')){
			$("#newCategoryLimit").removeAttr("disabled");
		}
		else{
			$("#newCategoryLimit").attr("disabled", true);
		}
	});*/
	
	if ($('#limitCheckbox').is(':checked'))
	{
		$("#newCategoryLimit").removeAttr("disabled");
	}
	else
	{
		$("#newCategoryLimit").attr("disabled", true);
	}
	
}

function sendCategoryEditForm(id)
{
	var values = $('#categoryEditForm').serialize();
	var message = "";
	
/*	$.ajax({
		url: "index.php?action=editCategoryName",
		type: "post",
		data: values ,
		success: function (response) {
			if(response == 'OK')
			{
				$(id).text(newCategoryName);
				 alert("Pomyślnie zmieniono nazwę kategorii");
			}
			else alert(response);
			
			closeModal('modal');
			},
			error: function(jqXHR, textStatus, errorThrown) {
			 alert("Nie udało się zapisać zmian");
			}


    }); */
	
     var ajaxRequest = $.ajax({
            url: "index.php?action=editCategory",
            type: "post",
            data: values
        });

     ajaxRequest.done(function (response){
		 
		 message = response;
		switch(message)
		{
			case 'Zmieniono nazwę kategorii.':
			case 'Zmieniono nazwę kategorii, zmiana limitu nie była możliwa.':
			case 'Zmieniono nazwę kategorii, limit miał niepoprawną wartość.':
					
				$('#'+id).text($("#newCategoryName").val());
				break;
				
			case 'Zmieniono nazwę kategorii oraz ustawiono limit':
			
				$('#'+id).text($("#newCategoryName").val());
				$('#'+id+'limit').text('Limit: '+parseFloat($("#newCategoryLimit").val()).toFixed(2));
				break;
			
			case 'Nie można było zmienić nazwy kategorii, limit został ustawiony.':                  
			case 'Kategoria o takiej nazwie już istnieje, limit został ustawiony, nazwa pozostaje bez zmian.':
			case 'Ustawiono limit dla kategorii.':
				
				$('#'+id+'limit').text('Limit: '+parseFloat($("#newCategoryLimit").val()).toFixed(2));
				break;
				
			case 'Zmieniono nazwę kategorii oraz usunięto limit.':           
			
				$('#'+id).text($("#newCategoryName").val());
				$('#'+id+'limit').text('');
				break;
				
			case 'Nie można było zmienić nazwy kategorii, limit został usunięty.':            
			case 'Kategoria o takiej nazwie już istnieje, usunięto limit, nazwa pozostaje bez zmian.':
			case 'Usunięto limit dla kategorii.':
					
				document.getElementById(id+'limit').innerHTML = "";
				break;
		}
		
        /*if(response == 'OK')
		{
			$(id).text($("#newCategoryName").val());
			 message = "Zmieniono nazwę kategorii";
		}
		else message = response;*/
     });

     ajaxRequest.fail(function (){

      message = "Nie udało się zapisać zmian";
     });
	 
	ajaxRequest.always(function(){
	showMessage(message);
	setTimeout(function(){
		closeModal('modal');}, 1500);
	});
}

function showMessage(message)
{
	document.getElementById("modalBody").innerHTML = message;
//	$('#modal').modal('show');
}


function showLastAddedItemsShowLinks()
{
	if(!areLastAddedItemsShowLinksShown)
	{
		if(isDataEditShown) showDataEdition();
		if(areCategoryTypesShown) showCategoryTypes();
		$('#lastAddedItems').slideDown(fadeInTime);
		document.getElementById("lastAddedItemsLink").className = "tableHead pointer borderWhenHover";
		areLastAddedItemsShowLinksShown = true;
	}
	else
	{
		$('#lastAddedItems').slideUp(fadeOutTime);
		document.getElementById("lastAddedItemsLink").className = "editClick tableHead";
		if(areLastAddedIncomesShown) showLastAddedIncomes();
		if(areLastAddedExpensesShown) showLastAddedExpenses();
		areLastAddedItemsShowLinksShown = false;
	}
}

function showLastAddedIncomes()
{
	if(!areLastAddedIncomesShown)
	{
		$('#lastAddedIncomesEdit').fadeIn(fadeInTime);
		areLastAddedIncomesShown = true;
	}
	else
	{
		$('#lastAddedIncomesEdit').fadeOut(fadeOutTime);
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