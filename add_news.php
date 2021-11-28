<?php
//alustame...
require_once('./page_stuff/page_session.php');
require_once("../../config.php");
require_once("./page_fnc/fnc_news_upload.php");
require_once("./page_fnc/fnc_general.php");
require_once("./classes/Photo_upload.class.php"); //photo üleslaadimise klass.

	$news_notice = $error_notice = $photo_upload_error = $upload_notice = $title_input_post = $news_input_post = $photo_file_name = null;
	
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

		//1. completion check.
		//2. peale if statment-e sanitize string ja yles laadimiseks valmis.
		//3. AB salvestamine.

		if(!empty($_POST["title_input"]) and isset($_POST["title_input"])){
			$title_input_post = $_POST["title_input"];
			$news_title = test_input(filter_var($_POST["title_input"], FILTER_SANITIZE_STRING));
		}else{
			$error_notice = "Kõik väljad pole täidetud!\n";
		}
		if(!empty($_POST["news_input"]) and isset($_POST["news_input"])){
			$news_input_post = $_POST["news_input"];
			$news_input_html = htmlspecialchars($_POST["news_input"]);
			$news_text = filter_var($news_input_html, FILTER_SANITIZE_STRING);
		}else{
			$error_notice = "Kõik väljad pole täidetud!\n";
		}

		

		if(!empty($_POST["expire_input"]) and isset($_POST["expire_input"])){
			$news_expire = filter_var($_POST["expire_input"], FILTER_SANITIZE_NUMBER_INT);
		}else{
			$error_notice = "Kõik väljad pole täidetud!\n";
		}

		//siin teeb yles laadimise siis...
		if(empty($error_notice)){
			//pilid salvestamine.
			if(!empty($_FILES["photo_input"]["tmp_name"]) and isset($_FILES["photo_input"]["tmp_name"])){
				
				//klassi aktiveerimine pilid kogumiga.
				if(true){
					$photo_upload_class = new Photoupload($_FILES["photo_input"]);
				}else{
					$photo_upload_error = "Pilid laadimisel tekkis viga!\n"; 
				}
				
				if(empty($photo_upload_class->error)){
					//kontrollin kas on sobiv faili tüüp.
					$photo_upload_error .= $photo_upload_class->check_size($photo_upload_size_limit);

					if(empty($photo_upload_class->error)){
						//faili nimi.
						$photo_upload_class->create_filename($photo_filename_prefix);

						//resized pilid loomine ja laadimine.
						$photo_upload_class->resize_photo($normal_photo_max_width, $normal_photo_max_height);
						$photo_upload_class->save_image($news_photo_normal_upload_dir .$photo_upload_class->file_name);

						//pisipildi loomine ja laadimine.
						$photo_upload_class->resize_photo($thumbnail_width, $thumbnail_height);
						$photo_upload_class->save_image($news_photo_thumbnail_upload_dir .$photo_upload_class->file_name);

						//originaal pildi laadimine.
						$photo_upload_class->move_original_photo($news_photo_orig_upload_dir .$photo_upload_class->file_name);

						//AB lisamine.
						$upload_notice .= store_news_photo_data($photo_upload_class->file_name);
						$photo_file_name = $photo_upload_class->file_name;

					}else{
						$photo_upload_error .= "Pilid laadimisel tekkis viga!\n";
					}
					
				}else{
					$photo_upload_error .= "Pilid laadimisel tekkis viga!\n";
				}
			}
			unset($photo_upload_class);

			//teksti salvestamine AB.
			if($upload_notice = store_news_data($news_text, $news_title, $news_expire)){
				$title_input_post = $news_input_post = $photo_file_name = null;
			}else{
				$error_notice = "Teksti laadimisel tekkis viga!\n";
			}
		}
    }

    $to_head = '<script src="scripts/CheckFileSize.js" defer></script>' ."\n";
	$to_head .= '<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>' ."\n";
    require("./page_stuff/page_header.php");
?>
    <h2>Uuudise lisamine</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<div style="padding-top:4px">
			<label for="title_input">Uudise pealkiri: </label>
				<input type="text" id="title_input" name="title_input" value="<?php echo $title_input_post; ?>">
		</div>

		<div style="padding-top:8px">
			<label for="news_input" >Uudise tekst: </label>
				<div style="padding-top:6px"></div>
				<textarea id="news_input" name="news_input"><?php echo $news_input_post; ?></textarea>
				<script>CKEDITOR.replace('news_input');</script>
		</div>

		<div style="padding-top:8px">
			<label for="expire_input">Viimane kuvamise kuupäev: </label>
				<input type="date" name="expire_input" id="expire_input" value="<?php echo $expire_date; ?>">
		</div>

		<div style="padding-top:6px">
			<label for="photo_input"> Vali pildifail: </label>
				<input type="file" name="photo_input" id="photo_input">
		</div>

		<div style="padding-top:6px">
       		<input type="submit" name="news_submit" id="news_submit" value="Salvesta uudis!"><span id="notice"></span>
		</div>
    </form>

	<div style="padding-top:4px">
    	<span><?php echo $news_notice; echo $error_notice; echo $photo_upload_error; echo $upload_notice; ?></span>
	</div>
<?php require_once('./page_stuff/page_footer.php'); ?>