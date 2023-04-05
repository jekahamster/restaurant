<?php 
require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	$phone_number = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$_POST['userid']."' AND `finished` = 'False';");
	$phone_number_res = mysqli_fetch_assoc($phone_number);

	echo $phone_number_res['phone'];

mysqli_close($connection);
?>