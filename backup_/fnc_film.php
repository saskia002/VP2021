<?php	
	$database = "if21_siim_kr";
	//avan andmebaasi ühenduse
	$conn = new mysqli($server_host, $server_user_name, $server_password, $database); //conn kaudu saab kasutada andmebaasi nagu CMD
	//mysqli(server, kasutaja, parool, andmebaas) 
	//määrame vajaliku kodeeringu
	$conn->set_charset("utf8");
	
	$stmt = $conn->prepare("SELECT * FROM film"); //see nool on nagu cmd nool.(see on muutuja).
	//igaks juhuks, kui on vigu, väljastame need
	echo $conn->error; //see ei ole muutuja.
	//seome tulemused muutujatega.
	$stmt->bind_result($title_from_db, $year_from_db, $duration_from_db, $genre_from_db, $studio_from_db, $director_from_db); //bindib resuldid php koodi. $<nimi>_from_db - from database ehk lihtsam koodist aru saada. seitse muutujuat.
	//käsk vaja täita cmd...
	$stmt->execute();
	//fetch(); nyyd tuleb pyydma hakata andmeid.
	
	//<h3>üealkiri</h3>
	//<ul>
	//<li> Valmimis aasta: 1981</li>
	//...
	//</ul>
	
//Teeb listi siis 1. filmist.
	$films_html = null;
	
//tsykkel, et saada kõik filmid kätte	
	//$stmt->fetch(); //võtab yhe kaupa andmeid. tehakse nii kaua kuni jõutakse l6ppu.
	//whie(tingimus){
		//mida teha;
	//}
	//sellega kontrollib kas saab võtta veel andmeid seini kaua kuini laseb.
	//seda v6ib if ja while sisse panna ja for each ka.
	
	while($stmt->fetch()){
		$films_html .="<h3>" .$title_from_db ."</h3> \n";
		$films_html .= "<ul> \n";
		$films_html .= "<li>Valmimisaasta: ". $year_from_db ."</li> \n";
		$films_html .= "<li>Kestvus: ". $duration_from_db ."</li> \n";
		$films_html .= "<li>žanr: ". $genre_from_db ."</li> \n";
		$films_html .= "<li>Tootja: ". $studio_from_db ."</li> \n";
		$films_html .= "<li>Režissöör: ". $director_from_db ."</li> \n";
		$films_html .= "</ul> \n";
	}
	//sulgeme  SQL käsu
	$stmt->close();
	//sulgeme andmebaasiühenduse
	$conn->close() ;
?>