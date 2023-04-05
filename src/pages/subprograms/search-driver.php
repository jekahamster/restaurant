<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");	
	$search_driver = mysqli_query($connection, "SELECT * FROM `Drivers` WHERE `driver_id` = '".$_POST['driver-id']."';");
	$search_driver_res = mysqli_fetch_assoc($search_driver);
	echo $search_driver_res['driver_name'];
	echo "||";
	$search_time = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
	$search_time_res = mysqli_fetch_assoc($search_time);
	echo $search_time_res['delivery_time'];
	echo "||";
	echo $search_driver_res['order_id'];
	
mysqli_close($connection);

?>