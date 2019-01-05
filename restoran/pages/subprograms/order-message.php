<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ( $_POST['message-mode'] == 'search' ) {
		$search_order = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `id` = '".$_POST['order-id']."';"); 	
		$search_order_res = mysqli_fetch_assoc($search_order);
		echo $search_order_res['message'];
	}
	elseif ( $_POST['message-mode'] == 'send' ) {
		$send_message = mysqli_query($connection, "UPDATE `Orders` SET `message` = '".$_POST['message']."' WHERE `id` = '".$_POST['order-id']."';");
	}
	
mysqli_close($connection);

?>