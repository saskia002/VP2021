<?php
	$author_name = 'Siim';
	
	$weekday_names_et = ['esmaspäev', 'teisipäev', 'kolmapäev', 'neljapäev', 'reede', 'laupäev', 'pühapäev'];
	
	$full_time_now = date('d.m.Y H:i:s');
	$hour_now = date('H');
	//echo $hour_now;
	$weekday_now = date('N');
	//echo $weekday_now;
	$day_category = 'ebamäärane';
	$day_hour_category = 'ebamäärane';
	
	if($weekday_now <= 5){  // < > <= => == !=
		$day_category = 'koolipäev';
		if($hour_now < 8 or $hour_now >= 23){
			$day_hour_category = 'uneaeg';
		} elseif($hour_now >= 8 and $hour_now <= 18){
			$day_hour_category = 'tundide aeg';
		} else{
			$day_hour_category = 'vaba aeg';
		}
	} else{
		$day_category = 'puhkepäev';
		if($hour_now < 10 or $hour_now >= 00){
			$day_hour_category = 'uneaeg';
		} elseif($hour_now >= 10 and $hour_now <= 17){
			$day_hour_category = 'eksisteerimise aeg';
		} else{
			$day_hour_category = 'vaba aeg';
		}
	}
	//echo $day_category;
	
	///loeme fotode kataloogi sisu
	
	$photo_dir = 'photos/';
	$allowed_photo_types = ['image/jpeg', 'image/png'];
	//$all_files = scandir($photo_dir);
	$all_files = array_slice(scandir($photo_dir), 2);
	//echo $all_files; jama!
	//var_dump($all_files);
	//	$only_files = array_slice($all_files, 2);
	//	var_dump($only_files);
	
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
	
	//if(muutuja > 8 and muutuja <= 18) //or //array_rand //

?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?>, Veebiprogrammeerimine</title>
</head>
<body>
	<i><h1><?php echo $author_name; ?>, Veebiprogrammeerimine</h1></i>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt" target="_blank">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<!--<img src="3700x1100_pildivalik187.jpg" alt="Pilt Tallinna Ülikooli Terra õppehoonest" width="600" height="300">
	--->
	<?php echo $pic_html; ?>
<br/>
	<h2>Kursusel õpime</h2>
	<ul>
		<li>HTML keelt</li>
		<li>PHP programmeerimist</li>
		<li>SQL päringukeelt</li>
		<li>jne.</li>
	</ul>
<br/>
<footer>
	<b><p>Lehe avamise hetk: <span><?php echo $weekday_names_et[$weekday_now - 1] . ", " . $full_time_now . ', on ' . $day_category;?></span>.</p></b>
	<b><p>Hetkel on <span><?php echo $day_hour_category;?></span> üliõpliastel.</p></b>
	
	
	
	<br/>
	<i><b><p>Siimu veebileht.<br></i></b>
	<a href="mailto:siim02@tlu.ee">Saada mullle meil! :)</a></p>
	<i><p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsisevaltvõetavat sisu!</p></i>
</footer>

</body>
</html>

<!--
tavaline element
<element> asdsadasd </element>

tyhi (empty)
<elemendinimi />


meta märgid on andmed veebi lehe kohta
--->

