<?php
	$database = "if21_siim_kr";
	require_once('fnc_general.php');
	require_once("../../config.php");

	function read_all_goods(){
		$list_html = null;
		$list_html .= "<table><thead><tr><th>toote nimi</th><th>hind</th><th>lao seis</th><th>osta</th></tr></thead><tbody>";

		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, name, price, stock FROM vp_goods WHERE disabled IS NULL");

		$stmt->bind_result($id_from_db, $name_from_db, $price_from_db, $stock_from_db);

		$stmt->execute();
		while($stmt->fetch()){
			$list_html .= "<tr> \n";
			$list_html .= "<td>" .$name_from_db ."</td> \n";
			$list_html .= "<td>" .$price_from_db ." €</td> \n";
			$list_html .= "<td>" .$stock_from_db ." tk</td> \n";

			$list_html .= '<td><form method="POST" action="' .htmlspecialchars($_SERVER["PHP_SELF"]) .'">' ."\n";
			$list_html .= '<input type="hidden" name="id_input" value="' .$id_from_db .'">' ."\n";
			$list_html .= '<input name="payment_submit" type="submit" value="Osta">' ."\n";
			$list_html .= "</form></td> \n";
			$list_html .= "</tr> \n";
		}

		$list_html .= "</tbody></table>";
		
		$stmt->close();
		$conn->close();
		return $list_html;
	}

	function buy_goods($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("UPDATE vp_goods SET stock = (stock - 1) WHERE id = ?");
		$stmt->bind_param("i", $id);
		echo $stmt->error;
		echo $conn->error;
		$stmt->execute();
		$stmt->close();
		$conn->close();
		return;
	}

	function current_goods_price($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT price FROM vp_goods WHERE id = ?");
		$stmt->bind_param("i", $id);
		echo $stmt->error;
		echo $conn->error;

		$stmt->bind_result($notice);
		$stmt->execute();
		$stmt->fetch();

		$stmt->close();
		$conn->close();
		return $notice;
	}

	function current_goods_price_sold($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT sold_stock_profit FROM vp_goods WHERE id = ?");
		$stmt->bind_param("i", $id);
	
		echo $stmt->error;
		echo $conn->error;

		$stmt->bind_result($notice);
		$stmt->execute();
		$stmt->fetch();

		$stmt->close();
		$conn->close();
		return $notice;
	}

	function current_goods_price_sold_update($id, $price){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("UPDATE vp_goods SET sold_stock_profit = ? WHERE id = ?");
		$stmt->bind_param("si", $price ,$id);
	
		echo $stmt->error;
		echo $conn->error;
		$stmt->execute();
		$stmt->close();
		$conn->close();
		return $notice;
	}

	function set_sold_stock($id){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("UPDATE vp_goods SET sold_stock = (sold_stock  + 1) WHERE id = ?");
		$stmt->bind_param("i", $id);
		echo $stmt->error;
		echo $conn->error;
		$stmt->execute();
		$stmt->close();
		$conn->close();
		return;
	}


	function read_all_goods_sold(){ 
		$list_html = null;
		$list_html .= "<table><thead><tr><th>toote nimi</th><th>lao Seis</th><th>Kasum</th><th>Lisa lattu juure</th></tr></thead><tbody>";

		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, name, stock, sold_stock_profit FROM vp_goods WHERE disabled IS NULL");

		$stmt->bind_result($id_from_db, $name_from_db, $stock_from_db, $profit_from_db);

		$stmt->execute();
		while($stmt->fetch()){
			$list_html .= "<tr> \n";
			$list_html .= "<td>" .$name_from_db ."</td> \n";
			$list_html .= "<td>" .$stock_from_db ." tk</td> \n";
			$list_html .= "<td>" .$profit_from_db ." €</td> \n";
			

			$list_html .= '<td><form method="POST" action="' .htmlspecialchars($_SERVER["PHP_SELF"]) .'">' ."\n";
			$list_html .= '<input type="hidden" name="id_input" value="' .$id_from_db .'">' ."\n";
			$list_html .= '<input type="text" name="stock_input" value="">' ."\n";
			$list_html .= '<input name="stock_submit" type="submit" value="Lisa">' ."\n";
			$list_html .= "</form></td> \n";
			$list_html .= "</tr> \n";
		}

		$list_html .= "</tbody></table>";
		
		$stmt->close();
		$conn->close();
		return $list_html;
	}


	function current_goods_stock_update($id, $stock){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("UPDATE vp_goods SET stock = (stock + ?) WHERE id = ?");
		$stmt->bind_param("ii", $stock ,$id);
	
		echo $stmt->error;
		echo $conn->error;
		$stmt->execute();
		$stmt->close();
		$conn->close();
		return $notice;
	}



	function read_all_goods_sold_corrently(){
		$list_html = null;
		$list_html .= "<table><thead><tr><th>toote nimi</th><th>hind</th><th>Lisa uus hind</th><th>lao seis</th><th>Kauba nähtavus</th></tr></thead><tbody>";

		$conn = new mysqli($GLOBALS['server_host'], $GLOBALS['server_user_name'], $GLOBALS['server_password'], $GLOBALS['database']);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, name, price, stock, disabled FROM vp_goods");

		$stmt->bind_result($id_from_db, $name_from_db, $price_from_db, $stock_from_db, $disbaled_from_db);

		$stmt->execute();
		while($stmt->fetch()){
			$list_html .= "<tr> \n";
			$list_html .= "<td>" .$name_from_db ."</td> \n";
			$list_html .= "<td>" .$price_from_db ." €</td> \n";

			//hinna muumise valik.
			$list_html .= '<td><form method="POST" action="' .htmlspecialchars($_SERVER["PHP_SELF"]) .'">' ."\n";
			$list_html .= '<input type="hidden" name="id_input" value="' .$id_from_db .'">' ."\n";
			$list_html .= '<input type="text" name="new_price_input" value="">' ."\n";
			$list_html .= '<input name="new_price_submit" type="submit" value="uuenda">' ."\n";
			$list_html .= "</form></td> \n";



			$list_html .= "<td>" .$stock_from_db ." tk</td> \n";

			$list_html .= '<td><form method="POST" action="' .htmlspecialchars($_SERVER["PHP_SELF"]) .'">' ."\n";
			$list_html .= '<label for="disabeld_goods_input">Kas toode on müügil?: </label>';
			$list_html .= '<select name="disabeld_goods_select" id="disabeld_goods_select">';

			if($disbaled_from_db == null){
				$list_html .= '<option value="0" selected>Jah</option>';
				$list_html .=  '<option value="1" >ei</option>';
				$list_html .= '</select>';
			}else{
				$list_html .= '<option value="0" >Jah</option>';
				$list_html .= '<option value="1" selected>ei</option>';
				$list_html .= '</select>';
			}
				
				$list_html .= '<input type="hidden" name="id_input" value="' .$id_from_db .'">' ."\n";
				$list_html .= '<input name="goods_submit" type="submit" value="Muuda">' ."\n";
				$list_html .= "</form></td> \n";
			$list_html .= "</tr> \n";
		}

		$list_html .= "</tbody></table>";
		
		$stmt->close();
		$conn->close();
		return $list_html;
	}

	function goods_disabeld_status_update($id, $disabled){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("UPDATE vp_goods SET disabled = ? WHERE id = ?");
		$stmt->bind_param("ii", $disabled ,$id);
	
		echo $stmt->error;
		echo $conn->error;
		$stmt->execute();
		$stmt->close();
		$conn->close();
		return $notice;
	}

	function goods_update_price($id, $price){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("UPDATE vp_goods SET price = ? WHERE id = ?");
		$stmt->bind_param("si", $price ,$id);
	
		echo $stmt->error;
		echo $conn->error;
		$stmt->execute();
		$stmt->close();
		$conn->close();
		return $notice;
	}


	function add_new_goods($name, $price, $stock){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");

		$stmt = $conn->prepare("INSERT INTO vp_goods (name, stock, price) VALUES (?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("sis", $name, $stock, $price);
		
		if($stmt->execute()){
			$notice = "Info lisati andmebaasi!\n";
		}else{
			$notice = "Info lisamisel andmebaasi tekkis tõrge: " .$stmt->error ."\n";
		}
	
		$stmt->close();
		$conn->close();
		return $notice;

	}