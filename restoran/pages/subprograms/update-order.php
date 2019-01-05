<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	$order_for_driver = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
	$search_result = mysqli_fetch_assoc($order_for_driver);
	if (mysqli_num_rows($order_for_driver) == 0)
		echo "
			<span>Id</span>
			<span>Address</span>

			<input type=\"text\" value='' readonly>
			<textarea readonly></textarea>
		";
	else 
		echo "
			<span>Id</span>
			<span>Address</span>
			
			<input type=\"text\" value='".$search_result['id']."' readonly>
			<textarea readonly>".$search_result['address']."</textarea>
	";

mysqli_close($connection);

?>