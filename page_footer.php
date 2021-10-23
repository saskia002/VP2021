<?php
	//näitan välja logimis nuppu kui sise logitud
	$user_status_footer = null;
	if(isset($_SESSION["user_id"])){
        $user_status_footer = '<li><a href="?logout=1">Logi välja</a></li>';
    }
	//kui on sisse logitud näita nuppu ja kui nuppu on vajutatud siis logib välja ja saadab ava lehele.

	/* <?php require_once('page_footer.php'); ?> */
?>
<footer>
	<br />
	<hr>
	<ul>
		<?php echo $user_status_footer; ?>
		<li><a href="home.php">Avaleht/Home</a></li>
	</ul>
	<hr>
	<i><b><p>Siimu veebileht.<br /></b>
	<a href="mailto:siim02@tlu.ee">Saada mullle meil! :)</a><br />
	<i>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsisevaltvõetavat sisu!</p></i>
</footer>
</html>