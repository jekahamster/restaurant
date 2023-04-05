<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");	

	if (!trim($_POST['name']) || !trim($_POST['quantity']) || !trim($_POST['shelf-life'])) {
		echo "Всі поля повинні бути заповнені!";
		die();
	}

	$search_product = mysqli_query($connection, "SELECT * FROM `Storage` WHERE `product` = '".trim($_POST['name'])."';");
	if ( mysqli_num_rows($search_product) ) {
		echo "Такий продукт вже існує!";
		die();
	}

	mysqli_query($connection, "INSERT INTO `storage` (`id`, `product`, `quantity`, `shelf_life`) VALUES (NULL, '".trim($_POST['name'])."', '".$_POST['quantity']."', '".$_POST['shelf-life']."');");

mysqli_close($connection);

?>