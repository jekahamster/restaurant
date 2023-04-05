<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ( $_POST['mode'] == 'sort-by-unfulfilled' )
		$get_orders = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `finished` = 'False' ORDER BY `Orders`.`id` DESC;");
	elseif ( $_POST['mode'] == 'sort-by-executed' )
		$get_orders = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `finished` = 'True' ORDER BY `Orders`.`id` DESC;");
	elseif ( $_POST['mode'] == 'sort-by-all' )
		$get_orders = mysqli_query($connection, "SELECT * FROM `Orders` ORDER BY `Orders`.`id` DESC;");


	for ($i = 0; $i < mysqli_num_rows($get_orders); $i++) {
		$get_orders_res = mysqli_fetch_assoc($get_orders);
		
		echo "
			<tr>
				<td>
					<label class='material-checkbox'>
						<input class='order-checkbox' data-order-id=".$get_orders_res['id']." id='order-".$get_orders_res['id']."' type='checkbox'>
						<span></span>
					</label>
				</td>
				<td>".$get_orders_res['id']."</td>
				<td>".$get_orders_res['ordered_dishes']."</td>
				<td>".$get_orders_res['address']."</td>
				<td>".$get_orders_res['phone']."</td>
			</tr>
		";
	}
	
mysqli_close($connection);

?>