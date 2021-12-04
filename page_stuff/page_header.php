<?php
    $css_color = null;	
	//värvi saad siit if statemendiga kaudu paika sättida. ja kui ei ss deafult
	$def_bg_color = "#303436";
	$def_text_color = "white";//"#101010";
	
	$css_color = "<style> \n";
	$css_color .= "body { \n";
		if(isset($_SESSION["bg_color"]) and isset($_SESSION["text_color"])){
			$css_color .= "\tbackground-color: " .$_SESSION["bg_color"] .";\n";
			$css_color .= "\tcolor: " .$_SESSION["text_color"] .";\n";
		}else{
			$css_color .= "\tbackground-color: " .$def_bg_color ."; \n";
			$css_color .= "\tcolor: " .$def_text_color ."; \n";
		}
	$css_color .= "} \n";
	$css_color .= "</style> \n";
    

	//näitan kas kasutaja nime või looja nime
	$author_name = "Siim";
	$user_status_header_head = null;
	$user_status_header_body = null;
	if(isset($_SESSION["user_id"])){
		$user_status_header_head = '<title>'. $_SESSION["first_name"] ." " .$_SESSION["last_name"]. ', VP</title>';
        //$user_status_header_body = '<p class="image"><img src="photos/vp_banner.png" alt="veebiprogrammeerimise lehe bänner">'. "\n". '<i><h1><b></p>'. $_SESSION["first_name"] ." " .$_SESSION["last_name"]. '</b>, veebiprogrammeerimine</h1></i>';
    }else{
		//$user_status_header_head = '<title class=>'. $author_name. ', veebiprogrammeerimine</title>';
		$user_status_header_body = '<i><h1>'. $author_name. ', VP</h1></i>';
	}
	//kui on sisse logitud näita kasutaja nime ja kui ei siis looja nime.
	$page_icon = '<link rel="shortcut icon" type="image/jpg" href="./photos_2/pics/vp_logo_w100_overlay.png"/>' ."\n";
	$page_css = '<link rel="stylesheet" type="text/css" href="style/page_style.css">' ."\n";
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<?php 
		echo $user_status_header_head;
		echo $page_icon;
		echo $page_css;
		echo $css_color;
		if(isset($to_head) and !empty($to_head)){
			echo $to_head;
		}
	?>
</head>
<body>
	<?php require_once('page_navbar.php'); ?>
	<br>
	<div class="center_style" style="padding-top: 6px;"><img src="photos/vp_banner.png" alt="veebiprogrammeerimise lehe bänner"></div>
	<hr>