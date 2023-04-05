<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	$search_dish_info = mysqli_query($connection, "SELECT * FROM `Dishes` WHERE `id` = '".$_POST['id']."';");
	
	if (mysqli_num_rows($search_dish_info) != 0) {
		$search_dish_info_res = mysqli_fetch_assoc($search_dish_info);
		echo $search_dish_info_res['dish'];
		echo "||";
		echo $search_dish_info_res['class'];
		echo "||";
		echo $search_dish_info_res['time'];
		echo "||";
		echo $search_dish_info_res['price'];
		echo "||";
		echo $search_dish_info_res['products'];
		echo "||";
		echo $search_dish_info_res['quantity'];

	}


mysqli_close($connection);

?>