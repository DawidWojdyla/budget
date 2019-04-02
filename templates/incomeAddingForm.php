<div id="tableContainer" style="display:none;">
	<form action="index.php?action=addNewIncome" name="incomeAddingForm" id="incomeAddingForm" method="post">
		<div class="tableHead">
			Dodaj przychód
		</div>
		<table class="expenseTable">
			<tr>
				<td>
					<div class="attributes">
						Kwota [PLN]:
					</div>
				</td>
				<td>
					<input class="amountGetting" name="amount" type="number"  step=".01" min="0.01" value="<?PHP 
					if (isset($_SESSION['amountSes'])):
						echo $_SESSION['amountSes'];
						unset ($_SESSION['amountSes']);
					endif; ?>">
						<?PHP
						if (isset($_SESSION['amountError'])):?>
						<div class="option error"><?=$_SESSION['amountError']?></div>
						<?PHP unset($_SESSION['amountError']);
							endif; ?>
				</td>
			</tr>
			<tr>
				<td>
					<div class="attributes">
						Data:
					</div>
				</td>
				<td>
					<input class="dateGetting" name="date" type="date" value="<?PHP
						if (isset($_SESSION['dateSes'])):
							echo $_SESSION['dateSes'];
							unset ($_SESSION['dateSes']);
						else: echo date('Y-m-d');
						endif; ?>">
						<?PHP if (isset($_SESSION['dateError'])): ?>
					<div class="option error"><?=$_SESSION['dateError']?></div>
						<?PHP unset($_SESSION['dateError']);
							endif; ?>
				</td>
			</tr>
			<tr>
				<td>
					<div class="attributes">
						Kategoria:
					</div>
				</td>
				<td>
					<?PHP	foreach ($categories as $category): ?> 
					<div class="option"><label><input type="radio" name="category" value="<?=$category->id?>"
						<?PHP if (isset($_SESSION['categorySes']) && $_SESSION['categorySes'] == $category->id):?> 
						checked="checked"
						<?PHP unset ($_SESSION['categorySes']);
						endif;?>><?=$category->name?></label>
					</div>
					<?PHP endforeach; if (isset($_SESSION['categoryError'])):?>
					<div class="option error"><?=$_SESSION['categoryError']?></div>
					<?PHP unset($_SESSION['categoryError']); endif;?>
				</td>
			</tr>
			<tr>
				<td>
					<div class="attributes">
						Komentarz
						<div style="font-size:14px">
							(opcjonalnie)
						</div>
					</div>
				</td>
				<td>
					<textarea class="commentGetting" name="comment" id="comment" form="incomeAddingForm"><?PHP if(isset($_SESSION['commentSes'])):?><?=$_SESSION['commentSes']?><?PHP unset ($_SESSION['commentSes']); endif;?></textarea>
				</td>
			</tr>
		</table>
		<div class="buttons">
			<button type="submit" class="add noLeftBorder"><span class='glyphicon glyphicon-ok nav-icon'></span> Dodaj</buton>
			<button class="cancel noRightBorder" type="button" onclick="location.href='index.php?action=showMenu';"><span class='glyphicon glyphicon-remove nav-icon'></span> Anuluj</button>
		</div>
	</form>
</div>