<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	if ($_POST['mode'] == 'Відпочинок') {
		$add_drivers = mysqli_query($connection, "INSERT INTO `Drivers` (`id`, `driver_id`, `driver_name`, `order_id`) VALUES (NULL, '".$_POST['driver-id']."', '".$_POST['driver-name']."', NULL);");
		echo "work";
	} 
	elseif ($_POST['mode'] == 'Праця') {
		$remove_drivers = mysqli_query($connection, "DELETE FROM `Drivers` WHERE `Drivers`.`driver_id` = '".$_POST['driver-id']."';");
		$upd_order = mysqli_query($connection, "UPDATE `Orders` SET `driver_id` = NULL, `location` = NULL WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
		echo "relax";
	}


mysqli_close($connection);

?>