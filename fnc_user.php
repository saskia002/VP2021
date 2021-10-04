<?php
	$database = "if21_siim_kr";
	
	function store_new_user($name, $surname, $gender, $birth_date, $email, $password){
		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']);
		$conn->set_charset("utf8");
		$notice = null;
		$stmt = $conn->prepare("SELECT id FROM vp_users WHERE email = ?");
		if($stmt->fetch()){
			$notice = "Selle e-mailiga on kasutaja juba loodud!";
		} else {
		$stmt = $conn->prepare("INSERT INTO vp_users(firstname, lastname, birthdate, gender, email, password) VALUES(?, ?, ?, ?, ?, ?)");
		echo $conn->error;
		//krüpteerime prarooli
		$option = ["cost" => 12];  //kandilised sulud on massiiv. // cost on palju vaeva nähakse parooli krüpteerimisesk 12 on max. sool lisatakse automaatselt.
		$pwd_hash = password_hash($password, PASSWORD_BCRYPT, $option); //passwd actual cryptimine.
		
		//serverisse saatmine
		$stmt->bind_param("sssiss", $name, $surname, $birth_date, $gender, $email, $pwd_hash);//kysim2rgid pindid nyyd et severisse saata. need tähed olid s sõnad i tähed. ning selle järgi saab see järjekorrasta ru ilusti.
		
		if($stmt->execute()){
			$notice = 'Uus kasutaja edukalt loodud.';
		}else{
			$notice = 'Uue kasutaja loomisel tekkis viga.' .$stmt->error;
		}
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	

    function sign_in($email, $password){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM vp_users WHERE email = ?");
        echo $conn->error;
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db, $password_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            //tuli vaste, kontrollime parooli
            if(password_verify($password, $password_from_db)){
                //sisse logimine
                $_SESSION["user_id"] = $id_from_db;
                $_SESSION["first_name"] = $firstname_from_db;
                $_SESSION["last_name"] = $lastname_from_db;
                $stmt->close();
                $conn->close();
                header("Location: home.php");
                exit();
            } else {
                $notice = "Kasutajanimi või parool on vale!";
            }
        } else {
            $notice = "Kasutajanimi või parool on vale!";
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }