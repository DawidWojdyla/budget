<div id="tableContainer">
	<form action="index.php?action=addNewExpense" method="post">
		<div class="tableHead">
			Dodaj wydatek
		</div>
		<table class="expenseTable">
			<tr>
				<td>
					<div class="attributes">
						Kwota [PLN]:
					</div>
				</td>
				<td>
					<input class="amountGetting" name="amount" type="text" value="<?PHP 
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
					<input id="dateGetting" name="date" type="date" value="<?PHP
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
						Sposób płatności:
					</div>
				</td>
				<td>
				<?PHP foreach ($paymentMethods as $paymentMethod):?>
					<div class="option"><label><input type="radio" name="paymentMethod" value="<?=$paymentMethod->id?>"
					<?PHP if (isset($_SESSION['paymentMethodSes']) && $_SESSION['paymentMethodSes'] == $paymentMethod->id):?>
									checked="checked"'
									<?PHP unset ($_SESSION['paymentMethodSes']);
									endif;?>><?=$paymentMethod->name?></label>
					</div>
					<?PHP endforeach; if(isset($_SESSION['paymentMethodError'])):?>
					<div class="option error"><?=$_SESSION['paymentMethodError']?></div>
					<?PHP unset($_SESSION['paymentMethodError']); endif; ?>
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
					<input class="commentGetting" name="comment" type="text" 
					<?PHP if (isset($_SESSION['commentSes'])): ?>
						value="<?=$_SESSION['commentSes']?>"
					<?PHP unset ($_SESSION['commentSes']); endif; ?> >
				</td>
			</tr>
		</table>
		<div class="buttons">
			<input type="submit" class="add" value="Dodaj">
			<input class="cancel" value="Anuluj"  type="button" onclick="location.href='index.php?action=showMenu';">
		</div>
	</form>
</div>