<script type="text/javascript">

$(document).ready(function () {
   // $('.menu').slideDown(500);
    $('.menu').fadeIn(500);
});

</script>

<nav>
	<div class="menu" style="display:none;">
		<ul>
			<li><a href="index.php?action=showIncomeAddingForm">
						<span class='glyphicon glyphicon-plus menu-icon'></span>
						Dodaj przychód
					</a>
				</li>
			<li>
				<a href="index.php?action=showExpenseAddingForm">
					<span class='glyphicon glyphicon-minus menu-icon'></span>
					Dodaj wydatek
				</a>
			</li>
			<li>
				<a href="index.php?action=showBalance">
					<span class='glyphicon glyphicon-stats menu-icon'></span>
					Przeglądaj bilans
				</a>
			</li>
			<li>
				<a href="index.php?action=showSettings">
					<span class='glyphicon glyphicon-cog menu-icon'></span>
					Ustawienia
				</a>
			</li>
		</ul>
	</div>
</nav>