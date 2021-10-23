<?php
    //alustame sessiooni
	require_once('page_session.php');

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
<?php require_once('page_footer.php'); ?>