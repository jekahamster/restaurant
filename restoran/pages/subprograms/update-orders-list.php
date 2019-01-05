<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ($_POST['mode'] == 'unfulfilled') {
		$get_orders = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `finished` = 'False' ORDER BY `Orders`.`id` DESC;");
		for ($i = 0; $i < mysqli_num_rows($get_orders); $i++) {
			$get_orders_res = mysqli_fetch_assoc($get_orders);
			echo "
				<div>
					<span>".$get_orders_res['id']."</span>
					<span>".$get_orders_res['ordered_dishes']."</span>
					<span>".$get_orders_res['address']."</span>
					<span>".$get_orders_res['summary_time']."</span>
					<span>".$get_orders_res['delivery_time']."</span>
					<span>".$get_orders_res['date']."</span>
					<span>".$get_orders_res['finish_time']."</span>
					<span>".$get_orders_res['summary_price']."</span>
					<span>".$get_orders_res['driver_id']."</span>
					<span>".$get_orders_res['finished']."</span>
				</div>
			";
		}
	}
	elseif ($_POST['mode'] == 'executed') {
		$get_orders = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `finished` = 'True' ORDER BY `Orders`.`id` DESC;");
		for ($i = 0; $i < mysqli_num_rows($get_orders); $i++) {
			$get_orders_res = mysqli_fetch_assoc($get_orders);
			echo "
				<div>
					<span>".$get_orders_res['id']."</span>
					<span>".$get_orders_res['ordered_dishes']."</span>
					<span>".$get_orders_res['address']."</span>
					<span>".$get_orders_res['summary_time']."</span>
					<span>".$get_orders_res['delivery_time']."</span>
					<span>".$get_orders_res['date']."</span>
					<span>".$get_orders_res['finish_time']."</span>
					<span>".$get_orders_res['summary_price']."</span>
					<span>".$get_orders_res['driver_id']."</span>
					<span>".$get_orders_res['finished']."</span>
				</div>
			";
		}
	}
	elseif ($_POST['mode'] == 'all-orders') {
		$get_orders = mysqli_query($connection, "SELECT * FROM `Orders` ORDER BY `Orders`.`id` DESC;");
		for ($i = 0; $i < mysqli_num_rows($get_orders); $i++) {
			$get_orders_res = mysqli_fetch_assoc($get_orders);
			echo "
				<div>
					<span>".$get_orders_res['id']."</span>
					<span>".$get_orders_res['ordered_dishes']."</span>
					<span>".$get_orders_res['address']."</span>
					<span>".$get_orders_res['summary_time']."</span>
					<span>".$get_orders_res['delivery_time']."</span>
					<span>".$get_orders_res['date']."</span>
					<span>".$get_orders_res['finish_time']."</span>
					<span>".$get_orders_res['summary_price']."</span>
					<span>".$get_orders_res['driver_id']."</span>
					<span>".$get_orders_res['finished']."</span>
				</div>
			";
		}
	}
	
mysqli_close($connection);

?>