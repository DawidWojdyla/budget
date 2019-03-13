<script type="text/javascript">

var lastChosenId = null;

function closeModal(modalId)
{
	$('#'+modalId).modal('hide');
}

function openModal(modalId)
{
	$('#'+modalId).modal('show');
}

function showClass(className)
{
	$('.'+className).toggle(200);
	
	/*
	var positions = document.getElementsByClassName(className);

	for (var i = 0; i < positions.length; ++i)
		if (positions[i].style.display == 'none')
			positions[i].style.display = 'table-row';
		else
			positions[i].style.display = 'none';
		*/
}	

function removeItem(id)
{
	var modalBody = 'Czy napewno chcesz usunąć wybraną pozycję?';
	modalBody += '<form action="index.php?action=removeItem" method="post"><div class="buttons editButtons"><input type="hidden" name="itemToBeRemoved" value="'+id+'"><input type="submit" class="add" value="Tak"><input class="cancel" value="Anuluj" type="button" onclick="closeModal(\'modal\');" /></div></form>';
	
	document.getElementById("modalBody").innerHTML = modalBody;
	$('#modal').modal('show');
}


function highlightItem(id)
{
	if(document.getElementById(id+'s').style.color != "#183e1e"){
		document.getElementById(id+'s').style.color = "#183e1e";
	}
	else{
		document.getElementById(id+'s').style.color = "#ab5344";
	}
}

function showEditForm(id)
{	
	var comment = document.getElementById(id+'comment').innerHTML;
	var date = document.getElementById(id+'date').innerHTML;
	var amount = document.getElementById(id+'amount').innerHTML;
	amount = amount.replace(/ /g, "");
	
	var separatorPosition = id.indexOf("+");
	var incomeId = id.substring(0, separatorPosition);
	var rest = id.substr(separatorPosition+1);
	
	var editForm = '<form name="updatingForm" id="updatingForm" action="index.php?action=updateItem" method="post" autocomplete="off"><input type="hidden" name="itemToBeUpdated" value="'+incomeId+'">';
	editForm += '<table class="editFormTable"><tr><td>Kwota</td><td><input class="amountGetting editFormInputs" style="max-width:160px;" name="amount" type="text" value="'+amount+'"/></td></tr>';
	editForm += '<tr><td>Data</td><td><input class="dateGetting editFormInputs" name="date" type="date" value="'+date+'"/></td></tr>';
	
	if(id.substr(0,1) == 'e')
		{
			var paymentMethod = document.getElementById(id+'paymentMethod').innerHTML;
			editForm += '<tr><td>Sposób płatności</td><td><select class="dateGetting  editFormInputs" name="paymentMethodId">';
			<?PHP foreach ($paymentMethods as $paymentMethod): ?>
			editForm += '<option value="<?=$paymentMethod->id?>"';
			var paymentMethodIdStartPosition = rest.indexOf("&") + 1;
			if(rest.substr(paymentMethodIdStartPosition) == <?=$paymentMethod->id?>)
				editForm += 'selected';
			editForm += '><?=$paymentMethod->name?></option>';
			<?PHP endforeach; ?>
			editForm += '</select></td></tr>';
		}
		
		editForm += '<tr><td>Kategoria</td><td><select class="dateGetting  editFormInputs" name="categoryId">';
		
		if(id.substr(0,1) == 'i')
		{
			<?PHP foreach ($incomeCategories as $category): ?>
			editForm += '<option value="<?=$category->id?>"';
			if(rest == <?=$category->id?>)
				editForm += 'selected';
			editForm += '><?=$category->name?></option>';
			<?PHP endforeach; ?>
		}
		else
		{
			<?PHP foreach ($expensesCategories as $category): ?>
			editForm += '<option value="<?=$category->id?>"';
			if(rest.substring(0,paymentMethodIdStartPosition-1) == <?=$category->id?>)
				editForm += 'selected';
			editForm += '><?=$category->name?></option>';
			<?PHP endforeach; ?>
		}
		
		editForm += '</select></td></tr>';
		editForm += '<tr><td>Komentarz</td><td><textarea class="commentGetting editFormInputs" form="updatingForm" name="comment" id="comment" form="editForm">'+comment+'</textarea></td></tr>';
		editForm += '<tr><td colspan="2"><div class="buttons editButtons" style="text-align: center; width:100%;"><input type="submit" class="add" value="Zapisz"><input class="cancel" value="Anuluj" type="button" onclick="closeModal(\'editFormModal\');"></div></td></tr></table></form>';
		
	document.getElementById("editFormModalBody").innerHTML = editForm;
	
	openModal('editFormModal');
}

$(document).ready(function () {
	$('.dropdownMenuContainer').fadeIn(200);
    $('#tableContainer').fadeIn(200);
});
	
</script>