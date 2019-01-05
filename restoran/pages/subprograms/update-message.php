<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	if ( $_POST['mode'] == 'all-orders' )
		$search_message = mysqli_query($connection, "SELECT * FROM `Orders`;");
	elseif ( $_POST['mode'] == 'unfulfilled' )
		$search_message = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `finished` = 'False';");
	elseif ( $_POST['mode'] == 'executed' )
		$search_message = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `finished` = 'True';");

	for ($i = 0; $i < mysqli_num_rows($search_message); $i++) {
		$search_message_res = mysqli_fetch_assoc($search_message);
		echo "
			<div>
				<span>".$search_message_res['id']."</span>
				<span>".$search_message_res['message']."</span>
				<span>".$search_message_res['finished']."</span>
			</div>
		";
	}

mysqli_close($connection);

?>