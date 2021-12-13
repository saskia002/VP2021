<?php 
require_once('./page_stuff/page_session.php');
require_once("./page_fnc/fnc_party_info_upload.php");
	//kontrollime sisestust
	if($_SERVER["REQUEST_METHOD"] === "POST"){
	    if(isset($_POST["payment_submit"])){
	        if(!empty($_POST["id_input"])){
				update_event_payment_status($_POST["id_input"], 1);
			}
		}
	}

require_once('./page_stuff/page_header.php');
?>
<h2>Kas on makstud?</h2>

	<?php echo forms_for_payment(); ?>	

<?php require_once('./page_stuff/page_footer.php'); ?>