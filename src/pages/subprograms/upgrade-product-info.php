<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	if (!trim($_POST['name']) || !$_POST['quantity'] || !$_POST['shelf-life']) {
		echo "Всі поля повинні бути заповнені!";
		die();
	}

	mysqli_query($connection, "UPDATE `Storage` SET `product` = '".$_POST['name']."', `quantity` = '".$_POST['quantity']."', `shelf_life` = '".$_POST['shelf-life']."' WHERE `Storage`.`id` = '".$_POST['id']."'; ");
	
mysqli_close($connection);

?>