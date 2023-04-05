<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ( $_POST['sort-by'] == 'id' ) 
		$search_dishes = mysqli_query($connection, "SELECT * FROM `Dishes` ORDER BY `Dishes`.`id` ASC;");

	elseif ( $_POST['sort-by'] == 'name' ) 
		$search_dishes = mysqli_query($connection, "SELECT * FROM `Dishes` ORDER BY `Dishes`.`dish` ASC;");

	elseif ( $_POST['sort-by'] == 'class' ) 
		$search_dishes = mysqli_query($connection, "SELECT * FROM `Dishes` ORDER BY `Dishes`.`class` ASC;");

	elseif ( $_POST['sort-by'] == 'time' ) 
		$search_dishes = mysqli_query($connection, "SELECT * FROM `Dishes` ORDER BY `Dishes`.`time` ASC;");

	elseif ( $_POST['sort-by'] == 'price' ) 
		$search_dishes = mysqli_query($connection, "SELECT * FROM `Dishes` ORDER BY `Dishes`.`price` ASC;");


	for ( $i = 0; $i < mysqli_num_rows($search_dishes); $i++ ) {
		$search_dishes_res = mysqli_fetch_assoc($search_dishes);
		// echo "
		// 	<tr>
		// 		<td>
		// 			<label class='mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect' for='dish-".$search_dishes_res['id']."'>
		// 				<input type='checkbox' id='dish-".$search_dishes_res['id']."' class='mdl-checkbox__input'>
		// 			</label>
		// 		</td>
		// 		<td>".$search_dishes_res['id']."</td>
		// 		<td>".$search_dishes_res['dish']."</td>
		// 		<td>".$search_dishes_res['class']."</td>
		// 		<td>".$search_dishes_res['time']."</td>
		// 		<td>".$search_dishes_res['price']."</td>
		// 		<td>".$search_dishes_res['products'].$search_dishes_res['products']."</td>
		// 		<td>".$search_dishes_res['quantity']."</td>
		// 	</tr>
		// ";
		echo "
			<tr>
				<td>
					<label class='material-checkbox'>
						<input type='checkbox'>
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