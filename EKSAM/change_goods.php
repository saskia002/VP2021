<?php 
	require_once('./page_fnc/fnc_goods.php'); 

	$notice = null;

	//müügil oleku muutus.
	if(isset($_POST["goods_submit"]) and !empty($_POST["goods_submit"])){
		if(isset($_POST["disabeld_goods_select"])){
			if($_POST['disabeld_goods_select'] == 0){ //jah kui nähtav.

				goods_disabeld_status_update($_POST["id_input"], null);

			}else{ // ei kui pole nähtav.

				goods_disabeld_status_update($_POST["id_input"], 1);
			}

		}
	}

	//hinna muutus.
	if(isset($_POST["new_price_submit"]) and !empty($_POST["new_price_submit"])){
       if(isset($_POST["new_price_input"]) and !empty($_POST["new_price_input"])){
       	goods_update_price($_POST["id_input"], $_POST["new_price_input"]);
       }
	}
	
	//AB uue toote lisamine.
	if(isset($_POST["new_goods_submit"])){
		$notice = add_new_goods($_POST['name_new_input'], $_POST['price_new_input'], $_POST['stock_new_input']);
	}


	require_once('./page_stuff/page_header.php'); 
?>
<p>Palun pane hinna koma asemel punkt! Mudu visab SQL errori ette! 2,55 -> 2.55</p>
<h2>Ketkel poest müügil:</h2>

<?php echo read_all_goods_sold_corrently();?>

<br><br>
<hr>

<h2>Lisa uus toode müüki:</h2>
<p>Palun pane hinna koma asemel punkt! 2,55 -> 2.55</p>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div style="padding-top:6px">
		<label for="name_new_input">Nimi: </label>
			<input type="text" id="name_new_input" name="name_new_input" value="">
	</div>
	<div style="padding-top:6px">

		<label for="price_new_input">Hind: </label>

			<input type="text" id="price_new_input" name="price_new_input" value="">
	</div>
	<div style="padding-top:6px">
		<label for="stock_new_input">Lao seis: </label>
			<input type="text" id="stock_new_input" name="stock_new_input" value="">
	</div>
 	 <input name="new_goods_submit" type="submit" value="Lisa">
</form>


<?php
	echo $notice;	
	require_once('./page_stuff/page_footer.php'); 
?>