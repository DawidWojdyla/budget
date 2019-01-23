<script>
function showTopNav() {
  var topNav = document.getElementById("topNav");
  if (topNav.className === "topnav") {
    topNav.className += " responsive";
  } else {
    topNav.className = "topnav";
  }
}
</script>
<div class="topnav" id="topNav">
	<a href="index.php?action=showMenu"><span class='glyphicon glyphicon-home nav-icon'></span>Strona Główna</a>
	<a href="index.php?action=showIncomeAddingForm"><span class='glyphicon glyphicon-plus nav-icon'></span>Dodaj Przychód</a>
	<a href="index.php?action=showExpenseAddingForm"><span class='glyphicon glyphicon-minus nav-icon'></span>Dodaj Wydatek</a>
	<a href="index.php?action=showBalance"><span class='glyphicon glyphicon-stats nav-icon'></span>Przeglądaj Blans</a>
	<a href="index.php?action=showSettings"><span class='glyphicon glyphicon-cog nav-icon'></span>Ustawienia</a>
	<a href="javascript:void(0);" class="hamburger" onclick="showTopNav()">
		<span class='glyphicon glyphicon-menu-hamburger login-icon' style="font-size: 20px;"></span>
	</a>
</div>