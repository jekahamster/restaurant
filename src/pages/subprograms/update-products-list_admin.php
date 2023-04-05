<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ($_POST['sort-by'] == 'id')
		$get_products = mysqli_query($connection, "SELECT * FROM `Storage` ORDER BY `Storage`.`id` ASC;");
	elseif ($_POST['sort-by'] == 'name')
		$get_products = mysqli_query($connection, "SELECT * FROM `Storage` ORDER BY `Storage`.`product` ASC;");
	elseif ($_POST['sort-by'] == 'quantity')
		$get_products = mysqli_query($connection, "SELECT * FROM `Storage` ORDER BY `Storage`.`quantity` ASC;");
	elseif ($_POST['sort-by'] == 'shelf-life')
		$get_products = mysqli_query($connection, "SELECT * FROM `Storage` ORDER BY `Storage`.`shelf_life` ASC;");


	for ($i = 0; $i < mysqli_num_rows($get_products); $i++) {
		$get_products_res = mysqli_fetch_assoc($get_products);
		
		$date = date('d.m.Y');
		$d1 = strtotime( $get_products_res['shelf_life'] );
		$d2 = strtotime( $date );

		if ( $get_products_res['quantity'] <= 0 or $d1 - $d2 <= 0 )
			echo "
				<tr style='background-color: rgba(255, 0, 0, 0.2);'>
					<td>
						<label class='material-checkbox'>
							<input class='storage-checkbox' data-product-id=".$get_products_res['id']." id='dish-".$get_products_res['id']."' type='checkbox'>
							<span></span>
						</label>
					</td>
					<td>".$get_products_res['id']."</td>
					<td>".$get_products_res['product']."</td>
					<td>".$get_products_res['quantity']."</td>
					<td>".$get_products_res['shelf_life']."</td>
				</tr>
			";
		elseif ( ($get_products_res['quantity'] <= 20 and $get_products_res['quantity'] > 0) or ($d1 - $d2 < 86400*5 and $d1 - $d2 > 0) ) 
			echo "
				<tr style='background-color: rgba(255, 232, 0, 0.3);'>
					<td>
						<label class='material-checkbox'>
							<input class='storage-checkbox' data-product-id=".$get_products_res['id']." id='dish-".$get_products_res['id']."' type='checkbox'>
							<span></span>
						</label>
					</td>
					<td>".$get_products_res['id']."</td>
					<td>".$get_products_res['product']."</td>
					<td>".$get_products_res['quantity']."</td>
					<td>".$get_products_res['shelf_life']."</td>
				</tr>
			";
		else
			echo "
				<tr>
					<td>
						<label class='material-checkbox'>
							<input class='storage-checkbox' data-product-id=".$get_products_res['id']." id='dish-".$get_products_res['id']."' type='checkbox'>
							<span></span>
						</label>
					</td>
					<td>".$get_products_res['id']."</td>
					<td>".$get_products_res['product']."</td>
					<td>".$get_products_res['quantity']."</td>
					<td>".$get_products_res['shelf_life']."</td>
				</tr>
			";
	}

mysqli_close($connection);

?>