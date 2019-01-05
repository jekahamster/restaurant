<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	$new_products = implode(", ", $_POST['new-products']);
	$new_quantity = implode(", ", $_POST['new-quantity']);

	$upgrade_dish = mysqli_query($connection, "UPDATE `dishes` SET `dish` = '".$_POST['new-name']."', `class` = '".$_POST['new-class']."', `time` = '".$_POST['new-time']."', `price` = '".$_POST['new-price']."', `products` = '".$new_products."', `quantity` = '".$new_quantity."' WHERE `dishes`.`id` = '".$_POST['id']."';");

mysqli_close($connection);

?>