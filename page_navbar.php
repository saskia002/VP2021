<?php
	//näitan välja ROHKEM nuppe kui sisse logitud
	$login_error = null;
	$inserted_username = null;
	$user_status_footer = null;
	if(isset($_SESSION["user_id"])){
		$user_status_footer = '<li><a href="page.php">Page</a></li>';
        $user_status_footer .= '<li><a href="home.php">Home</a></li>';
		$user_status_footer .= '<li style="float:right"><a href="?logout=1">Logi välja</a></li>';
		$user_status_footer .= '<li style="float:right"><a href="user_profile.php">Kasutajaprofiil</a></li>';
	    }
?>
<ul class="topnav">
	<li style="float:left; padding-top:2px; padding-left:2px;">
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type="email" name="email_input" placeholder="email" value="<?php echo htmlspecialchars($inserted_username); ?>">
			<input type="password" name="password_input" placeholder="salasõna">
			<input type="submit" name="login_submit" value="Logi sisse"><?php echo "\t"; echo $login_error; ?>
		</form>
	</li>
	<li style="float:right"><a href="add_user.php">Loo endale kasutaja</a></li>
	<?php echo $user_status_footer; ?>
</ul>