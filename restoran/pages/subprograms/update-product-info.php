<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	$search_product = mysqli_query($connection, "SELECT * FROM `Storage` WHERE `Storage`.`id` = '".$_POST['id']."';");
	$search_product_res = mysqli_fetch_assoc($search_product);
	echo $search_product_res['product'];
	echo "||";
	echo $search_product_res['quantity'];
	echo "||";
	echo $search_product_res['shelf_life'];
	
mysqli_close($connection);

?>