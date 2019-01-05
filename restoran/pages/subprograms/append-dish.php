<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");	

	$dish_name 			=	trim( $_POST['dish-name'] );
	$dish_class 		=	trim( $_POST['dish-class'] );
	$dish_time 			=	trim( $_POST['dish-time'] );
	$dish_price 		=	trim( $_POST['dish-price'] );
	$dish_ingredients 	= 	trim( $_POST['dish-ingredients'] );
	$dish_quantity 		=	trim( $_POST['dish-quantity'] );

	$time_hh = $dish_time[0] . $dish_time[1];
	$time_mm = $dish_time[3] . $dish_time[4];
	$time_ss = $dish_time[6] . $dish_time[7];
	
	// Check time
	if ($time_ss == '')
		$time_ss ='00';

	$dish_time = $time_hh . ":" . $time_mm . ":" . $time_ss;

	// Check ingredients
	foreach ( explode(", ", $_POST['dish-ingredients']) as $product ) {
		$search_product = mysqli_query($connection, "SELECT * FROM `Storage` WHERE `product` LIKE '".$product."';");
		if ( mysqli_num_rows($search_product) == 0 ) {
			echo "Продукт не знайдено";
			exit();
		}
	}

	// Check name
	$search_name = mysqli_query($connection, "SELECT * FROM `Dishes` WHERE `dish` = '".$dish_name."';");
	if ( mysqli_num_rows($search_name) != 0 ) {
		echo 'Така страва вже існує';
		exit();
	}

	$append_dish = mysqli_query($connection, "INSERT INTO `Dishes` (`id`, `dish`, `class`, `time`, `price`, `products`, `quantity`) VALUES (NULL, '".$dish_name."', '".$dish_class."', '".$dish_time."', '".$dish_price."', '".$dish_ingredients."', '".$dish_quantity."');");


mysqli_close($connection);

?>