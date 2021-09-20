<?php
	$author_name = "Siim";
	require_once("../../config.php");
	//echo $server_host;
	require_once("fnc_film.php");

	$film_store_notice = null;

	//kas pyytakse salvestata
	if(isset($_POST['film_submit'])){
		//kontrollin et on ikka sisestaud
		if((!empty($_POST['title_input'])) and (!empty($_POST['year_input'])) and (!empty($_POST['genre_input'])) and (!empty($_POST['studio_input'])) and (!empty($_POST['director_input']))){
			
			$film_store_notice = store_film($_POST['title_input'], $_POST['year_input'], $_POST['duration_input'], $_POST['genre_input'], $_POST['studio_input'], $_POST['director_input']);
			
		}else{
			$film_store_notice = "Osa andmeid on puudu!";
		}
	}

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
	<h2>Eesti filmide lisamine andmebaasi:</h2>
	
	<!-- andmebaasi saatmine, id= on php jaoks ja name htmli jaoks -->
	<form method="POST">
		<label for="title_input">Filmi pealkiri</label>
		<input type="text" name="title_input" id="title_input" placeholder="Filmi pealkiri">
		<br />
		<label for="year_input">Valmimisaasta</label>
		<input type="number" name="year_input" id="year_input" min="1912">
		<br />
		<label for="duration_input">Kestus</label>
		<input type="number" name="duration_input" id="duration_input" min="1" value="60" max="600">
		<br />
		<label for="genre_input">Žanr</label>
		<input type="text" name="genre_input" id="genre_input" placeholder="Žanr">
		<br />
		<label for="studio_input">Filmi tootja</label>
		<input type="text" name="studio_input" id="studio_input" placeholder="Filmi tootja">
		<br />
		<label for="director_input">Režissöör</label>
		<input type="text" name="director_input" id="director_input" placeholder="Režissöör">
		<br />
		<input type="submit" name="film_submit" value="Salvesta">
	</form>
	<br />
	<span> <?php echo $film_store_notice; ?></span>
</div>
</body>
<footer>
	<hr>
	<i><b><p>Siimu veebileht.<br /></b>
	<a href="mailto:siim02@tlu.ee">Saada mullle meil! :)</a><br />
	<i>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsisevaltvõetavat sisu!</p></i>
</footer>
</html>