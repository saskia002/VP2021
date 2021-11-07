<?php
    //alustame sessiooni
    session_start();
    
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
	
	/* require_once('page_session.php'); */
?>
