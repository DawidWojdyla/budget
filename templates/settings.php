<div id="tableContainer">
	<div class="editClick tableHead" onclick="showDataEdition();">
		Edycja danych
	</div>
	<div id="dataEdit" style="display:none;">
		<table class="expenseTable">
			<tr>
				<td>
					<div class="attributes editClick" onclick="showNameEditForm();">Nazwa użytkownika</div>
				</td>
				<td>
					<div class="option pointer" onclick="showNameEditForm();"><?=$_SESSION['loggedUser']->username?></div>
					<div class="edit">
						<div id="nameEditForm" style="display:none;">
							<form action="index.php?action=setNewUsername" method="post">
								<input class="commentGetting" type="text" name="username" placeholder="Nowa nazwa">
								<div class="buttons editButtons" style="margin-top: 5px;">
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
					<div class="attributes editClick" onclick="showPasswordEditForm();">hasło</div>
				</td>
				<td>
					<div class="option">
						<div id="passwordEditForm" style="display:none;">
							<form action="index.php?action=setNewPassword" class="noMargin" method="post">
								<div class="edit">
									<input class="amountGetting" pattern=".{6,20}" required title="Hasło musi zawierać od 6  20 znaków" name="currentPassword" style="margin-bottom: 8px;" type="password" placeholder="Bieżące hasło">
								</div>
								<div class="edit">
									<input class="commentGetting" type="password" pattern=".{6,20}" required title="Hasło musi zawierać od 6  20 znaków" name="newPassword" placeholder="Nowe hasło">
								</div>
								<div class="edit">
									<input class="commentGetting" type="password" pattern=".{6,20}" required title="Hasło musi zawierać od 6  20 znaków" name="newPassword2" placeholder="Powtórz hasło">
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
	<div id="categoryTypes" style="display: none;">
		<table class="expenseTable">
			<tr>
				<td>
					<div class="attributes editClick" onclick="showIncomeCategories();">przychody</div>
					<div id="incomeCategoriesEditOption" style="display:none;">
						<div class="option pointer text-center" style="font-size: 14px; margin-top:25px; margin-bottom: 10px; color: #ed5543;" onclick="showIncomeCategoryPositionsEditForm();">
							&uarr;&darr;Zamień kolejność
						</div>
						<div class="option pointer text-center" style="font-size: 14px; color: #ed5543;" onclick="showNewIncomeCategoryAddingForm();">
							Dodaj nową kategorię
						</div>
						<div id="newIncomeCategoryAddingForm" class="text-center" style="display:none;">
							<form action="index.php?action=addNewIncomeCategory" method="post">
								<input class="commentGetting" type="text" name="newIncomeCategory" placeholder="Podaj nazwę">
								<div class="editButtons buttons noMargin" style="text-align: center;">
									<input type="submit" class="add" value="Dodaj">
									<input class="cancel" value="Anuluj" type="button" onclick="showNewIncomeCategoryAddingForm();">
								</div>
							</form>
						</div>
					</div>
				</td>
				<td>
					<div id="incomeCategories" style="display: none;">
						<div class="incomeCategoryPosition" style="display: none;"><form action="index.php?action=editIncomeCategoriesPositions" method="post"></div>
						<?PHP foreach ($incomesCategories as $category): ?>
							<div>
								<input type="number" min="1" max="<?=$incomeCategoriesAmount?>" class="incomeCategoryPosition amountGetting position" style="display: none;" name="incomeCategories['<?=$category->id?>']" value="<?=$category->position?>">
								<div id="i<?=$category->id?>s" class="option pointer" style="display: inline;" onclick="showCategoryEditOptions('i<?=$category->id?>');"><?=$category->name?></div>
							</div>
							<div id="i<?=$category->id?>" style="display:inline;"></div>
						<?PHP endforeach; ?>
							<div class="incomeCategoryPosition position" style="display: none;" >
								<div class="buttons editButtons noMargin">
									<input type="submit" class="add" value="Zamień">
									<input class="cancel" class="noMargin" value="Anuluj" type="button" onclick="showIncomeCategoryPositionsEditForm();">
								</div>
								</form>
							</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="attributes editClick" onclick="showExpenseCategories();">wydatki</div>
					<div id="expenseCategoriesEditOption" style="display:none;">
						<div class="option pointer text-center" style="font-size: 14px; margin-top:25px; margin-bottom: 10px; color: #ed5543;" onclick="showExpenseCategoryPositionsEditForm();">
							&uarr;&darr;Zamień kolejność
						</div>
						<div class="option pointer text-center" style="font-size: 14px; color: #ed5543;" onclick="showNewExpenseCategoryAddingForm();">
							Dodaj nową kategorię
						</div>
						<div id="newExpenseCategoryAddingForm" class="text-center" style="display:none;">
							<form action="index.php?action=addNewExpenseCategory" method="post">
								<input class="commentGetting" type="text" name="newExpenseCategory" placeholder="Podaj nazwę">
								<div class="editButtons buttons noMargin" style="text-align: center;">
									<input type="submit" class="add" value="Dodaj">
									<input class="cancel" value="Anuluj" type="button" onclick="showNewExpenseCategoryAddingForm();">
								</div>
							</form>
						</div>
					</div>
				</td>
				<td>
					<div id="expenseCategories" style="display: none;">
						<div class="expenseCategoryPosition" style="display: none;"><form action="index.php?action=editExpenseCategoriesPositions" method="post"></div>
						<?PHP foreach ($expenseCategories as $category): ?>
							<div>
								<input type="number" min="1" max="<?=$expenseCategoriesAmount?>" class="expenseCategoryPosition amountGetting position" style="display: none;" name="expenseCategories['<?=$category->id?>']" value="<?=$category->position?>">
								<div id="e<?=$category->id?>s" class="option pointer" style="display: inline;" onclick="showCategoryEditOptions('e<?=$category->id?>');"><?=$category->name?></div>
							</div>
							<div id="e<?=$category->id?>" style="display:inline;"></div>
						<?PHP endforeach; ?>
							<div class="expenseCategoryPosition position" style="display: none;" >
								<div class="buttons editButtons noMargin">
									<input type="submit" class="add" value="Zamień">
									<input class="cancel" class="noMargin" value="Anuluj" type="button" onclick="showExpenseCategoryPositionsEditForm();">
								</div>
								</form>
							</div>
					</div>
				</td>
			</tr>
		</table>
		<div style="margin-bottom: 40px;"></div>
	</div>
	<div class="noMargin" style="text-align: center; margin-top: -20px; margin-bottom: -2px;">
		<div id='categoriesDownArrow' class='editButtons arrow pointer' onclick="showCategoryTypes();">&dArr;</div>
	</div>
	<div class="editClick tableHead" onclick="showLastAddedIncomes();">
		Ostatnie przychody
	</div>
	<div id="lastAddedIncomesEdit" style="display: none;">
		<form action="index.php?action=removeLastAddedIncomes" class="noMargin" method="post">
			<div class="lastDataTableContainer">
				<table class="lastDataEdit option">
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
				</table>
				<?PHP if ($lastIncomes): ?>
				<div class="buttons editButtons" style="text-align: center; margin-bottom: 30px;">
					<input type="submit" class="add" value="Usuń" style="margin-right:7%;">
					<input class="cancel" class="noMargin" value="Anuluj" type="button" onclick="showLastAddedIncomes();" style="margin-left:7%;" />
				</div>						
				<?PHP else: ?> 
				<div class="text-center option" style="padding: 20px; margin-bottom: 30px;">Nie masz dodanych żadnych przychodów!</div>
				<?PHP endif; ?>				
			</div>
		</form>	
	</div>
	<div class="noMargin" style="text-align: center; margin-top: -20px; margin-bottom: -2px;">
		<div id='incomeDownArrow' class='editButtons arrow pointer' onclick="showLastAddedIncomes();">&dArr;</div>
	</div>
	<div class="editClick noMargin tableHead" onclick="showLastAddedExpenses();">
		Ostatnie wydatki
	</div>
	<div id="lastAddedExpensesEdit" style="display: none;">
		<form action="index.php?action=removeLastAddedExpenses" class="noMargin" method="post">
			<div class="lastDataTableContainer">
				<table class="option lastDataEdit">
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
				</table>
				<?PHP if ($lastExpenses): ?>
				<div class="buttons editButtons" style="text-align: center; margin-bottom: 15px;">
					<input type="submit" class="add" value="Usuń" style="margin-right:7%;">
					<input class="cancel" value="Anuluj" type="button" onclick="showLastAddedExpenses();" style="margin-left:7%;" />
				</div>					
				<?PHP else: ?> 
				<div class="text-center option" style="padding: 20px;">Nie masz dodanych żadnych wydatków!</div>
				<?PHP endif; ?>
			</div>
		</form>	
	</div>
	<div class="noMargin" style="text-align: center; margin-bottom: -7px;">
		<div id='expenseDownArrow' class='editButtons arrow pointer' onclick="showLastAddedExpenses();">&dArr;</div>
	</div>
</div>