<?php 
require_once('./page_stuff/page_session.php');
require_once("./page_fnc/fnc_party_info_upload.php");

	$firstname_party = $lastname_party = $studentcode_party = $party_info_save_error = $register_notice = $payment_party = $payment_selected_0 = $payment_selected_1 = null;

	
	if(isset($_POST["party_info_submit"])){

		if(!empty($_POST["firstname_party_input"]) and isset($_POST["firstname_party_input"])){
			if(strlen($_POST["firstname_party_input"]) < 2 or strlen($_POST["firstname_party_input"]) > 50){
				$party_info_save_error = "Eesnimi peab olema vahemikus 2-50 tähte!\n";
			}else{
				$firstname_party = $_POST["firstname_party_input"];
			}
		}else{
			$party_info_save_error = "Osad väljad on täitmata!\n";
		}

		if(!empty($_POST["lastname_party_input"]) and isset($_POST["lastname_party_input"])){
			
			if(strlen($_POST["lastname_party_input"]) < 2 or strlen($_POST["lastname_party_input"]) > 50){
				$party_info_save_error = "Perekonna nimi peab olema vahemikus 2-50 tähte!\n";
			}else{
				$lastname_party = $_POST["lastname_party_input"];
			}
		}else{
			$party_info_save_error = "Osad väljad on täitmata!\n";
		}

		if(!empty($_POST["studentcode_party_input"]) and isset($_POST["studentcode_party_input"])){
			
			if(strlen($_POST["studentcode_party_input"]) < 6 or strlen($_POST["studentcode_party_input"]) > 6){
				$party_info_save_error = "Kood peab 6 numbrit pikk olema!\n";
			}else{
				$studentcode_party = $_POST["studentcode_party_input"];
			}
		}else{
			$party_info_save_error = "Osad väljad on täitmata!\n";
		}

		//payment.
		if(isset($_POST["studentcode_party_select"])){
			$payment_party = $_POST["studentcode_party_select"];
			if($payment_party == 1){
				//makstud
				$payment_selected_1 = "selected";
			}else{
				//pole makstud
				$payment_selected_0 = "selected";
			}
		}

		//AB salvestamine.
		if($party_info_save_error == null){
			//eesnimi.
			$firstname_party_new = test_input(filter_var($firstname_party, FILTER_SANITIZE_STRING));
	
			//perenimi.
			$lastname_party_new = test_input(filter_var($lastname_party, FILTER_SANITIZE_STRING));
	
			//õpilaskood.
			$studentcode_party_new = test_input(filter_var($studentcode_party, FILTER_VALIDATE_INT));
	
			//fnc kaudu AB laadimine.
			$register_notice = register_to_event($firstname_party_new, $lastname_party_new, $studentcode_party_new, $payment_party);

			$firstname_party = $lastname_party = $studentcode_party = null;
		}
	}
require_once('./page_stuff/page_header.php');
?>
<p>Peost võtab osa inimest: <?php echo read_all_party_people_reg(); ?></p> 
<p>Peo eest on juba maksnud inimest: <?php echo read_all_party_people_reg_and_payed(); ?></p>

<hr>
<h2>Rega peole</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

	<div style="padding-top:4px">
		<label for="firstname_party_input">Eesnimi: </label>
			<input type="text" id="firstname_party_input" name="firstname_party_input" value="<?php echo $firstname_party; ?>">
	</div>

	<div style="padding-top:6px">
		<label for="lastname_party_input">Perekonna nimi: </label>
			<input type="text" id="lastname_party_input" name="lastname_party_input" value="<?php echo $lastname_party; ?>">
	</div>

	<div style="padding-top:6px">
		<label for="studentcode_party_input">Tundengi kood: </label>
			<input type="text" id="studentcode_party_input" name="studentcode_party_input" value="<?php echo $studentcode_party; ?>">
	</div>

	<div style="padding-top:6px">
		<label for="payment_party_input">Kas oled maksnud: </label>
			<select name="studentcode_party_select" id="studentcode_party_select">
				<option value="0" <?php echo $payment_selected_0; ?>>Ei, maksan kohal</option>
				<option value="1" <?php echo $payment_selected_1; ?>>Jah, juba makstud</option>
			</select>
	</div>

	<div style="padding-top:8px;padding-bottom:4px">
       		<input type="submit" name="party_info_submit" id="party_info_submit" value="Salvesta!">
	</div>
</form>

<?php echo $party_info_save_error; echo $register_notice; require_once('./page_stuff/page_footer.php'); ?>