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
<div class="row">
<div class="topnav" id="topNav">
	<div class="row">
		<div class="col-md-2 nav-item" onclick="location.href='index.php?action=showMenu';">
			<span class='glyphicon glyphicon-home nav-icon'></span> Główna
		</div>
		<div class="col-md-2 nav-item" onclick="location.href='index.php?action=showIncomeAddingForm';">
			<span class='glyphicon glyphicon-usd nav-icon'></span> Dodaj Przychód
		</div>
		<div class="col-md-2 nav-item" onclick="location.href='index.php?action=showExpenseAddingForm';">
			<span class='glyphicon glyphicon-shopping-cart nav-icon'></span> Dodaj Wydatek
		</div>
		<div class="col-md-2 nav-item" onclick="location.href='index.php?action=showBalance';">
			<span class='glyphicon glyphicon-stats nav-icon'></span> Przeglądaj Bilans
		</div>
		<div class="col-md-2 nav-item" onclick="location.href='index.php?action=showSettings';">
			<span class='glyphicon glyphicon-wrench nav-icon'></span> Ustawienia
		</div>
		<div class="col-md-2 nav-item" onclick="location.href='index.php?action=logout';">
			<span class='glyphicon glyphicon-log-out nav-icon'></span> Wyloguj
		</div>
	</div>
	<div class="hamburger" onclick="showTopNav();">
		<span class='glyphicon glyphicon-menu-hamburger login-icon' style="font-size: 20px;"></span>
	</div>
</div>
</div>