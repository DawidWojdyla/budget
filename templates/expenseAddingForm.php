<div id="tableContainer" style="display:none;">
	<form action="index.php?action=addNewExpense" name="expenseAddingForm" id="expenseAddingForm" method="post">
		<div class="tableHead">
			Dodaj wydatek
		</div>
		<div id="limitInfo" style="display: none;"></div>
		<table class="expenseTable">
			<tr>
				<td>
					<div class="attributes">
						Kwota [PLN]:
					</div>
				</td>
				<td>
					<input id="amount" class="amountGetting" name="amount" step=".01" min="0" type="number" value="<?PHP 
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
					<input id="expenseDate" class="dateGetting" name="date" type="date" value="<?PHP
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
					<div class="option"><label><input onclick="showLimitInfoIfRequired('<?=$category->limit?>');" type="radio" name="category" value="<?=$category->id?>"
						<?PHP if (isset($_SESSION['categorySes']) && $_SESSION['categorySes'] == $category->id):?> 
						checked="checked"
						<?PHP unset ($_SESSION['categorySes']);
						endif;?>><?=$category->name?></label>
					</div>
					<?PHP if($category->limit !== null): ?>
					<div style="margin-left:20px; color: #ab4468; margin-top:-8px; font-size: 13px; text-shadow: none; font-weight: bold;">Limit: <?=$category->limit?></div>
					<?PHP endif; ?>
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
					<textarea class="commentGetting" name="comment" id="comment" form="expenseAddingForm"><?PHP if(isset($_SESSION['commentSes'])):?><?=$_SESSION['commentSes']?><?PHP unset ($_SESSION['commentSes']); endif;?></textarea>
				</td>
			</tr>
		</table>
		<div class="buttons">
			<input type="submit" class="add" value="Dodaj">
			<input class="cancel" value="Anuluj"  type="button" onclick="location.href='index.php?action=showMenu';">
		</div>
	</form>
</div>