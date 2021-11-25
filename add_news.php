<?php
//alustame...
require_once('./page_stuff/page_session.php');
require_once("../../config.php");
require_once("./page_fnc/fnc_photo_upload.php");
require_once("./page_fnc/fnc_general.php");
require_once("./classes/Photo_upload.class.php"); //photo üleslaadimise klass.

	$news_notice = null;

	//uudise aegumine.
	$expire = new DateTime("now");
	$expire->add(new DateInterval("P7D"));

	$expire_date = date_format($expire, "Y-m-d");
	
    $normal_photo_max_width = 600;
    $normal_photo_max_height = 400;
	$thumbnail_width = $thumbnail_height = 100;
    $photo_filename_prefix = "vp_news_";
    $photo_upload_size_limit = 1024 * 1024;
	$allowed_photo_types = ["image/jpeg", "image/png"];

    if(isset($_POST["news_submit"])){
		//uudise tekst sisaldab nüüd html märgendeid.
		//test_input... tehakse html märgendid ohtutuks. 
		//tagasi php to html siis htmlspecialchars_decode...
		//kui on ka foto vailtud, salvestage see esimesena AB siis kohe tema id saab kätte...
		//vaata gittist täpsemalt....... maui saa aru xdddd.
    }

    $to_head = '<script src="scripts/CheckFileSize.js" defer></script>' ."\n";
	$to_head .= '<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>' ."\n";
    require("./page_stuff/page_header.php");
?>
    <h2>Uuudise lisamine</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<label for="title_input">Uudise pealkiri.</label>
			<input type="text" id="title_input" name="title_input">
				<div style="padding-top:6px"></div>

		<label for="news_input" >Uudise tekst:</label>
			<div style="padding-top:6px"></div>
			<textarea id="news_input" name="news_input"></textarea>
			<script>CKEDITOR.replace('news_input');</script>
				<div style="padding-top:8px"></div>

        <label for="expire_input">Viimane kuvamise kuupäev.</label>
        	<input type="date" name="expire_input" id="expire_input" value="<?php echo $expire_date; ?>">
				<div style="padding-top:4px"></div>

		<label for="photo_input"> Vali pildifail! </label>
        	<input type="file" name="photo_input" id="photo_input">
				<div style="padding-top:4px"></div>
				
        <input type="submit" name="news_submit" id="news_submit" value="Salvesta uudis!"><span id="notice"></span>
    </form>
    <span><?php echo $news_notice; ?></span>
<?php require_once('./page_stuff/page_footer.php'); ?>