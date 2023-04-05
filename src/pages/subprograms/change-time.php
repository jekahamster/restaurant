<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	$search_change = mysqli_query($connection, "SELECT * FROM `Time_shift_request` WHERE `driver_id` = '".$_POST['driver-id']."' AND `confirmation` = 'No answer';");
	if (mysqli_num_rows($search_change) == 0)
	{
		$add_request = mysqli_query($connection, "INSERT INTO `Time_shift_request` (`id`, `driver_id`, `order_id`, `updated_time`, `cause`, `confirmation`) VALUES (NULL, '".$_POST['driver-id']."', '".$_POST['order-id']."', '".$_POST['changed-time']."', '".$_POST['change-cause']."', 'No answer');");
	}
	else {
		$upd_request = mysqli_query($connection, "UPDATE `Time_shift_request` SET `updated_time` = '".$_POST['changed-time']."', `cause` = '".$_POST['change-cause']."' WHERE `Time_shift_request`.`driver_id` = '".$_POST['driver-id']."' AND `confirmation` = 'No answer';");
	}
	
mysqli_close($connection);

?>