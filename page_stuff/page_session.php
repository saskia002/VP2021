<?php
    //alustame sessiooni
    //session_start();
    require_once("./classes/SessionManager.class.php");
	SessionManager::sessionStart("VP", 0, "~/siikri/public_html/", "greeny.cs.tlu.ee");

	//kas on page.php
	$page_path = basename($_SERVER["REQUEST_URI"], ".php");
	$page_file_name = 'page';
	if($page_path !== $page_file_name){
		//kas on sisselogitud
		if(!isset($_SESSION["user_id"])){
        header("Location: page.php");
		}
	}
	
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    }
?>
