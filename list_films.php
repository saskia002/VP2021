<?php
    require_once('./page_stuff/page_session.php');
    require_once("../../config.php");
	//echo $server_host;
	require_once("./page_fnc/fnc_film.php");
	$films_html = null;
	$films_html= read_all_films();
	
	require_once('./page_stuff/page_header.php')
?>
	<h2>Eesti filmid</h2>
	<?php echo $films_html; ?>
<?php require_once('./page_stuff/page_footer.php'); ?>