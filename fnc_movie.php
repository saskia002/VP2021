<?php	
	$database = "if21_siim_kr";
	
	//bind param siis kui salvestad ja bind rrsult sisik ui loed.
	
	function read_all_person($selected){
		$html = null;
		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']);
		$conn->set_charset("utf8");
		
		//<option value="x" selected="">eesnimi perekonnanimi</option>
		$stmt = $conn->prepare("SELECT id, first_name, last_name, birth_date FROM person");
		
		$stmt->bind_result($id_from_db, $first_name_from_db, $last_name_from_db, $birth_date_from_db);
		$stmt->execute();
		
		//fetch võtab järjest jne....
		while($stmt->fetch()){
			$html .= '<option value="' .$id_from_db .'"';
			if($selected == $id_from_db){
				$html .= ' selected';
			}
		$html .= '>' .$first_name_from_db .' ' .$last_name_from_db .' (' .$birth_date_from_db .')</option>' ."\n\t\t\t\t";
		}
		
		$stmt->close();
		$conn->close();
		return $html;
	}
	
	function read_all_movie($selected_movie){
		$html_1 = null;
		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']);
		$conn->set_charset("utf8");
		
		//<option value="" selected disabled>vali film</option>
		$stmt = $conn->prepare("SELECT id, title, production_year, duration, description FROM movie");
		
		$stmt->bind_result($id_from_db, $title_from_db, $production_year_from_db, $duration_from_db, $description_from_db);
		$stmt->execute();
		
		while($stmt->fetch()){
			$html_1 .= '<option value="' .$id_from_db .'"';
			if($selected_movie == $id_from_db){
				$html_1 .= ' selected';
			}
			$html_1 .= '>' .$title_from_db .' (' .$production_year_from_db .')</option>' ."\n\t\t\t\t";
		}
		
		$stmt->close();
		$conn->close();
		return $html_1;
	}

	function read_all_position($select_position){
		$html_2 = null;
		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']);
		$conn->set_charset("utf8");
		
		//<option value="" selected disabled>vali film</option>
		$stmt = $conn->prepare("SELECT id, position_name, description FROM position");
		
		$stmt->bind_result($id_from_db, $position_name_from_db, $description_from_db);
		$stmt->execute();
		
		while($stmt->fetch()){
			$html_2 .= '<option value="' .$id_from_db .'"';
			if($select_position == $id_from_db){
				$html_2 .= ' selected';
			}
			$html_2 .= '>' .$position_name_from_db .'</option>' ."\n\t\t\t\t";
		}
		
		$stmt->close();
		$conn->close();
		return $html_2;
	}

	function store_person_in_movie($person_id, $movie_id, $position_id, $role){
		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']); 
		$conn->set_charset("utf8");
		
		//kas käske saab yldse täita.
		$stmt = $conn->prepare("INSERT INTO person_in_movie(person_id, movie_id, position_id, role) VALUES(?, ?, ? ,?)");
		echo $conn->error;
		
		//seon sql käsu päris andmetega. andmetyybid on: i - integer, d - decimal (murdarv), s - string.
		$stmt->bind_param("iiis", $person_id, $movie_id, $position_id, $role);
		
		$success = null;
		if($stmt->execute()){ //kui programmi osa ilusti t66tas.
			$success = "Salvestamine õnnestus!";
		}else{
			$success = "Salvestamisel tekkis viga!" .$stmt->error;
		}
		
		//person_in_movie
		
		$stmt->close();
		$conn->close();
		return $success;
	}
	
//Vana kraam---------------------------------------------------------
	function read_all_films(){
			//var_dump($GLOBALS);
			//$GLOBALS on globaalne muutujua saab teise failide vahel suhelta nagu;
		//avan andmebaasi ühenduse
		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']); //conn kaudu saab kasutada andmebaasi nagu CMD
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
		$conn->close();
		
		//väljaspoolt muutuja ei näe funk sees muutujuat. GLOBALS kaudu saab saata funk läbi funk vatsuse välja saata.
		return $films_html; // saadetakse välja funk.
	}	
	function store_film($title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input){
		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']); 
		$conn->set_charset("utf8");
		
		//kas käske saab yldse täita.
		$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) Values(?, ?, ? ,?, ?, ?)");
		echo $conn->error;
		
		//seon sql käsu päris andmetega. andmetyybid on: i - integer, d - decimal (murdarv), s - string.
		$stmt->bind_param("siisss", $title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input);
		
		$success = null;
		if($stmt->execute()){ //kui programmi osa ilusti t66tas.
			$success = "Salvestamine õnnestus!";
		}else{
			$success = "Salvestamisel tekkis viga!" .$stmt->error;
		}
		
		
		$stmt->close();
		$conn->close();
		return $success;
	}
?>