<?php 

require_once '../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

    
    $lloid2 = $connection -> real_escape_string($_POST['order-id']);
    $llopass2 = $connection -> real_escape_string($_POST['order-pass']);
	$search_order_info = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `id` = '".$lloid2."' AND `order_pass` = '".$llopass2."';");
	$search_order_info_res = mysqli_fetch_assoc($search_order_info);

	echo htmlspecialchars($search_order_info_res['ordered_dishes']);
	echo "||"; // Для split js
	echo htmlspecialchars($search_order_info_res['address']);
	echo "||"; // Для split js
	echo htmlspecialchars($search_order_info_res['location']);
	echo "||"; // Для split js
	echo htmlspecialchars($search_order_info_res['message']);
	echo "||"; // Для split js
	echo htmlspecialchars($search_order_info_res['date']);
	echo "||"; // Для split js
	echo htmlspecialchars($search_order_info_res['summary_time']);
	echo "||"; // Для split js
	echo htmlspecialchars($search_order_info_res['delivery_time']);
	echo "||"; // Для split js
	echo htmlspecialchars($search_order_info_res['finish_time']);
	echo "||"; // Для split js
	echo htmlspecialchars($search_order_info_res['summary_price']);


mysqli_close($connection);

?>