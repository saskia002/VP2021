<?php
	$database = "if21_siim_kr";
	require_once('fnc_general.php');
	require_once("../../config.php");

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
			$notice = "uudise foto lisamisel andmebaasi tekkis tõrge: " .$stmt->error;
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
	
	function store_news_data($news_text, $news_title, $news_expire_date){
		$news_expire_date_fix = $news_expire_date;

		$latest_photo_id = latest_news_photo_id();

		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("INSERT INTO vp_news (userid, title, content, expire, photoid) VALUES (?, ?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issss", $_SESSION["user_id"], $news_title, $news_text, $news_expire_date_fix, $latest_photo_id);
		if($stmt->execute()){
			$notice = "Uudise info lisati andmebaasi!";
		}else{
			$notice = "uudise info lisamisel andmebaasi tekkis tõrge: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}

	//CREATE TABLE `if21_siim_kr`.`vp_news` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `text` VARCHAR(10000) NOT NULL , `title` VARCHAR(100) NOT NULL , `expire_date` DATETIME  NULL , `added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `userid` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

	//CREATE TABLE `if21_siim_kr`.`vp_news` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `userid` INT(11) NOT NULL , `title` VARCHAR(140) NOT NULL , `content` VARCHAR(2000) NOT NULL , `expire` DATE NOT NULL , `added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `photoid` INT(11) NULL , `deleted` DATETIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;