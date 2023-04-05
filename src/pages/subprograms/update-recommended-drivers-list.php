<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	$get_recommended_drivers = mysqli_query($connection, "SELECT * FROM `Drivers` WHERE `location` = '' AND `order_id` is NULL;");
	for ($i = 0; $i < mysqli_num_rows($get_recommended_drivers); $i++) {
		$get_recommended_drivers_res = mysqli_fetch_assoc($get_recommended_drivers);
		echo "
			<div> 
				<span>".$get_recommended_drivers_res['driver_id']."</span>
				<span>".$get_recommended_drivers_res['driver_name']."</span>
				<span>".$get_recommended_drivers_res['location']."</span>
				<span>".$get_recommended_drivers_res['order_id']."</span>
			</div>
		";
	}

mysqli_close($connection);

?>