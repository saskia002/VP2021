<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<input type="email" name="email_input" placeholder="email" value="<?php echo htmlspecialchars($inserted_username); ?>">
	<input type="password" name="password_input" placeholder="salasõna">
	<input type="submit" name="login_submit" value="Logi sisse"><?php echo "\t"; echo $login_error; ?>
</form>