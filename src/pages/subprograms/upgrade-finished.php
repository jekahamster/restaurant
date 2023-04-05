<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ( $_POST['answer'] == 'cancel' )
		$update_finish = mysqli_query($connection, "UPDATE `Orders` SET `finished` = 'True' WHERE `id` = '".$_POST['order-id']."';");
	elseif ( $_POST['answer'] == 'сontinue' )
		$update_finish = mysqli_query($connection, "UPDATE `Orders` SET `finished` = 'False' WHERE `id` = '".$_POST['order-id']."';");

mysqli_close($connection);

?>