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
				<div>
					<span style='color: red;'><span style='color: red;'> ! </span>".$get_products_res['id']."</span>
					<span style='color: red;'><span style='color: red;'> ! </span>".$get_products_res['product']."</span>
					<span style='color: red;'><span style='color: red;'> ! </span>".$get_products_res['quantity']."</span>
					<span style='color: red;'><span style='color: red;'> ! </span>".$get_products_res['shelf_life']."</span>
				</div>
			";
		elseif ( ($get_products_res['quantity'] <= 20 and $get_products_res['quantity'] > 0) or ($d1 - $d2 < 86400*5 and $d1 - $d2 > 0) ) 
			echo "
				<div>
					<span style='color: #ffa100;'><span style='color: red;'> ! </span>".$get_products_res['id']."</span>
					<span style='color: #ffa100;'><span style='color: red;'> ! </span>".$get_products_res['product']."</span>
					<span style='color: #ffa100;'><span style='color: red;'> ! </span>".$get_products_res['quantity']."</span>
					<span style='color: #ffa100;'><span style='color: red;'> ! </span>".$get_products_res['shelf_life']."</span>
				</div>
			";
		else
			echo "
				<div>
					<span>".$get_products_res['id']."</span>
					<span>".$get_products_res['product']."</span>
					<span>".$get_products_res['quantity']."</span>
					<span>".$get_products_res['shelf_life']."</span>
				</div>
			";
	}

mysqli_close($connection);

?>