<?php
    $css_color = null;	
	//värvi saad siit if statemendiga kaudu paika sättida. ja kui ei ss deafult
	$def_bg_color = "#AAA";
	$def_text_color = "#101010";
	
	if(isset($_SESSION["user_id"])){
		$css_color .= "\tbackground-color: " .$_SESSION["bg_color"] ."; \n";
		$css_color .= "\tcolor: " .$_SESSION["text_color"] ."; \n";
    }else{	
		$css_color .= "\tbackground-color: " .$def_bg_color ."; \n";
		$css_color .= "\tcolor: " .$def_text_color ."; \n";
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

?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<?php 
		echo $user_status_header_head; echo "\n";
		if(isset($to_head) and !empty($to_head)){
			echo $to_head;
		}
	?>
	<style>
		html {
			height: 100%;
		}
		body {
			<?php echo $css_color; ?>
			display: flex; 
			flex-direction: column; 
			min-height: 100%;
			max-width: 960px;
			margin: auto;
		}
		.center {
			display: block;
			margin-left: auto;
			margin-right: auto;
			width: 95%;
		}
		footer {
			margin-top:auto; 
			bottom: 0px;
			text-align: center;
			align-items:center;
			font-size: 14px;
		}
		ul.topnav {
			position: -webkit-sticky; /* Safari */
			position: sticky;
			top: 0;
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
			background-color: gray;
		}
		ul.topnav li {
			float: left;
		}
		ul.topnav li a {
			display: block;
			color: white;
			text-align: center;
			padding: 4px 8px 4px 8px;
			text-decoration: none;
		}
		ul.topnav li a:hover:not(.active) {background-color: #111;}
		ul.topnav li a.active {background-color: #04AA6D;}
	</style>
	    <?php
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