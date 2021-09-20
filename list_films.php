<?php
	$author_name = "Siim";
	require_once("../../config.php");
	//echo $server_host;
	require_once("fnc_film.php");
	$films_html = null;
	$films_html= read_all_films();
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?>, Veebiprogrammeerimine</title>
</head>
<style>
.content {
  max-width: 960px;
  margin: auto;
}
</style>
<body>
	<i><h1><?php echo $author_name; ?>, Veebiprogrammeerimine</h1></i><hr><br />
<div class="content">
	<h2>Eesti filmid</h2>
	<?php echo $films_html; ?>
	<br />
</div>
</body>
<footer>
	<hr>
	<i><b><p>Siimu veebileht.<br /></b>
	<a href="mailto:siim02@tlu.ee">Saada mullle meil! :)</a><br />
	<i>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsisevaltvõetavat sisu!</p></i>
</footer>
</html>