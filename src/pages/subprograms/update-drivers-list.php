<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ($_POST['mode'] == 'free') {
		$get_drivers = mysqli_query($connection, "SELECT * FROM `Drivers` WHERE `order_id` is NULL;");
		for ($i = 0; $i < mysqli_num_rows($get_drivers); $i++) {
			$get_drivers_res = mysqli_fetch_assoc($get_drivers);
			echo "
				<div> 
					<span>".$get_drivers_res['driver_id']."</span>
					<span>".$get_drivers_res['driver_name']."</span>
					<span>".$get_drivers_res['location']."</span>
					<span>".$get_drivers_res['order_id']."</span>
				</div>
				";
		} 
	}
	elseif ($_POST['mode'] == 'on-order') {
		$get_drivers = mysqli_query($connection, "SELECT * FROM `Drivers` WHERE `order_id` is not NULL;");
		for ($i = 0; $i < mysqli_num_rows($get_drivers); $i++) {
			$get_drivers_res = mysqli_fetch_assoc($get_drivers);
			echo "
				<div> 
					<span>".$get_drivers_res['driver_id']."</span>
					<span>".$get_drivers_res['driver_name']."</span>
					<span>".$get_drivers_res['location']."</span>
					<span>".$get_drivers_res['order_id']."</span>
				</div>
				";
		}
	}
	elseif ($_POST['mode'] == 'on-rest') {
		$at_work = [];
		$all = [];
		$on_rest = [];
		$get_drivers = mysqli_query($connection, "SELECT * FROM `Drivers`;");
		for ($i = 0; $i < mysqli_num_rows($get_drivers); $i++) {
			$get_drivers_res = mysqli_fetch_assoc($get_drivers);
			array_push($at_work, $get_drivers_res['driver_id']);
		}

		$get_drivers = mysqli_query($connection, "SELECT * FROM `Users` WHERE `Position` = 'Driver';");
		for ($i = 0; $i < mysqli_num_rows($get_drivers); $i++) {
			$get_drivers_res = mysqli_fetch_assoc($get_drivers);
			array_push($all, $get_drivers_res['id']);
		}

		for ($i = 0; $i < count($all); $i++) {
			if (!in_array($all[$i], $at_work))
				array_push($on_rest, $all[$i]);
		}
		for ($i = 0; $i < count($on_rest); $i++) {
			$get_drivers = mysqli_query($connection, "SELECT * FROM `Users` WHERE `id` = '".$on_rest[$i]."';");
			$get_drivers_res = mysqli_fetch_assoc($get_drivers);
			echo "
				<div> 
					<span>".$get_drivers_res['id']."</span>
					<span>".$get_drivers_res['Username']."</span>
					<span></span>
					<span></span>
				</div>
				";
		}

	}
	elseif ($_POST['mode'] == 'in-restaurant') {
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
	}
	
mysqli_close($connection);

?>