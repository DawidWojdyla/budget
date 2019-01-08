<div class="dropdownMenu">
	<button class="dropButton"><?=$_SESSION['whatPeriod']?></button>
	<form action="index.php?action=showBalance" method="post">
		<div id="periods">
			<input type="submit" name="period" class="period" value="Bieżący miesiąc">
			<input type="submit" name="period" class="period" value="Poprzedni miesiąc">
			<input type="submit" name="period" class="period" value="Bieżący rok">
			<input type="button" name="custom" data-toggle="modal" data-target="#customPeriod" class="period" value="Niestandardowy">
		</div>
	</form>
</div>
<div style="clear:both"></div>
</div>
<div class="modal fade" id="customPeriod" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="tableHead noMargin">
			Wybierz zakres dat:
		</div>
		<form action="index.php?action=showBalance" method="post">
			<div class="text-center" style="color:white; margin-top: 15px;">
				<div style="margin-bottom:5px; font-weight: bold;">
					od<input type="date" class="dateGetting" min="1999-01-01" name="dateFrom">
				</div>
				<div style="font-weight: bold;">
					do<input type="date" class="dateGetting" min="1999-01-01" name="dateTo">
				</div>
			</div>
			<div class="buttons editButtons" style="text-align: center; margin-top: 10px;">
				<input type="submit" class="add" name="period" value="Pokaż">
				<input type="reset" class="cancel" name="cancel" value="Anuluj" onclick="closeModal('customPeriod');">
			</div>
		</form>
	</div>
</div>