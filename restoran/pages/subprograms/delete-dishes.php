<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ( count($_POST['dishes-id-list']) != 0 )
		foreach ($_POST['dishes-id-list'] as $dishes_id)
			$delete_dishes = mysqli_query($connection, "DELETE FROM `Dishes` WHERE `Dishes`.`id` = '".$dishes_id."';");

	$update_dishes_list = mysqli_query($connection, "SELECT * FROM `Dishes` ORDER BY `Dishes`.`id` ASC;");

	for ( $i = 0; $i < mysqli_num_rows($update_dishes_list); $i++ ) {
		$search_dishes_res = mysqli_fetch_assoc($update_dishes_list);
		echo "
			<tr>
				<td>
					<label class='material-checkbox'>
						<input id='dish-".$search_dishes_res['id']."' type='checkbox'>
						<span></span>
					</label>
				</td>
				<td>".$search_dishes_res['id']."</td>
				<td>".$search_dishes_res['dish']."</td>
				<td>".$search_dishes_res['class']."</td>
				<td>".$search_dishes_res['time']."</td>
				<td>".$search_dishes_res['price']."</td>
				<td>".$search_dishes_res['products']."</td>
				<td>".$search_dishes_res['quantity']."</td>
			</tr>
		";
	}

mysqli_close($connection);

?>