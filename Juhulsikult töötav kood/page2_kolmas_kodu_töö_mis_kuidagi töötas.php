<?php
	$author_name = "Siim";
	$todays_evaluation = null; //$todays_evaluation = "";
	$inserted_adjective = null;
	$adjective_error = null;
	$picture_choice_error = null;

//Nupp
	//kontrollin kas on klikitud submit nuppu
	if(isset($_POST["todays_adjective_input"])){
		//echo "Klikiti nuppu!";
		//kas midagi kirjutati ka
		if(!empty($_POST["adjective_input"])){
			$todays_evaluation = "<p>Tänane päev on <strong>" .$_POST["adjective_input"] ."</strong>.</p><hr>";
			$inserted_adjective = $_POST["adjective_input"];
		} else {
			$adjective_error = "Palun kirjuta tänase päeva kohta sobiv omadussõna!";
		}
	}



//Piltide sorteerimine

	$photo_dir = "photos/";
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
	$pic_file = $photo_files[$pic_num];
	$pic_html = '<img src="' .$photo_dir .$pic_file .'" alt="Tallinna Ülikool">';
	
//fotode nimekiri

	$list_html = "<ul> \n";
	for($i = 0; $i < $limit; $i ++){
		$list_html .= "<li>" .$photo_files[$i] ."</li> \n";
	}
	$list_html .= "</ul>";
	
	
//sealt nuppust valiku tegemine ja ss selle pildi näitamine.

	$first_choice = 'Valige pilt';

	$photo_select_html = '<select name="photo_select">' ."\n";
	$photo_select_html .= '<option value="0">' .$first_choice .'</option>' . "\n";
	for($i = 0; $i < $limit; $i ++){
		$l = $i + 1;
		$photo_select_html .= '<option value="' .$l .'">' .$photo_files[$i] ."</option> \n";
	}
	$photo_select_html .= '</select><input type="submit" name="picture_choice_input" value="Vali">';
	if(isset($_POST['picture_choice_input'])){
		if(!empty($_POST['photo_select'])){
			$pic_choice_num = $_POST['photo_select'];
			$pic_choice_num -= 1;
			$pic_choice_file = $photo_files[$pic_choice_num];
			$pic_choice_html = '<img src="' . $photo_dir . $pic_choice_file . '"alt="Pilt TLÜ õppehoonest">';
			$first_choice = $pic_choice_file;
			echo $pic_choice_html;
			echo "<br /><i>" .$pic_choice_file ."<br /></i>";
		}else{
			$picture_choice_error = "Valige õige pilt!";
		}
	}	
//kms
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?>, Veebiprogrammeerimine</title>
</head>
<body>
	<i><h1><?php echo $author_name; ?>, Veebiprogrammeerimine</h1></i>
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
	<form method='POST'>
	<?php 
	echo $photo_select_html; 
	?>
	</form><br />
	<?php
		echo $pic_html; 
		echo $list_html;
		?>
<br />
</body>
<footer>
	<br />
	<i><b><p>Siimu veebileht.<br /></b>
	<a href="mailto:siim02@tlu.ee">Saada mullle meil! :)</a><br />
	<i>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsisevaltvõetavat sisu!</p></i>
</footer>
</html>