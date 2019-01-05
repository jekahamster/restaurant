<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	$search_products_id = mysqli_query($connection, "SELECT `id` FROM `Storage`;");
	for ( $i = 0; $i < mysqli_num_rows($search_products_id); $i++ ) {
		$search_products_id_res = mysqli_fetch_assoc($search_products_id);
		echo "<option>".$search_products_id_res['id']."</option>";
	}
	
mysqli_close($connection);

?>