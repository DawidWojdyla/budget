<?php if(!isset($portal)) die();?>
<!DOCTYPE HTML>
<html lang="pl">

	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Aplikacja internetowa do prowadzenia budżetu osobistego, która pomaga w zapanowaniu nad wydatkami. Dzięki niej zaoszczędzisz pieniądze, by następnie móc spełniać marzenia :)" />
		<meta name="keywords" content="budżet, pieniądze, wydatki, pieniądze, dochód, rozliczenie, kontrola budżetu, portfel, przychód, oszczędzanie, bilans, płatności, budżet osobisty" />
		<meta http-equiv=X-UA-Compatible content="IE=edge" />	
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Budżet osobisty - rejestracja</title>
			
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
		
		<link href="style.css"  type="text/css"  rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet">
		<link rel="stylesheet"  href="css/fontello.css" type="text/css"/>
		
		<script src='https://www.google.com/recaptcha/api.js'></script>

	</head>

	<body>
		<div class="container-fluid">
			<header>
				<div class="rectangle row">	
						<div id="logo" class="col-sm-6">
								BUDŻET<i class="icon-wallet"></i>osobisty
						</div>
						<?php
							if ($portal->getActualUser())
							{
								include 'logInfo.php';
								include 'templates/topNav.php'; 
							}
							else include 'loginDiv.php';
						?>
			</header>			
			<div id="mainContentDiv">
			
				<?php if($message): ?>
				<div id="mess" class="message">
					<?=$message?><?php endif; ?>
				</div>
				<?php if($delay): ?>
					<script> setTimeout(function(){ $('#mess').fadeOut();}, <?=$delay?>); </script>
				<?php endif; ?>
				
				<?php
				switch($action):
					case 'showRegistrationForm' :
						$portal->showRegistrationForm();
						break;
					case 'showMain' :
						include 'templates/main.php';
						break;
					case 'showIncomeAddingForm' :
						switch($portal->showIncomeAddingForm()):
							case LOGIN_REQUIRED:
								$portal->setMessage('Najpierw musisz się zalogować.');
								$portal->hideMessageAfterTime(3000);
								header('Location:index.php?action=showRegistrationForm');
								return;
						case SERVER_ERROR:
								$portal->setMessage('Błąd serwera!');
								$portal->hideMessageAfterTime(3000);
								header('Location:index.php?action=showMenu');
								return;
						default:
							break;
						endswitch;
						break;
					case 'showExpenseAddingForm' :
					  switch($portal->showExpenseAddingForm()):
							case LOGIN_REQUIRED:
								$portal->setMessage('Najpierw musisz się zalogować.');
								$portal->hideMessageAfterTime(3000);
								header('Location:index.php?action=showRegistrationForm');
								return;
						case SERVER_ERROR:
								$portal->setMessage('Błąd serwera!');
								$portal->hideMessageAfterTime(3000);
								header('Location:index.php?action=showMenu');
								return;
						default:
							break;
						endswitch;
					  break;
					case 'showBalance' :
					  switch($portal->showBalance()):
							case LOGIN_REQUIRED:
								$portal->setMessage('Najpierw musisz się zalogować.');
								$portal->hideMessageAfterTime(3000);
								header('Location:index.php?action=showRegistrationForm');
								return;
						case SERVER_ERROR:
								$portal->setMessage('Błąd serwera!');
								$portal->hideMessageAfterTime(3000);
								header('Location:index.php?action=showMenu');
								return;
						default:
							break;
						endswitch;
					  break;
				   case 'showSettings' :
					  switch($portal->showSettings()):
							case LOGIN_REQUIRED:
								$portal->setMessage('Najpierw musisz się zalogować.');
								$portal->hideMessageAfterTime(3000);
								header('Location:index.php?action=showRegistrationForm');
								return;
						case SERVER_ERROR:
								$portal->setMessage('Błąd serwera!');
								$portal->hideMessageAfterTime(3000);
								header('Location:index.php?action=showMenu');
								return;
						default:
							break;
						endswitch;
					  break;
					case 'showMenu':
					default:
						switch($portal->showMenu()){
							case ACTION_OK:
								include 'templates/mainAfterLogin.php';
								break;
							default:
								header('Location:index.php?action=showMain');
						}	
				 endswitch;
				?>
			</div>
		</div>
	</body>
</html>