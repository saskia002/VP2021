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
    $css_color .= "\t background-color: " .$def_bg_color /* $_SESSION["bg_color"] */ ."; \n";
    $css_color .= "\t color: " .$def_text_color /* $_SESSION["text_color"] */ ."; \n";
	$css_color .= "\t max-width: 960px;";
	$css_color .= "\t margin: auto;";
    $css_color .= "} \n";
    $css_color .= "</style> \n";
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</title>
    <?php echo $css_color; ?>
</head>
<body>
    <img src="photos/vp_banner.png" alt="veebiprogrammeerimise lehe bänner">