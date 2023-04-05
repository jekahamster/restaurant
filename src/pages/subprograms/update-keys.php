<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	$search_keys = mysqli_query($connection, "SELECT `registration_key` FROM `Registration_keys`;");
	$keys = [];

	for ($i = 0; $i < mysqli_num_rows($search_keys); $i++){
		$search_keys_res = mysqli_fetch_assoc($search_keys);
		array_push($keys, $search_keys_res['registration_key']);
	}

	echo implode(", ", $keys);

mysqli_close($connection);

?>