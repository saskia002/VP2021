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
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</title>
</head>
<body>
	<i><h1><b><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?></b>, veebiprogrammeerimine</h1><br /></i><hr><br />

    <ul>
	<li><a href="add_films.php">Lisage filme andmebaasi</a></li><br />
	<li><a href="list_films.php">Andmebaasi lisatud failide list</a></li><br />
	<li><a href="?logout=1">Logi välja</a></li>
	</ul>
    
</body>
<footer>
	<hr>
	<i><b><p>Siimu veebileht.<br /></b>
	<a href="mailto:siim02@tlu.ee">Saada mullle meil! :)</a><br />
	<i>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsisevaltvõetavat sisu!</p></i>
</footer>
</html>