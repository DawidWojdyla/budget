<div id="tableContainer">
	<div class="editClick tableHead" onclick="showDataEdition();">
		Dane konta
	</div>
	<div id="dataEdit" style="display:none;">
		<table class="expenseTable settingTable">
			<tr>
				<td>
					<div class="attributes editClick" onclick="showNameEditForm();">Edycja nazwy użytkownika</div>
				</td>
				<td style="text-align:center;">
					<div id="name" class="option pointer centerInput"  onclick="showNameEditForm();"><?=$_SESSION['loggedUser']->username?></div>
					<div class="edit">
						<div id="nameEditForm" style="display:none;">
							<form class="noPadding noMargin" action="index.php?action=setNewUsername" method="post">
								<div class="centerInput"><input class="commentGetting nameGetting" type="text" name="username" placeholder="Nazwa użytkownika" value="<?=$_SESSION['loggedUser']->username?>"></div>
								<div class="buttons editButtons">
									<input type="submit" class="add" value="Zapisz">
									<input class="cancel" value="Anuluj" type="button" onclick="showNameEditForm();">
								</div>
							</form>
							<div style="margin-bottom: -20px;"></div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="attributes editClick" onclick="showPasswordEditForm();">Edycja hasła</div>
				</td>
				<td style="text-align:center;">
					<div class="option">
						<div id="passwordEditForm" style="display:none;">
							<form action="index.php?action=setNewPassword" class="noMargin" method="post">
								<div class="edit">
									<div class="centerInput"><input class="commentGetting nameGetting" pattern=".{6,20}" required title="Hasło musi zawierać od 6  20 znaków" name="currentPassword" type="password" placeholder="Bieżące hasło"></div>
								</div>
								<div class="edit">
									<div class="centerInput"><input class="commentGetting nameGetting" type="password" pattern=".{6,20}" required title="Hasło musi zawierać od 6  20 znaków" name="newPassword" placeholder="Nowe hasło"></div>
								</div>
								<div class="edit">
									<div class="centerInput"><input class="commentGetting nameGetting" type="password" pattern=".{6,20}" required title="Hasło musi zawierać od 6  20 znaków" name="newPassword2" placeholder="Powtórz hasło"></div>
								</div>
								<div class="buttons editButtons">
									<input type="submit" class="add" value="Zapisz">
									<input class="cancel" value="Anuluj" type="button" onclick="showPasswordEditForm();">
								</div>
							</form>
							<div style="margin-bottom: -20px;"></div>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<div style="margin-bottom: 40px;"></div>
	</div>
	<div class="noMargin" style="text-align: center; margin-top: -20px; margin-bottom: -2px;">
		<div id='dataDownArrow' class='editButtons arrow pointer' onclick="showDataEdition();">&dArr;</div>
	</div>
	<div class="editClick tableHead" onclick="showCategoryTypes();">
		Edycja kategorii
	</div>
	<div id='categoriesDownArrow' class='editButtons arrow pointer' style="margin-top: -20px;" onclick="showCategoryTypes();">&dArr;</div>
	<table class="lastDataEdit option">
		<tr class="categoryTypes" style="display: none;">
			<td>
				<div class="attributes editClick"  style="margin-bottom: 10px;" onclick="showIncomeCategories();">
					Przychody
				</div>
			</td>
		</tr>
	</table>
	<table class="categoryEditTable" id="incomeCategories" style="display:none;">
		<tr>
			<td colspan="4" style="text-align: center;">
				<div class="categoryOption pointer" onclick="showNewCategoryAddingForm('addNewIncomeCategory');"><span class='glyphicon glyphicon-plus balance-icon'></span>Nowa kategoria</div><div class="categoryOption pointer" onclick="showIncomeCategoryPositionsEditForm();"><span class='glyphicon glyphicon-sort balance-icon'></span>Zamień kolejność</div>
				<div class="incomeCategoryPosition" style="display: none;"><form action="index.php?action=editIncomeCategoriesPositions" method="post"></div>
			</td>
		</tr>
		<?PHP foreach ($incomesCategories as $category): ?>
		<tr>
			<td class="editIcons incomeEditIcons">
				<div style="display:inline" class="text-right">
					<span data-toggle="tooltip" title="Edytuj" onclick="showCategoryEditNameForm('i<?=$category->id?>');" class='glyphicon glyphicon-pencil balance-icon'></span>
					<span style="color: #ab4468;"  data-toggle="tooltip" title="Usuń" onclick="removeItem('i<?=$category->id?>');"class='glyphicon glyphicon-remove balance-icon'>
					</span>
				</div>
			</td>
			<td class="incomeCategoryPosition noPadding noMargin text-right" style="display: none;"><div style="margin-right: 5px;">
				<input type="number" min="1" max="<?=$incomeCategoriesAmount?>" class="amountGetting position"  name="incomeCategories['<?=$category->id?>']" value="<?=$category->position?>" required></div>
			</td>
			<td colspan="3">
				<div id="i<?=$category->id?>"><?=$category->name?></div>
			</td>	
		</tr>
		<?PHP endforeach; ?>
		<tr>
			<td colspan="4" class="incomeCategoryPosition position" style="display: none; text-align: center;">
				<div class="buttons editButtons noMargin" style="margin-top: 10px;">
					<input type="submit" class="add" value="Zamień" style="margin-right: 5px;">
					<input class="cancel" class="noMargin" value="Anuluj" type="button" style="margin-left: 5px;" onclick="showIncomeCategoryPositionsEditForm();">
				</div>
			</form>
			</td>
		</tr>
	</table>
	<table class="lastDataEdit option">
		<tr class="categoryTypes" style="display: none;">
			<td>
				<div class="attributes editClick"  style="margin-bottom: 10px;" onclick="showExpenseCategories();">Wydatki</div>
			</td>
		</tr>
	</table>
	<table class="categoryEditTable" id="expenseCategories" style="display:none;">
		<tr>
			<td colspan="4" style="text-align: center;">
				<div class="categoryOption pointer" onclick="showNewCategoryAddingForm('addNewExpenseCategory');">
					<span class='glyphicon glyphicon-plus balance-icon'></span>Nowa kategoria
				</div>
				<div class="categoryOption pointer" onclick="showExpenseCategoryPositionsEditForm();">
					<span class='glyphicon glyphicon-sort balance-icon'></span>Zamień kolejność
				</div>
				<div class="expenseCategoryPosition" style="display: none;">
					<form action="index.php?action=editExpenseCategoriesPositions" method="post">
				</div>
			</td>
		</tr>
		<?PHP foreach ($expenseCategories as $category): ?>
		<tr>
			<td class="editIcons expenseEditIcons">
				<div style="display:inline" class="text-right">
					<span data-toggle="tooltip" title="Edytuj" onclick="showCategoryEditNameForm('e<?=$category->id?>');" class='glyphicon glyphicon-pencil balance-icon'></span>
					<span style="color: #ab4468;"  data-toggle="tooltip" title="Usuń" onclick="removeItem('e<?=$category->id?>');"class='glyphicon glyphicon-remove balance-icon'></span>
				</div>
			</td>
			<td class="expenseCategoryPosition noPadding noMargin text-right" style="display: none;">
				<div style="margin-right: 5px;">
					<input type="number" min="1" max="<?=$expenseCategoriesAmount?>" class="amountGetting position"  name="expenseCategories['<?=$category->id?>']" value="<?=$category->position?>" required>
				</div>
			</td>
			<td colspan="3">
				<div id="e<?=$category->id?>"><?=$category->name?></div>
			</td>
		</tr>
		<?PHP endforeach; ?>
		<tr>
			<td colspan="4" class="expenseCategoryPosition position" style="display: none; text-align: center;">
				<div class="buttons editButtons noMargin" style="margin-top: 10px;">
					<input type="submit" class="add" value="Zamień" style="margin-right: 5px;">
					<input class="cancel" class="noMargin" value="Anuluj" type="button" style="margin-left: 5px;" onclick="showExpenseCategoryPositionsEditForm();">
				</div>
			</form>
			</td>
		</tr>
	</table>
	<table class="lastDataEdit option">
		<tr class="categoryTypes" style="display: none;">
			<td>
				<div class="attributes editClick"  style="margin-bottom: 10px;" onclick="showPaymentMethods();">
					Płatności
				</div>
			</td>
		</tr>
	</table>
	<table class="categoryEditTable" id="paymentMethods" style="display:none;">
		<tr>
			<td colspan="4" style="text-align: center;">
				<div class="categoryOption pointer" onclick="showNewCategoryAddingForm('addNewPaymentMethod');">
					<span class='glyphicon glyphicon-plus balance-icon'></span>
					Nowa kategoria
				</div>
				<div class="categoryOption pointer" onclick="showPaymentMethodPositionsEditForm();">
					<span class='glyphicon glyphicon-sort balance-icon'></span>
					Zamień kolejność
				</div>
				<div class="paymentMethodPosition" style="display: none;"><form action="index.php?action=editPaymentMethodsPositions" method="post"></div>
			</td>
		</tr>
		<?PHP foreach ($paymentMethods as $category): ?>
		<tr>
			<td class="editIcons paymentMethodEditIcons">
				<div style="display:inline" class="text-right">
					<span data-toggle="tooltip" title="Edytuj" onclick="showCategoryEditNameForm('p<?=$category->id?>');" class='glyphicon glyphicon-pencil balance-icon'></span>
					<span style="color: #ab4468;"  data-toggle="tooltip" title="Usuń" onclick="removeItem('p<?=$category->id?>');"class='glyphicon glyphicon-remove balance-icon'></span>
				</div>
			</td>
			<td class="paymentMethodPosition noPadding noMargin text-right" style="display: none;"><div style="margin-right: 5px;">
				<input type="number" min="1" max="<?=$paymentMethodsAmount?>" class="amountGetting position"  name="paymentMethods['<?=$category->id?>']" value="<?=$category->position?>" required></div>
			</td>
			<td colspan="3">
				<div id="p<?=$category->id?>"><?=$category->name?></div>
			</td>	
		</tr>
		<?PHP endforeach; ?>
		<tr>
			<td colspan="4" class="paymentMethodPosition position" style="display: none; text-align: center;">
				<div class="buttons editButtons noMargin" style="margin-top: 10px;">
					<input type="submit" class="add" value="Zamień" style="margin-right: 5px;">
					<input class="cancel" class="noMargin" value="Anuluj" type="button" style="margin-left: 5px;" onclick="showPaymentMethodPositionsEditForm();">
				</div>
			</form>
			</td>
		</tr>
	</table>
	<div class="editClick tableHead" onclick="showLastAddedItemsShowLinks();">
		Ostatnio dodawane
	</div>
	<table class="lastDataEdit option">
		<tr id="lastAddedIncomesShowLink" style="display: none;">
			<td><div class="attributes editClick" onclick="showLastAddedIncomes();">Przychody</div></td>
		</tr>
	</table>
		<form action="index.php?action=removeLastAddedIncomes" class="noMargin" method="post">
			<div class="lastDataTableContainer">
				<table  class="lastDataEdit option" id="lastAddedIncomesEdit" style="display: none;">
				<?PHP foreach ($lastIncomes as $lastIncome): ?>
					<tr>
						<td>
							<label for='li<?=$lastIncome->id?>'>
								<input class='lastDataCheckbox pointer' id='li<?=$lastIncome->id?>' type='checkbox' value='<?=$lastIncome->id?>' name='lastIncomes[]'>
							</label>
						</td>
						<td>
							<label  class='pointer' for='li<?=$lastIncome->id?>'><?=$lastIncome->date?>
							</label>
						</td>
						<td>
							<label  class='pointer' for='li<?=$lastIncome->id?>'><?=$lastIncome->name?>
							</label>
						</td>
						<td align='right'>
							<label class='pointer' for='li<?=$lastIncome->id?>'><?=number_format($lastIncome->amount, 2,'.',' ')?>
							</label>
						</td>
					</tr>
				<?PHP endforeach ?>
				
				<?PHP if ($lastIncomes): ?>
				<tr><td colspan="4">
					<div class="buttons editButtons" style="text-align: center;">
						<input type="submit" class="add" value="Usuń" style="margin-right:7%;">
						<input class="cancel" class="noMargin" value="Anuluj" type="button" onclick="showLastAddedIncomes();" style="margin-left:7%;" />
					</div>
				</td></tr>					
				<?PHP else: ?> 
				<tr><td colspan="4"><div class="text-center option" style="padding: 20px; margin-bottom: -15px; margin-top: -20px;">Nie masz dodanych żadnych przychodów!</div></td></tr>
				<?PHP endif; ?>
				</table>
			</div>
		</form>	
	<div id='incomeDownArrow' class="noMargin">
		<div class='editButtons arrow pointer' style="text-align: center; margin-top: -30px; margin-bottom: -20px;" onclick="showLastAddedItemsShowLinks();">&dArr;</div>
	</div>
	<table class="lastDataEdit option">
		<tr id="lastAddedExpensesShowLink" style="display: none;">
			<td><div class="attributes editClick"  style="margin-top: -5px;"onclick="showLastAddedExpenses();">Wydatki</div></td>
		</tr>
	</table>
		<form action="index.php?action=removeLastAddedExpenses" class="noMargin" method="post">
			<div class="lastDataTableContainer">
				<table id="lastAddedExpensesEdit" style="display: none;" class="option lastDataEdit noMargin noPadding">
					<?PHP foreach ($lastExpenses as $lastExpense): ?>
					<tr>
						<td>
							<label for='le<?=$lastExpense->id?>'>
								<input class='lastDataCheckbox pointer' type='checkbox' id='le<?=$lastExpense->id?>' value='<?=$lastExpense->id?>' name='lastExpenses[]'>
							</label>
						</td>
						<td>
							<label class='pointer' for='le<?=$lastExpense->id?>'><?=$lastExpense->date?></label>
						</td>
						<td>
							<label class='pointer' for='le<?=$lastExpense->id?>'><?=$lastExpense->name?></label>
						</td>
						<td align='right'>
							<label class='pointer' for='le<?$lastExpense->id?>'><?=number_format($lastExpense->amount, 2,'.',' ')?></label>
						</td>
					</tr>
					<?PHP endforeach; ?>
					<?PHP if ($lastExpenses): ?>
					<tr><td colspan="4"><div class="buttons editButtons" style="text-align: center; margin-bottom: 15px;">
						<input type="submit" class="add" value="Usuń" style="margin-right:7%;">
						<input class="cancel" value="Anuluj" type="button" onclick="showLastAddedExpenses();" style="margin-left:7%;" /></div></td>
					</tr>				
				<?PHP else: ?> 
				<tr><td colspan="4"><div class="text-center option" style="padding: 20px; margin-bottom: -15px; margin-top: -20px;">Nie masz dodanych żadnych wydatków!</div></td></tr>
				<?PHP endif; ?>
				</table>
			</div>
		</form>	

<div class="modal fade" id="modal" role="dialog">
	<div class="modal-dialog modal-sm">
	<div class="settingsModal">
		<div id="modalBody"></div>
		</div>
	</div>
</div>


