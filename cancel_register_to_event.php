<?php 
require_once('./page_stuff/page_session.php');
require_once("./page_fnc/fnc_party_info_upload.php");

	$studentcode_party_cancel = $party_info_save_error = $party_cancel_notice = null;

	if(isset($_POST["party_cancel_submit"])){

		if(!empty($_POST["studentcode_party_cancel_input"]) and isset($_POST["studentcode_party_cancel_input"])){
			
			if(strlen($_POST["studentcode_party_cancel_input"]) < 6 or strlen($_POST["studentcode_party_cancel_input"]) > 6){
				$party_info_save_error = "Kood peab 6 numbrit pikk olema!\n";
				$studentcode_party_cancel = $_POST["studentcode_party_cancel_input"];
			}else{
				$studentcode_party_cancel_new = test_input(filter_var($_POST["studentcode_party_cancel_input"], FILTER_VALIDATE_INT));
				$party_cancel_notice = cancel_event_registration($studentcode_party_cancel_new);
			}
		}else{
			$party_info_save_error = "Osad väljad on täitmata!\n";
		}
	}
	
require_once('./page_stuff/page_header.php');
?>
<h2>Ütle peost ära:</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

	<div style="padding-top:4px">
		<label for="studentcode_party_cancel_input">Tundengi kood: </label>
			<input type="text" id="studentcode_party_cancel_input" name="studentcode_party_cancel_input" value="<?php echo $studentcode_party_cancel; ?>">
	</div>

	<div style="padding-top:8px;padding-bottom:4px">
       		<input type="submit" name="party_cancel_submit" id="party_cancel_submit" value="Salvesta!">
	</div>
</form>

<?php echo $party_info_save_error; echo $party_cancel_notice; require_once('./page_stuff/page_footer.php'); ?>