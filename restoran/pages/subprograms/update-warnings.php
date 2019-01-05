<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	$end_products_warning = '';
	$end_products_notification = '';
	$end_shelf_life_warning = '';
	$end_shelf_life_notification = '';

	$get_products = mysqli_query($connection, "SELECT * FROM `Storage` ORDER BY `Storage`.`id` ASC;");

	for ($i = 0; $i < mysqli_num_rows($get_products); $i++){
		$get_products_res = mysqli_fetch_assoc($get_products);

		$date = date('d.m.Y');
		$d1 = strtotime( $get_products_res['shelf_life'] );
		$d2 = strtotime( $date );

		if ( $get_products_res['quantity'] <= 0 )
			$end_products_warning .= $get_products_res['id'] . " - " . $get_products_res['product'] . "\n";
		elseif ( $get_products_res['quantity'] <= 20 && $get_products_res['quantity'] > 0 )
			$end_products_notification .= $get_products_res['id'] . " - " . $get_products_res['product'] . "\n";

		if ( $d1 - $d2 <= 0 )
			$end_shelf_life_warning .= $get_products_res['id'] . " - " . $get_products_res['product'] . "\n";
		elseif ( $d1 - $d2 < 86400*5 && $d1 - $d2 > 0 )
			$end_shelf_life_notification .= $get_products_res['id'] . " - " . $get_products_res['product'] . "\n";
	}

	echo $end_products_notification;
	echo "||";
	echo $end_products_warning;
	echo "||";
	echo $end_shelf_life_notification;
	echo "||";
	echo $end_shelf_life_warning;
	
mysqli_close($connection);

?>