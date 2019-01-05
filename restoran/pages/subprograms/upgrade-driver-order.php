<?php
require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");	

	if ($_POST['order-id'] == '') {
		$search_driver = mysqli_query($connection, "UPDATE `Drivers` SET `order_id` = NULL WHERE `driver_id` = '".$_POST['driver-id']."';");
		$search_driver = mysqli_query($connection, "UPDATE `Orders` SET `driver_id` = NULL WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
	} 
	else {

		$search_order = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `id` = '".$_POST['order-id']."'");
		if (mysqli_num_rows($search_order) == 0) 
			echo "Замовлення не існує!";
		else {

			$check_driver = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `id` = ".$_POST['order-id']." AND (`driver_id` = ".$_POST['driver-id']." OR `driver_id` is NULL);");
			if ( mysqli_num_rows($check_driver) == 0)
			{
				echo "Над цим замовленням вже працює інший водій!\n";
			}
			else 
			{

				$search_driver = mysqli_query($connection, "UPDATE `Drivers` SET `order_id` = NULL WHERE `driver_id` = '".$_POST['driver-id']."';");
				$search_driver = mysqli_query($connection, "UPDATE `Orders` SET `driver_id` = NULL WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");

				$delivery_time = $_POST['delivery-time'];
				$time_h = $delivery_time[0] . $delivery_time[1];
				$time_m = $delivery_time[3] . $delivery_time[4];
				$time_s = $delivery_time[6] . $delivery_time[7];
				$time = $time_h . ':' . $time_m . ':' . $time_s;

				$upg_driver = mysqli_query($connection, "UPDATE `Drivers` SET `order_id` = ".$_POST['order-id']." WHERE `driver_id` = '".$_POST['driver-id']."';");
				$upg_driver = mysqli_query($connection, "UPDATE `Orders` SET `driver_id` = ".$_POST['driver-id'].", `delivery_time` = '".$time."' WHERE `id` = '".$_POST['order-id']."';");
			

			}
		}
	}

mysqli_close($connection);
?>
