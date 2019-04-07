<div class="registerForm">
	<form action="index.php?action=registerUser" method="post">
		<h1>Rejestracja</h1>
		 <?php foreach($formData as $input): ?>
		<div class="form-group"><?=$input->getInputHTML()?></div>
		<?php endforeach;?>
		<div class="captcha"><div class="g-recaptcha" data-sitekey="6LeFT1sUAAAAAG4A7QCqSaZz9bwwCTl5Sv3MJfle"></div></div>
		<div class="form-group">
			<button class="myRegisterInputs add" type="submit"><span class='glyphicon glyphicon-plus nav-icon'></span> Zarejestruj</button>
		</div>
	</form>
</div>