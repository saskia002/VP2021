<?php
	require_once('./page_stuff/page_session.php');
	require_once("./page_fnc/fnc_gallery.php");
	require_once("../../config.php");
	require_once("./page_fnc/fnc_general.php");
	
	$update_photo_notice = null;
	
	//Pilid Näitamine.
	$show_picture = show_photo();


	if(isset($_GET["photo"]) and !empty($_GET["photo"])){
		//loeme pildi ja teeme vormi kuhu loeme pildi andmed
		$_SESSION["photo"] = $_GET["photo"];
		$validate_user = validate_user_photo($_SESSION["photo"]);
		//var_dump($validate_user);
		if(!empty($validate_user)){
			$alt_text = $validate_user[0];
			$privacy = $validate_user[1];
		} else {
			$update_photo_notice = "Valitud pildi andmeid ei saa muuta";
		}
	}
	
	if(isset($_POST["photo_submit"])){
		if(!empty($_POST["alt_input"]) and !empty($_POST["privacy_input"])){
			$alt_text = test_input(filter_var($_POST["alt_input"]), FILTER_SANITIZE_STRING);
			$update_photo_notice = update_photo_data($alt_text, $_POST["privacy_input"]);
			$privacy = $_POST["privacy_input"];
		} else {
			$update_photo_notice = "Pildiandmete uuendamine ebaõnnestus!";
		}
	}
	
	if(isset($_POST["photo_delete"])){
		$update_photo_notice = delete_photo($_SESSION["photo"]);
		$privacy = 1;
		$alt_text = null;
		$show_picture = '<p><b>*Pilt, mille sa just ära kustutasid*</b></p>';
	}
	
	require("./page_stuff/page_header.php");
?>
	<h2>Minu laetud foto andmete muutmine</h2>
	<?php echo $show_picture; ?>
	<form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

		<div style="padding-top:12px">
			<label for="alt_input">Alternatiivtekst (alt): </label>
			<input type="text" name="alt_input" id="alt_input" placeholder="Alternatiivtekst" value="<?php echo $alt_text; ?>">
		</div>

		<div style="padding-top:12px">
			<input type="radio" name="privacy_input" id="privacy_input_1" value="1" <?php if($privacy == 1){echo " checked"; }?>>
			<label for="privacy_input_1">Privaatne (ainult mina näen)</label>
		</div>

		<div style="padding-top:4px">
			<input type="radio" name="privacy_input" id="privacy_input_2" value="2" <?php if($privacy == 2){echo " checked"; }?>>
			<label for="privacy_input_2">Sisseloginud kasutajatele</label>
		</div>

		<div style="padding-top:4px">
			<input type="radio" name="privacy_input" id="privacy_input_3" value="3" <?php if($privacy == 3){echo " checked"; }?>>
			<label for="privacy_input_3">Avalik (kõik näevad)</label>
		</div>

		<div style="padding-top:14px">
			<input type="submit" name="photo_submit" value="Uuenda pildi andmeid">
		</div>
	</form>

	<div style="padding-top:6px">
	<form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="submit" name="photo_delete" value="Kustuta foto">
	</form>
	</div>

	<div style="padding-top:4px">
		<?php echo $update_photo_notice; ?>
	</div>
<?php require_once('./page_stuff/page_footer.php'); ?>