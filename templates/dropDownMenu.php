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
				<div style="margin-bottom:5px;">
					<span class="glyphicon glyphicon-play nav-icon"></span><input type="date" class="dateGetting" min="1999-01-01" name="dateFrom" required>
				</div>
				<div >
					<span class="glyphicon glyphicon-stop nav-icon"></span><input type="date" class="dateGetting" min="1999-01-01" name="dateTo" required>
				</div>
			</div>
			<input type="hidden" name="period" value="customPeriod">
			<div class="buttons" style="text-align: center; margin-top: 15px;">
				<button type="submit" class="add noLeftBorder"><span class="glyphicon glyphicon-ok nav-icon"></span> Pokaż</button><button type="reset" class="cancel noRightBorder" name="cancel" onclick="closeModal('customPeriod');"><span class="glyphicon glyphicon-remove nav-icon"></span> Anuluj</button>
			</div>
		</form>
	</div>
</div>