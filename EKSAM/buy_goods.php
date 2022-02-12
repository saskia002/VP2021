<?php 
	require_once('./page_fnc/fnc_goods.php'); 

	if(isset($_POST["payment_submit"]) and !empty($_POST["payment_submit"])){
        if(buy_goods($_POST["id_input"])){	
        	//uuendan hinda.

			//hetke hind
			$curent_price = current_goods_price($_POST["id_input"]);

			//hind kokku.
			$current_sold_profit = current_goods_price_sold($_POST["id_input"]);

			//uus hind.
			$new_price = $curent_price + $current_sold_profit;
			$new_sold_profit = current_goods_price_sold_update($_POST["id_input"], $new_price);

			//sold stock.
			set_sold_stock($_POST["id_input"]);
		}
	}

	require_once('./page_stuff/page_header.php'); 
?>
<h2>Osta poest:</h2>
<?php 
	echo read_all_goods();
	require_once('./page_stuff/page_footer.php'); 
?>