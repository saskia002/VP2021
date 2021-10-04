<?php
	//alustame sessiooni
    session_start();
    require_once("../../config.php");
    require_once("fnc_user.php");
	
	//välja logimine
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    }
	
		//sõned
		$author_name = "Siim";
		$todays_evaluation = null; //$todays_evaluation = "";
		$inserted_adjective = null;
		$adjective_error = null;
		$inserted_username = null;
		$login_error = null;
		
		//kontrollin kas on klikitud submit nuppu
		if(isset($_POST["todays_adjective_input"])){
			//echo "Klikiti nuppu!";
			//kas midagi kirjutati ka
			if(!empty($_POST["adjective_input"])){
				$todays_evaluation = "<p>Tänane päev on <strong>" .$_POST["adjective_input"] ."</strong>.</p> \n <hr> \n";
				$inserted_adjective = $_POST["adjective_input"];
			} else {
				$adjective_error = "Palun kirjuta tänase päeva kohta sobiv omadussõna!";
			}
		}
		//var_dump($_POST);	
		$pic_num = null;
		$photo_dir = "./photos/";
		$allowed_photo_types = ["image/jpeg", "image/png"];
		$all_files = array_slice(scandir($photo_dir), 2);
		$photo_files = [];
		foreach($all_files as $file){
			$file_info = getimagesize($photo_dir .$file);
			if(isset($file_info["mime"])){
				if(in_array($file_info["mime"], $allowed_photo_types)){
					array_push($photo_files, $file);
				}
			}
		}
		$limit = count($photo_files);
		$pic_num = mt_rand(0, $limit - 1);
		
		
		if(isset($_POST["photo_select_submit"])){
			$pic_num = $_POST["photo_select"];
		}
		
		$pic_file_html = null;
		$pic_file = $photo_files[$pic_num];
		$pic_html = '<img src="' .$photo_dir .$pic_file .'" alt="Tallinna Ülikool">';
		
		$pic_file_html = "\n <p>".$pic_file ."</p> \n";
		
		//fotode nimekiri
		//<p>Valida on järgmised fotod: <strong>foto1.jpg</strong>, <strong>foto2.jpg</strong>, <strong>foto3.jpg</strong>.</p> 
		//<ul>Valida on järgmised fotod: <li>foto1.jpg</li> <li>foto2.jpg</li> <li>foto3.jpg</li></ul>
		$list_html = "<ul> \n";
		for($i = 0; $i < $limit; $i ++){
			$list_html .= "<li>" .$photo_files[$i] ."</li> \n";
		}
		$list_html .= "</ul>";
		
		$photo_select_html = '<select name="photo_select">' ."\n";
		for($i = 0; $i < $limit; $i ++){
			//<option value="0">fail.jpg</option>
			$photo_select_html .= "\t \t" .'<option value="' .$i .'"';
			if($i == $pic_num){
				$photo_select_html .= " selected";
			}
			$photo_select_html .= ">" .$photo_files[$i] ."</option> \n";
		}
		$photo_select_html .= "</select> \n";
		
    //sisselogimine
    if(isset($_POST["login_submit"])){
        sign_in($_POST["email_input"], $_POST["password_input"]);
		if(!empty($_POST['email_input']) and isset($_POST['email_input'])){
			$inserted_username = $_POST['email_input'];
		}
		if(!empty($_POST['password_input']) and isset($_POST['password_input'])){
			if(strlen($_POST['password_input']) < 8){
				$login_error = 'Parool peab olema pikem kui 8 märki!';
			}
		}
		if(empty($_POST['email_input']) or empty($_POST['password_input'])){
			$login_error = 'Palun kontrollige, et sisestatud andmed oleksid õiged!';
		}
		
    }		
	require('page_header.php');
?>
	<i><h1><?php echo $author_name; ?>, Veebiprogrammeerimine</h1></i>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <p><input type="email" name="email_input" placeholder="email" value="<?php echo htmlspecialchars($inserted_username); ?>">
        <input type="password" name="password_input" placeholder="salasõna">
        <input type="submit" name="login_submit" value="Logi sisse"><?php echo '    '; echo $login_error; ?></p>
    </form>
	<p><a href="add_user.php">Loo endale kasutaja</a></p>
	<hr>
	
	<form method='POST'>
		<input type='text' name='adjective_input' placeholder='omadussõna tänase kohta' value='<?php echo $inserted_adjective; ?>'>
		<input type='submit' name='todays_addjetive_input' value='Saada ära!'>
		<span><?php echo $adjective_error;?></span>
	</form>
	
	<hr>
	<?php
		echo $todays_evaluation;
		
	?>
	<form method="POST">
		<?php echo $photo_select_html; ?>
		<input type="submit" name="photo_select_submit" value="Näita valitud fotot">
	</form><br />
	<?php
		echo $pic_html;
		echo $pic_file_html;
		echo "<hr> \n";
		echo $list_html;
	?>
<br />
</body>
<footer>
	<br />
	<a href="?logout=1">Logi välja</a>
	<i><b><p>Siimu veebileht.<br /></b>
	<a href="mailto:siim02@tlu.ee">Saada mullle meil! :)</a><br />
	<i>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsisevaltvõetavat sisu!</p></i>
</footer>
</html>