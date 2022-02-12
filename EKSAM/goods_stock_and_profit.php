<?php 
	require_once('./page_fnc/fnc_goods.php'); 

	if(isset($_POST["stock_submit"]) and !empty($_POST["stock_submit"])){
       if(isset($_POST["stock_input"]) and !empty($_POST["stock_input"])){
       	current_goods_stock_update($_POST["id_input"], $_POST["stock_input"]);
       }
	}

	require_once('./page_stuff/page_header.php'); 
?>
<h2>Lao seis ja hetke kasum:</h2>

<?php 
	echo read_all_goods_sold();
	require_once('./page_stuff/page_footer.php'); 
?>