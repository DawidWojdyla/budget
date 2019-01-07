<?PHP if(isset($_SESSION['isCustomSelected']) && $_SESSION['isCustomSelected'] == true): ?>
	<div class="row">
		<div class="col-sm-8" style="margin-top:8px;">
			<form action="index.php?action=showBalance" method="post">
				<div class="customPeriod">
					<input type="date" id="dateGetting" min="1999-01-01" name="dateFrom"
					<?PHP if(isset($_SESSION['dateFromSes'])):?>
					value="<?=$_SESSION['dateFromSes']?>"
					<?PHP endif; ?>>
					<input type="date" id="dateGetting" min="1999-01-01" name="dateTo"
					<?PHP if(isset($_SESSION['dateToSes'])):?>
					value="<?=$_SESSION['dateToSes']?>"
					<?PHP endif; ?>>
				</div>
	
				<?PHP if (isset($_SESSION['dateError'])): ?>
				<div class="option error text-center"><?=$_SESSION['dateError']?></div>
				<?PHP unset($_SESSION['dateError']); endif; ?>
		</div>
			<div class="col-sm-2 col-xs-6" style="padding-right:1;">
				<div class="customPeriod" style="text-align:right;">													
					<input type="submit" class="add" name="okay" value="Pokaż">  															
				</div>
			</div>
			</form>
			<div class="col-sm-2 col-xs-6" style="padding-left:1;">
				<form action="index.php?action=showBalance" method="post">
					<div class="customPeriod" style="text-align:left;">	
						<input type="submit" class="cancel" name="cancel" value="Anuluj">
					</div>
				</form>
			</div>
	</div>
	<?PHP else: ?>
	<div class="dropdownMenu">
		<button class="dropButton"><?=$_SESSION['whatPeriod']?></button>
		<form action="index.php?action=showBalance" method="post">
			<div id="periods">
				<input type="submit" name="thisMonth" class="period" value="Bieżący miesiąc">
				<input type="submit" name="previousMonth" class="period" value="Poprzedni miesiąc">
				<input type="submit" name="thisYear" class="period" value="Bieżący rok">
				<input type="submit" name="custom" class="period" value="Niestandardowy">	
			</div>
		</form>
	</div>
	<?PHP endif; ?>
	</form>
	<div style="clear:both"></div>
</div>