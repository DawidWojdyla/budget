<script type="text/javascript">

var lastChosenId = null;
var isEditFormShown = false;
var lastChosenCategory = null;

/*function showTable(id)
{
	if (document.getElementById(id).style.display == "none")
		document.getElementById(id).style.display = "table";
	else document.getElementById(id).style.display = "none";	
}

function show2Tables(id1, id2)
{
	showTable(id1);
}*/


function showClass(className)
{
	var positions = document.getElementsByClassName(className);
	for (var i = 0; i < positions.length; ++i)
		positions[i].style.display = 'table-row';
}

function hideClass(className)
{
	var positions = document.getElementsByClassName(className);
	for (var i = 0; i < positions.length; ++i)
		positions[i].style.display = 'none';
}


function showItems(category)
{
	 if (lastChosenCategory != null)
	 {
		 hideClass(lastChosenCategory);
	 }
	 if(lastChosenCategory != category)
	 {
		showClass(category);
		lastChosenCategory = category;
	 }
	 else
		 lastChosenCategory = null;
	 
	if(lastChosenId != null)
		showEditButtons(lastChosenId);
}


function highlightItem(id)
{
	if(document.getElementById(id+'s').style.color != "grey"){
		document.getElementById(id+'s').style.color = "grey";
	}
	else{
		document.getElementById(id+'s').style.color = "red";
	}
}

function showEditForm()
{
	if(!isEditFormShown)
	{
		comment = document.getElementById(lastChosenId+'comment').innerHTML;
		date = document.getElementById(lastChosenId+'date').innerHTML;
		amount = document.getElementById(lastChosenId+'amount').innerHTML;
		amount = amount.replace(/ /g, "");
	
		var editForm = '<td colspan="4"><form action="index.php?action=updateItem" method="post" autocomplete="off"><table class="editFormTable"><input type="hidden" name="itemToBeUpdated" value="'+lastChosenId+'">';
		editForm += '<tr><td><div>Kwota</td><td colspan="2"><input class="amountGetting editFormInputs" name="amount" type="text" value="'+amount+'"/></div></td></tr>';
		editForm += '<tr><td><div>Data</td><td colspan="2"><input class="commentGetting editFormInputs" name="date" type="date" value="'+date+'"/></td></tr>';
		
		if(lastChosenId.substr(0,1) == 'e')
		{
			paymentMethod = document.getElementById(lastChosenId+'paymentMethod').innerHTML;
			editForm += '<tr><td>Sposób płatności</td><td colspan="2"><select class="commentGetting  editFormInputs" name="paymentMethodId">';
			<?PHP foreach ($paymentMethods as $paymentMethod): ?>
			editForm += '<option value="<?=$paymentMethod->id?>"';
			var paymentMethodIdStartPosition = lastChosenId.indexOf("&") + 1;
			if(lastChosenId.substr(paymentMethodIdStartPosition) == <?=$paymentMethod->id?>)
				editForm += 'selected';
			editForm += '><?=$paymentMethod->name?></option>';
			<?PHP endforeach; ?>
			editForm += '</select></td></tr>';
		}
		editForm += '<tr><td>Kategoria</td><td colspan="2"><select class="commentGetting  editFormInputs" name="categoryId">';
		
		if(lastChosenId.substr(0,1) == 'i')
		{
			<?PHP foreach ($incomeCategories as $category): ?>
			editForm += '<option value="<?=$category->id?>"';
			if(lastChosenCategory.substr(1) == <?=$category->id?>)
				editForm += 'selected';
			editForm += '><?=$category->name?></option>';
			<?PHP endforeach; ?>
		}
		else
		{
			<?PHP foreach ($expensesCategories as $category): ?>
			editForm += '<option value="<?=$category->id?>"';
			if(lastChosenCategory.substr(1) == <?=$category->id?>)
				editForm += 'selected';
			editForm += '><?=$category->name?></option>';
			<?PHP endforeach; ?>
		}
		
		editForm += '</select></td></tr>';
		editForm += '<tr><td><div>Komentarz</td><td colspan="2"><input class="commentGetting editFormInputs" name="comment" type="text" value="'+comment+'"/></div></td></tr>';
		
		editForm += '<tr><td colspan="3"><div class="buttons editButtons" style="text-align: center; margin: -20px;"><input type="submit" class="add" value="Zapisz"><input class="cancel" value="Anuluj" type="button" onclick="showEditButtons(lastChosenId);" /></div></td></tr></table></form></td>';
		
		document.getElementById(lastChosenId).innerHTML = editForm;
	}

}	

function showConfirmation()
{
	document.getElementById(lastChosenId).innerHTML = '<td colspan="4"><form action="index.php?action=removeItem" method="post"><div class="text-center" style="font-size: 14px; color: black; margin-top:-8px; margin-bottom:-8px;">Czy na pewno chcesz usunąć wybraną pozycję?</div><div class="buttons editButtons" style="text-align: center;"><input type="hidden" name="itemToBeRemoved" value="'+lastChosenId+'"><input type="submit" class="add" value="Tak"><input class="cancel" value="Anuluj" type="button" onclick="showEditButtons(lastChosenId);" /></div></form></td>';
}

function showEditButtons(id)
{
	 if(lastChosenId != id && lastChosenId != null)
	{
		document.getElementById(lastChosenId).innerHTML = '';
		highlightItem(lastChosenId);
	}
	 if (document.getElementById(id).innerHTML == ''){
		document.getElementById(id).innerHTML = '<td colspan="4"><div class="buttons editButtons" style="text-align: center; margin-top:-8px; margin-bottom:-5px;"><input type="submit" class="add" value="Edytuj" onclick="showEditForm();"/><input class="cancel" value="Usuń" type="button" onclick="showConfirmation();" /></div></td>';
		highlightItem(id);
		lastChosenId = id;
	}
	else{
		document.getElementById(id).innerHTML = '';
		highlightItem(id);
		lastChosenId = null;
	}
}
</script>