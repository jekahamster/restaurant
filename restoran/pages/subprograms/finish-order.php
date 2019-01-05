<?php 
	
require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	$finish_order = mysqli_query($connection, "UPDATE `Orders` SET `finished` = 'True' WHERE `Orders`.`driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
	$del_shift_time_request = mysqli_query($connection, "DELETE FROM `Time_shift_request` WHERE `Time_shift_request`.`driver_id` = '".$_POST['driver-id']."';");
	$upd_driver_order = mysqli_query($connection, "UPDATE `Drivers` SET `order_id` = NULL WHERE `Drivers`.`driver_id` = '".$_POST['driver-id']."'; ");
	// $upd_driver_order = mysqli_query($connection, "UPDATE `Drivers` SET `order_id` = NULL, `location` = '' WHERE `Drivers`.`driver_id` = '".$_POST['driver-id']."'; ");

mysqli_close($connection);
	
?>