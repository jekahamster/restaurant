<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);	
mysqli_query($connection, "set names 'utf8'");

	$search_info = mysqli_query($connection, "SELECT * FROM `order_statistics`;");

	for ($i = 0; $i < mysqli_num_rows($search_info); $i++) {
		$search_info_res = mysqli_fetch_assoc($search_info);
		echo $search_info_res['date'];
	}

mysqli_close($connection);

?>