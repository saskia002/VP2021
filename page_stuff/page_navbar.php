<?php
	//näitan välja ROHKEM nuppe kui sisse logitud
	$login_error = null;
	$inserted_username = null;
	$user_status_nav_bar = null;

	//php ja html kaudu login rida n2itamine kui pole sisse logitud.
	$login_promt = '<li><a href="page.php">Avaleht </a></li><li style="float: right; text-align-last:center; padding-top:2px; padding-left:2px;"><div style="padding-left: 0;"><form method="POST" action="' .htmlspecialchars($_SERVER["PHP_SELF"]) .'"><input type="email" name="email_input" placeholder="email" value="' .htmlspecialchars($inserted_username) .'"><input type="password" name="password_input" placeholder="salasõna"><input type="submit" name="login_submit" value="Logi sisse"></div>' ."\t" .$login_error .'</form></li><li style="float:right"><a href="add_user.php">Loo endale kasutaja</a></li>' ."\n";

	if(isset($_SESSION["user_id"])){
		$user_status_nav_bar = '<li><a href="page.php">Avaleht</a></li>' ."\n\t" .'<li><a href="home.php">Vaheleht</a></li>' ."\n\t". '<li style="float:right"><a href="user_profile.php">Kasutajaprofiil</a></li>' ."\n\t" .'<li style="float:right"><a href="?logout=1">Logi välja</a></li>' ."\n\t";
	}
	
?>
<ul class="topnav">
	<?php 
		//php ja html kaudu login rida n2itamine kui pole sisse logitud.
		if(!isset($_SESSION["user_id"])){
			$htlm_echo = html_entity_decode($login_promt, ENT_QUOTES, 'UTF-8');
			echo html_entity_decode($htlm_echo, ENT_NOQUOTES, 'UTF-8'); 
		}else{
			echo $user_status_nav_bar;
		}
	?>
</ul>