<?php
//alustame sessiooni
require_once('page_session.php');
require_once("../../config.php");
require_once("fnc_photo_upload.php");
    $photo_error = null;
    $photo_upload_notice = null;
    $photo_orig_upload_dir = "./photos_2/upload_photos_orig/";
	$photo_upload_normal_dir = "./photos_2/upload_photos_normal/";
	$photo_upload_thumbnail_dir = "./photos_2/upload_photos_thumbnails/";
	$normal_photo_max_width = 600;
	$normal_photo_max_height = 400;
	$watermark_file = "./photos/vp_banner.png";
	
   /*  $file_name_and_path = null; */
    $file_type = null;
    $file_name = null;
    $alt_text = null;
    $privacy = 1;
    $photo_filename_prefix = "vp_";
    $photo_upload_size_limit = 1024 * 1024;
    
	$photo_size_ratio = 1;
/* 	$new_width = null;
	$new_height = null;
	$my_new_temp_image = null; */
	
    if(isset($_POST["photo_submit"])){
        if(isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])){
            //kas on pilt ja mis tüüpi?
            $image_check = getimagesize($_FILES["photo_input"]["tmp_name"]);
            if($image_check !== false){
                if($image_check["mime"] == "image/jpeg"){
                    $file_type = "jpg";
                }
                if($image_check["mime"] == "image/png"){
                    $file_type = "png";
                }
                if($image_check["mime"] == "image/gif"){
                    $file_type = "gif";
                }
            } else {
                $photo_error = "Valitud fail ei ole pilt!";
            }
            
            //Kas on lubatud suurusega?
            if(empty($photo_error) and $_FILES["photo_input"]["size"] > $photo_upload_size_limit){
                $photo_error .= "Valitud fail on liiga suur!";
            }
            
            //kas alt tekst on
            if(isset($_POST["alt_input"]) and !empty($_POST["alt_input"])){
                $alt_text = filter_var($_POST["alt_input"], FILTER_SANITIZE_STRING);
                if(empty($alt_text)){
                    $photo_error .= "Alternatiivtekst on lisamata!";
                }
            }
            
            if(empty($photo_error)){
                //teen ajatempli
                $time_stamp = microtime(1) * 10000;
                
                //moodustan failinime, kasutame eesliidet
                $file_name .= $photo_filename_prefix .$time_stamp ."." .$file_type;
				$file_name_and_path = $photo_orig_upload_dir .$file_name;
				
				//teen graafika objekti, image objekt ehk siis teen selle faili lahti.
				if($file_type == "jpg"){
					$my_temp_image = imagecreatefromjpeg($_FILES["photo_input"]["tmp_name"]);
				}
				if($file_type == "png"){
					$my_temp_image = imagecreatefrompng($_FILES["photo_input"]["tmp_name"]);
				}
				if($file_type == "gif"){
					$my_temp_image = imagecreatefromgif($_FILES["photo_input"]["tmp_name"]);
				}
				
				////Otsustame, kas tuleb laiuse või pikkuse järgi suhe
				//kõigpealt pildi mõõdud
				$image_width = imagesx();
				$image_height = imagesy();
				if($image_width / $normal_photo_max_width > $image_height / $normal_photo_max_height){
					$photo_size_ratio = $image_width / $normal_photo_max_width;
				}else{
					$photo_size_ratio = $image_height / $normal_photo_max_height;
				}
				
				//arvutame uue laiuse ja kõrguse pildile
				$new_width = round($image_width / $photo_size_ratio);
				$new_height = round($image_height / $photo_size_ratio);
				
				//loome uue piksli kogumi
				$my_new_temp_image = imagecreatetruecolor($new_width, $new_height);
				//kopeerime uued vajalikud pikslid uude objekti
				imagecopyresampled($my_new_temp_image, $my_temp_image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
				
				//lisame vesimärgi
				$watermark = imagecreatefrompng($watermark_file);
				$watermark_width = imagesx($watermark);
				$watermark_height = imagesy($watermark);
				$watermark_x = $new_width - $watermark_width - 10;
				$watermark_y = $new_height - $watermark_height - 10;
				
				imagecopy($my_new_temp_image, $watermark, $watermark_x, $watermark_y, 0, 0, $watermark_width, $watermakr_height);
				imagedestroy($watermark);
				$photo_upload_notice = save_image($my_new_temp_image, $file_type, $photo_upload_normal_dir. $file_name);
				imagedestroy($my_new_temp_image);
				
				imagedestroy($my_temp_image);
                //kopeerime pildi originaalkujul, originaalnimega vajalikku kataloogi
                if(move_uploaded_file($_FILES["photo_input"]["tmp_name"], $file_name_and_path)){
                    $photo_upload_notice = "Originaalfoto laeti üles!";
                    //$photo_upload_notice = store_person_photo($file_name, $_POST["person_for_photo_input"]);
                } else {
                    $photo_upload_notice = "Foto üleslaadimine ei õnnestunud!";
                }
            }
        } else {
            $photo_error = "Pildifaili pole valitud!";
        }
        
        $photo_upload_notice = $photo_error;
    }
    
    require("page_header.php");
?>
    <h2>Foto üleslaadimine</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label for="photo_input"> Vali pildifail! </label>
        <input type="file" name="photo_input" id="photo_input">
        <br>
        <label for="alt_input">Alternatiivtekst (alt): </label>
        <input type="text" name="alt_input" id="alt_input" placeholder="alternatiivtekst" value="<?php echo $alt_text; ?>">
        <br>
        <input type="radio" name="privacy_input" id="privacy_input_1" value="1" <?php if($privacy == 1){echo " checked";} ?>>
        <label for="privacy_input_1">Privaatne (ainult mina näen)</label>
        <br>
        <input type="radio" name="privacy_input" id="privacy_input_2" value="2" <?php if($privacy == 2){echo " checked";} ?>>
        <label for="privacy_input_2">Sisseloginud kasutajatele</label>
        <br>
        <input type="radio" name="privacy_input" id="privacy_input_3" value="3" <?php if($privacy == 3){echo " checked";} ?>>
        <label for="privacy_input_3">Avalik (kõik näevad)</label>
        <br>
        <input type="submit" name="photo_submit" value="Lae pilt üles">
    </form>
    <span><?php echo $photo_upload_notice; ?></span>
<?php require_once('page_footer.php'); ?>