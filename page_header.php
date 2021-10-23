<?php
    $css_color = null;
    //<style>
    //  body {
    //     background-color: #FFFFFF;
    //     color: #000000;
    //  }
    //</style>
	
	//värvi saad siit f statemendiga kaudu paika sättida. ja kui ei ss deafult?????
	$def_bg_color = "#AAA";
	$def_text_color = "#101010";
	
    $css_color .= "<style> \n";
    $css_color .= "body { \n";
	
	if(isset($_SESSION["user_id"])){
		$css_color .= "\t background-color: " .$_SESSION["bg_color"] ."; \n";
		$css_color .= "\t color: " .$_SESSION["text_color"] ."; \n";
    }else{	
		$css_color .= "\t background-color: " .$def_bg_color ."; \n";
		$css_color .= "\t color: " .$def_text_color ."; \n";
	}
	
	$css_color .= "\t max-width: 960px;";
	$css_color .= "\t margin: auto;";
    $css_color .= "} \n";
    $css_color .= "</style> \n";
	
	
	//näitan kas kasutaja nime või looja nime
	$author_name = "Siim";
	$user_status_header_head = null;
	$user_status_header_body = null;
	if(isset($_SESSION["user_id"])){
		$user_status_header_head = '<title>'. $_SESSION["first_name"] ." " .$_SESSION["last_name"]. ', veebiprogrammeerimine</title>';
        $user_status_header_body = '<img src="photos/vp_banner.png" alt="veebiprogrammeerimise lehe bänner">'. "\n". '<i><h1><b>'. $_SESSION["first_name"] ." " .$_SESSION["last_name"]. '</b>, veebiprogrammeerimine</h1></i><hr>';
    }else{
		$user_status_header_head = '<title>'. $author_name. ', veebiprogrammeerimine</title>';
		$user_status_header_body = '<i><h1>'. $author_name. ', Veebiprogrammeerimine</h1></i><hr>';
	}
	//kui on sisse logitud näita kasutaja nime ja kui ei siis looja nime.
	
	/* require_once('page_header.php'); */
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<?php echo $user_status_header_head; ?>
</head>
<body>
    <?php echo $user_status_header_body; echo $css_color ?>	