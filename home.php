<?php 
require_once('./page_stuff/page_session.php'); 

	//testime klassi
	require_once("./classes/Test.class.php");
	$my_test_object = new Test();









require_once('./page_stuff/page_header.php'); 
?>
    <ul>
		<li><a href="add_films.php">Lisage filme andmebaasi</a></li><br />
		<li><a href="list_films.php">Andmebaasi lisatud failide list</a></li><br />
		<li><a href="list_movie_info.php">Filmide info</a></li><br />
		<li><a href="movie_relations.php">Filmi info sidumine</a></li><br />
		<li><a href="gallery_photo_upload.php">Fotode üleslaadimine</a></li><br />
		<li><a href="gallery_public.php">Fotode galerii</a></li><br />
		<li><a href="gallery_own.php">Minu fotode galerii</a></li><br />
	</ul> 
</body>
<?php require_once('./page_stuff/page_footer.php'); ?>