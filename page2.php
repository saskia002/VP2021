<?php
	$author_name = 'Siim';
	$todays_evaluation = null; // või $todays_evaluation = ''
	$inserted_adjective = null;
	$adjective_error = null;
	
	//kontrollin kas on klikitud submit nuppu
	// GET ebaturvaline(urlist on näha submit vastust), POST turvalisem.
	//isset - kas see asi on väärtuse saanud / empty - kas on tyhi / !empty - kas ei ole tyhi.
	//var_dump($_POST);
	if(isset($_POST['todays_addjetive_input'])){
		//echo 'Klikiti nuppu';
		//kas midagi kirjutati
		if(empty($_POST['adjective_input'])){
			$todays_evaluation = '<p>Tänane päev on <strong>' . $_POST['adjective_input'] . '</strong>.</p>';
			$inserted_adjective = $_POST['adjective_input'];
		} else{
			$adjective_error = 'Palun kirjuta tänase päeva kohta sobiv omadussõna!';
		}
	}
	
	
	///loeme fotode kataloogi sisu
	$photo_dir = 'photos/';
	$allowed_photo_types = ['image/jpeg', 'image/png'];
	$all_files = array_slice(scandir($photo_dir), 2);

	//s6elun välja ainult lubatud pildid
	$photo_files = [];
	foreach($all_files as $file){
		$file_info = getimagesize($photo_dir . $file);
		if(isset($file_info['mime'])){ // isset - kas sai väärtuse.
			if(in_array($file_info['mime'], $allowed_photo_types)){
				array_push($photo_files, $file);
			}
		} 
	}
	
	
	$limit = count($photo_files);
	$pic_num = mt_rand(0, $limit - 1);
	$pic_file = $photo_files[$pic_num];
	//<img src='pilt.jpg' alt='tallinna ülikool'>
	$pic_html = '<img src="' . $photo_dir . $pic_file . '" alt="Pilt Tallinna Ülikooli õppehoonest" width="600" height="300">';
	
	//fotode nimekiri
	//<p>Valida on järgmised fotod: <strong>sdfnjsd.png</strong>.</p>
	
	//<ul> Valida on järgmised fotod: <li>jasjdjasj.gif</li>  </ul>
	
	$list_html = '<ul>';
	for($i = 0;$i < $limit; $i ++){
		$list_html .= '<li>' . $photo_files[$i] . '</li>';
	}
	$list_html .= '</ul>';
	
	$photo_select_html = '<select name="photo_select">' ."\n";
		for($i = 0; $i < $limit; $i ++){
			//<option value="0">fail.jpg</option>
			$photo_select_html .= '<option value="' . $i .'">' . $photo_files[$i] . "</options> \n";
		}
	$photo_select_html .= "</select> \n"
	
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
	<?php echo $photo_select_html; ?>
	</form>
	<?php
		echo $pic_html; 
		echo $list_html;
	?>
	


<br/>
</body>
<footer>
	<br/>
	<i><b><p>Siimu veebileht.<br></i></b>
	<a href="mailto:siim02@tlu.ee">Saada mullle meil! :)</a></p>
	<i><p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsisevaltvõetavat sisu!</p></i>
</footer>
</html>