<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	$upd_check = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
	$upd_location = mysqli_query($connection, "UPDATE `Orders` SET `location` = '".$_POST['location']."' WHERE `Orders`.`driver_id` = ".$_POST['driver-id']." AND `finished` = 'False';");
	$upd_driver_location = mysqli_query($connection, "UPDATE `Drivers` SET `location` = '".$_POST['location']."' WHERE `driver_id` = '".$_POST['driver-id']."';");
	if( mysqli_num_rows($upd_check) == 0 )
		echo "Error";
	else 
		echo $_POST['location'];

mysqli_close($connection);

?>