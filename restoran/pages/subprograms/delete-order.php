<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ( count($_POST['order-id-list']) != 0 )
		foreach ($_POST['order-id-list'] as $order_id)
			$delete_orders = mysqli_query($connection, "DELETE FROM `Orders` WHERE `Orders`.`id` = '".$order_id."';");

mysqli_close($connection);

?>