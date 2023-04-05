<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	// $search_location = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
	$search_location = mysqli_query($connection, "SELECT * FROM `Drivers` WHERE `driver_id` = '".$_POST['driver-id']."';");
	$search_location_res = mysqli_fetch_assoc($search_location);
	if (mysqli_num_rows($search_location) == 0) 
		echo "";
	else
		echo $search_location_res['location'];

mysqli_close($connection);

?>