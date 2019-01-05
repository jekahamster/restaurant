<?php 

require_once '../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	$set_order_pass = mysqli_query($connection, "UPDATE `Orders` SET `order_pass` = '".$_POST['order-pass']."' WHERE `Orders`.`id` = ".$_POST['order-id'].";");
	
mysqli_close($connection);

?>