<?php
    //alustame sessiooni
    session_start();
    //kas on sisselogitud
    if(!isset($_SESSION["user_id"])){
        header("Location: page.php");
    }
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    }
	
    require_once("../../config.php");
	require_once("fnc_movie.php");
    
    $notice = null;
    $role = null;
	$selected_person = null;
	$selected_movie = null;
	$selected_position = null;
	$selected_person_error = null;
	$selected_movie_error = null;
	$selected_position_error = null;
	
	$photo_upload_notice = null;
	$selected_person_for_photo = null;
	$photo_dir = "movie_photos/";
	
	if(isset($_POST['person_in_movie_submit'])){
		if(isset($_POST['person_input']) and !empty($_POST['person_input'])){
			$selected_person = filter_var($_POST['person_input'], FILTER_SANITIZE_STRING);
		}else{
			$selected_person_error = 'Inimene on valimatta!';
		}
		if(isset($_POST['movie_input']) and !empty($_POST['movie_input'])){
			$selected_movie = filter_var($_POST['movie_input'], FILTER_SANITIZE_STRING);
		}else{
			$selected_movie_error = 'Film on valimatta!';
		}
		if(isset($_POST['position_input']) and !empty($_POST['position_input'])){
			$selected_position = filter_var($_POST['position_input'], FILTER_SANITIZE_STRING);
		}else{
			$selected_position_error = 'Amet on valimatta!';
		}
	}
	
	if(isset($_POST['person_photo_submit'])){
		//var_dump($_FILES);
		$image_check = getimagesize($_FILES['photo_input']['tmp_name']);
		if($image_check !== false){
			if($image_check['mime'] == 'image/jpeg'){
				$file_type = 'jpg';
			}
			if($image_check['mime'] == 'image/png'){
				$file_type = 'png';
			}
			if($image_check['mime'] == 'image/gif'){
				$file_type = 'gif';
			}
			//teen aja templi
			$time_samp = microtime(1) * 10000;
			
			//moodustan file name (kasutaksin ees ja perekonna nime aga präegu on meil kasutada anult inimese id)
			$file_name = $_POST['person_for_photo'] .'_' .$time_samp .'.' .$file_type;
		}
		//kopeerime pildi org kujul, org nim vajalikku kataloogi.
		move_uploaded_file($_FILES['photo_input']['tmp_name'], $photo_dir .$file_name);
	}
	
    require("page_header.php");
?>
    <h2>Filmi info seostamine</h2>
	<h3>Film, inimene ja tema roll</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="person_input">Isik: </label>
			<select name="person_input">
				<option value="" selected disabled>vali isik</option>
				<?php echo read_all_person($selected_person); ?>
			</select>
		<br />
		<label for="movie_input">Film: </label>
			<select name="movie_input" id="movie_input">  <!-- paranda inputid ära -->
				<option value="" selected disabled>vali film</option>
				<?php echo read_all_movie($selected_movie); ?>
			</select>
		<br />
		<label for="position_input">Amet: </label>
			<select name="position_input">
				<option value="" selected disabled>vali amet</option>
				<?php echo read_all_position($selected_position); ?>
			</select>
		<br />
		<label for="role_input">Roll: </label>
			<input type="text" name="role_input" id="role_input" placeholder="Tegelase nimi" value="<?php echo $role; ?>">
			<br />
        <input type="submit" name="person_in_movie_submit" value="Salvesta">
    </form>
    <span><?php echo $notice; ?></span> <!-- paranda error siin ära -->
	<hr><br />
	
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<label for="person_for_photo">Isik: </label>
			<select name="person_for_photo" id="person_for_photo">
				<option value="" selected disabled>vali isik</option>
				<?php echo read_all_person($selected_person_for_photo); ?>
				<label for="photo_input">Vali pildi fail: </label>
				<br>
				<input type="file" name="photo_input" id="photo_input">
			</select>
			<br />
		<input type="submit" name="person_photo_submit" value="Lae pilt üles">
    </form>
	 <span><?php echo $photo_upload_notice; ?></span>
</body>
<?php require_once('page_footer.php'); ?>