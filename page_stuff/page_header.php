<?php
    $css_color = null;	
	//värvi saad siit if statemendiga kaudu paika sättida. ja kui ei ss deafult
	//$def_bg_color = "#AAA";
	//$def_text_color = "#101010";
	
	if(isset($_SESSION["user_id"])){
		$css_color = "<style>" ."\n";
		$css_color .= "body {" ."\n";
		$css_color .= "\tbackground-color: " .$_SESSION["bg_color"] ."; \n";
		$css_color .= "\tcolor: " .$_SESSION["text_color"] ."; \n";
		$css_color .= "}" ."\n";
		$css_color .= "</style>";
    }
	//näitan kas kasutaja nime või looja nime
	$author_name = "Siim";
	$user_status_header_head = null;
	$user_status_header_body = null;
	if(isset($_SESSION["user_id"])){
		$user_status_header_head = '<title>'. $_SESSION["first_name"] ." " .$_SESSION["last_name"]. ', veebiprogrammeerimine</title>';
        //$user_status_header_body = '<p class="image"><img src="photos/vp_banner.png" alt="veebiprogrammeerimise lehe bänner">'. "\n". '<i><h1><b></p>'. $_SESSION["first_name"] ." " .$_SESSION["last_name"]. '</b>, veebiprogrammeerimine</h1></i>';
    }else{
		//$user_status_header_head = '<title class=>'. $author_name. ', veebiprogrammeerimine</title>';
		$user_status_header_body = '<i><h1>'. $author_name. ', Veebiprogrammeerimine</h1></i>';
	}
	//kui on sisse logitud näita kasutaja nime ja kui ei siis looja nime.
	$page_icon = '<link rel="shortcut icon" type="image/jpg" href="./photos_2/pics/vp_logo_w100_overlay.png"/>';
	$page_css = '<link rel="stylesheet" type="text/css" href="style/page_style.css">';
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<?php 
		echo $user_status_header_head;
		echo $page_icon;
		echo $css_color;
		echo $page_css;
		if(isset($to_head) and !empty($to_head)){
			echo $to_head;
		}
	?>
</head>
<body>
	<?php require_once('page_navbar.php'); ?>
	<p style="text-align: center;"><img src="photos/vp_banner.png" alt="veebiprogrammeerimise lehe bänner"></p>
	<div style="width: 960px; padding-bottom: 8px;"><hr></div>
	<div class="center body">