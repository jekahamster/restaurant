<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	if ( count($_POST['product-id-list']) != 0 )
		foreach ($_POST['product-id-list'] as $product_id)
			mysqli_query($connection, "DELETE FROM `Storage` WHERE `Storage`.`id` = '".$product_id."';");

mysqli_close($connection);

?>