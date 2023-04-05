<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	$update_order = mysqli_query($connection, "SELECT * FROM `Time_shift_request` WHERE `driver_id` = '".$_POST['driver_id']."' AND `confirmation` = 'No answer';");
	$update_res = mysqli_fetch_assoc($update_order);
	echo mysqli_num_rows($update_order);
	if (mysqli_num_rows($update_order) == 0)
		echo "||";
	else echo $update_res['updated_time'] + "||" + $update_res['cause'];
	
mysqli_close($connection);

?>