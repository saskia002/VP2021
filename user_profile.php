<?php
    //alustame sessiooni
	require_once('page_session.php');
	
    require_once("../../config.php");
	require_once("fnc_user.php");
    require_once("fnc_general.php");
    
    $notice = null;
    $description = read_user_description();
	
	if(isset($_POST["profile_submit"])){
		$description = test_input($_POST["description_input"]);
		$notice = store_user_profile($description, $_POST["bg_color_input"],$_POST["text_color_input"]);
		$_SESSION["bg_color"] = $_POST["bg_color_input"];
		$_SESSION["text_color"] = $_POST["text_color_input"];
	}
	
    
    require("page_header.php");
?>
    <h2>Kasutajaprofiil</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="description_input">Minu lühikirjeldus</label>
        <br />
        <textarea name="description_input" id="description_input" rows="10" cols="80" placeholder="Minu lühikirjeldus ..."><?php echo $description; ?></textarea>
        <br />
        <label for="bg_color_input">taustavärv</label>
        <br />
        <input type="color" name="bg_color_input" id="bg_color_input" value="<?php echo $_SESSION["bg_color"]; ?>">
        <br />
        <label for="text_color_input">teksti värv</label>
        <br />
        <input type="color" name="text_color_input" id="text_color_input" value="<?php echo $_SESSION["text_color"]; ?>">
        <br />
        <input type="submit" name="profile_submit" value="Salvesta">
    </form>
    <span><?php echo $notice; ?></span>
</body>
<?php require_once('page_footer.php'); ?>