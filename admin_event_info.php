<?php 
require_once('./page_stuff/page_session.php');
require_once("./page_fnc/fnc_party_info_upload.php");

	$payment_update_notice = $query_notice = $payment_choice_1 = $payment_choice_0 = $payment_update = $person_choice_error = null;

	//error fix.
	if(!isset($_POST["payment_info_query"])){
		$_POST["person_input"] = null;
	}
	
	if(isset($_POST["payment_info_query"])){
		if(isset($_POST["person_input"]) and $_POST["person_input"] >= 1){
			if(read_if_this_person_has_payed($_POST["person_input"]) == 1){
				$payment_choice_1 = "selected";
				$query_notice = "\nKlient on juba maksnud!";
				$payment_update = '<div style="padding-top:16px"><label for="payment_party_input">Muuda kas on makstud: </label><select name="studentcode_party_select" id="studentcode_party_select"><option value="0">Ei, maksis kohal</option><option value="1" selected>Jah, juba makstud</option></select></div><div style="padding-top:8px;padding-bottom:4px"><input type="submit" name="payment_info_submit" id="payment_info_submit" value="Muuda!"></div>';
			}else{
				$payment_choice_0 = "selected";
				$query_notice = "\nKlient pole veel maksnud!";
				$payment_update = '<div style="padding-top:16px"><label for="payment_party_input">Muuda kas on makstud: </label><select name="studentcode_party_select" id="studentcode_party_select"><option value="0" selected>Ei, pole veel makstud</option><option value="1">Jah, juba makstud</option></select></div><div style="padding-top:8px;padding-bottom:4px"><input type="submit" name="payment_info_submit" id="payment_info_submit" value="Muuda!"></div>';
			}
		}else{
			$person_choice_error = "Vali ikka isik!\n";
		}
	}

	if(isset($_POST["payment_info_submit"])){
		$payment_update_notice = update_event_payment_status($_POST["person_input"], $_POST["studentcode_party_select"]);
	}

	
require_once('./page_stuff/page_header.php');
?>
<h2>Kas on makstud?</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

	<div style="padding-top:6px">
		<label for="person_input">Isik: </label>
			<select name="person_input" id="person_input">
				<option value="" selected disabled>Vali isik</option>
				<?php 
					$person_id = $_POST["person_input"];
					echo read_all_party_people($person_id);
					echo $person_choice_error; 
					?>
			</select>
	</div>

	<div style="padding-top:8px;padding-bottom:4px">
		<p>Kontrolli kas isik on juba maksnud: <b><?php echo $query_notice; ?></b></p><br>
       		<input type="submit" name="payment_info_query" id="payment_info_query" value="Kontrolli">
	</div>
	
	</div><div style="width: 960px"><hr></div><div class="center body">
	<?php echo $payment_update; echo $payment_update_notice;?>
</form>
<?php require_once('./page_stuff/page_footer.php'); ?>