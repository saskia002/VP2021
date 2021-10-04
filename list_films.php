<?php
	//alustame sessiooni
    session_start();
    //kas on sisselogitud
    if(!isset($_SESSION["user_id"])){
        header("Location: page.php");
    }
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    }

	$author_name = "Siim";
	require_once("../../config.php");
	//echo $server_host;
	require_once("fnc_film.php");
	$films_html = null;
	$films_html= read_all_films();
	require_once('page_header.php')
?>

	<h2>Eesti filmid</h2>
	<?php echo $films_html; ?>
	<br />
</div>
</body>
<footer>
	<hr>
	<a href="?logout=1">Logi välja</a>
	<i><b><p>Siimu veebileht.<br /></b>
	<a href="mailto:siim02@tlu.ee">Saada mullle meil! :)</a><br />
	<i>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsisevaltvõetavat sisu!</p></i>
</footer>
</html>