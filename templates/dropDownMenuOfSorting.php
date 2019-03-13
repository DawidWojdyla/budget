<div class="dropdownMenuContainer" style="display:none;">
	<div class="dropdownMenu" style="float: left; width: 120px;">
		<button class="dropButton">Sortowanie</button>
		<form action="index.php?action=showBalance" method="post">
			<div id="periods">
				<input type="submit" name="whatSorting" class="period" value="malejąca data">
				<input type="submit" name="whatSorting" class="period" value="rosnąca data">
				<input type="submit" name="whatSorting" class="period" value="malejąca kwota">
				<input type="submit" name="whatSorting" class="period" value="rosnąca kwota">	
			</div>
		</form>
	</div>