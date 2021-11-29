<?php
	$database = "if21_siim_kr";
	require_once('fnc_general.php');
	require_once("../../config.php");

	////SELECT filename FROM vp_news AS N JOIN vp_newsphotos AS NP ON NP.id = N.photoid; // SELECT filename FROM vp_newsphotos AS NP JOIN vp_news AS N ON N.photoid = NP.id
	function get_news_photo_file_name_from_id($photo_id_news_from_db){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT filename FROM vp_newsphotos AS NP JOIN vp_news AS N ON N.photoid = NP.id WHERE N.photoid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $photo_id_news_from_db);
		$stmt->bind_result($photo_file_name_news_from_db);
		$stmt->execute();
		$stmt->fetch();
		$notice = $photo_file_name_news_from_db;
		
		$stmt->close();
		$conn->close();
		return $notice;
	}

	function read_all_fresh_news_logged_in_usr(){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT title, firstname, lastname, added, content, photoid FROM vp_users AS U JOIN vp_news AS N ON U.id = N.userid where expire >= CURRENT_TIMESTAMP ORDER BY added DESC"); //WHERE added <= (SELECT expire FROM vp_news)
		echo $conn->error;
		$stmt->bind_result($news_title_from_db, $firstname_news_from_db, $lastname_news_from_db, $added_news_from_db, $news_content_from_db, $photo_id_news_from_db);

		$stmt->execute();
		while($stmt->fetch()){
			$notice .= '</div><div style="width: 960px"><hr></div>' ."\n";
			$notice .= '<div class="center body">' ."\n";
			$notice .= "<h3>" .$news_title_from_db ."</h3>\n";
			$est_date =	date_to_est_format($added_news_from_db);
			$notice .= "<p><b>" .$firstname_news_from_db ." " .$lastname_news_from_db  ."</b><i>" ." - " .$est_date ."</i></p>\n";
			$notice .= htmlspecialchars_decode($news_content_from_db, ENT_SUBSTITUTE) ."\n";
			if($photo_id_news_from_db != null){
				$photo_file_name = get_news_photo_file_name_from_id($photo_id_news_from_db);
				$notice .= '<p style="text-align: center;"><img src="'.$GLOBALS["news_photo_normal_upload_dir"] .$photo_file_name .'" alt="Uudise pilt"></p>' ."\n";
			}
		}if($notice ==  null){
			$notice = "Värskeid uudiseid pole hetkel :(\n";
		}

		$stmt->close();
		$conn->close();
		return $notice;
	}

	function store_news_photo_data($image_file_name){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("INSERT INTO vp_newsphotos (filename, userid) VALUES (?, ?)");
		echo $conn->error;
		$stmt->bind_param("si", $image_file_name, $_SESSION["user_id"]);
		if($stmt->execute()){
			$notice = "Uudise foto lisati andmebaasi!";
		}else{
			$notice = "uudise foto lisamisel andmebaasi tekkis tõrge: " .$stmt->error ."\n";
		}
	
		$stmt->close();
		$conn->close();
		return $notice;
	}

	function latest_news_photo_id(){
		$notice = $photo_id = $photo_id_from_db = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		//laetud pilid id:
		$stmt = $conn->prepare("SELECT id FROM vp_newsphotos WHERE added = (SELECT MAX(added) FROM vp_newsphotos)");
		echo $conn->error;
		$stmt->bind_result($photo_id_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $photo_id_from_db;
		}

		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function store_news_data($news_text, $news_title, $news_expire_date, $does_news_have_photo = false){
		//date fix.
		$news_expire_date_fix = $news_expire_date;

		//pilid fix.
		if($does_news_have_photo == true){
			$latest_photo_id = latest_news_photo_id();
		}
		
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("INSERT INTO vp_news (userid, title, content, expire, photoid) VALUES (?, ?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issss", $_SESSION["user_id"], $news_title, $news_text, $news_expire_date_fix, $latest_photo_id);
		if($stmt->execute()){
			$notice = "Uudise info lisati andmebaasi!\n";
		}else{
			$notice = "uudise info lisamisel andmebaasi tekkis tõrge: " .$stmt->error ."\n";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}

	//CREATE TABLE `if21_siim_kr`.`vp_news` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `text` VARCHAR(10000) NOT NULL , `title` VARCHAR(100) NOT NULL , `expire_date` DATETIME  NULL , `added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `userid` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

	//CREATE TABLE `if21_siim_kr`.`vp_news` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `userid` INT(11) NOT NULL , `title` VARCHAR(140) NOT NULL , `content` VARCHAR(2000) NOT NULL , `expire` DATE NOT NULL , `added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `photoid` INT(11) NULL , `deleted` DATETIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;