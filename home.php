<?php 
require_once('./page_stuff/page_session.php');
require_once("./page_fnc/fnc_news_upload.php");
	//Küpsiste test.
	setcookie("vpvisitor", $_SESSION["first_name"] ." " .$_SESSION["last_name"], time() + (86400 * 8), "~/siikri/public_html/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
	$last_visitor = null;
	if(isset($_COOKIE["vpvisitor"])){
		$last_visitor = "<p>Viimati külastas lehte: " .$_COOKIE["vpvisitor"] ."</p> \n";
	}else{
		$last_visitor = "<p>Küpsiseid ei leitud</p>";
	}
	//küpsiste kustutamiseks talle varasem aegumine.
	//setcookie("vpvisitor", $_SESSION["first_name"] ." " .$_SESSION["last_name"], time() -3600, "~/siikri/public_html/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
	//var_dump($_COOKIE);
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
		<li><a href="add_news.php">Uudiste lisamine</a></li><br />
	</ul>
	</div><div style="width: 960px"><hr></div><div class="center body">
	<ul> 
		<li><a href="register_to_event.php">Reg. peole</a></li><br />
		<li><a href="cancel_register_to_event.php">Ütle peost ära</a></li><br />
		<li><a href="admin_event_info.php">Peo info adminile</a></li><br />
	</ul>
	</div><div style="width: 960px"><hr></div><div class="center body">
<?php
	echo $last_visitor;
	//Siia see värksete uudiste näitamine
	echo read_all_fresh_news_logged_in_usr();
	require_once('./page_stuff/page_footer.php'); 
?>