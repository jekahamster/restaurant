<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");	

	if ( $_POST['mode'] == 'all' )
		$search_request = mysqli_query($connection, "SELECT * FROM `Time_shift_request`;");

	elseif ( $_POST['mode'] == 'no-answer' )
		$search_request = mysqli_query($connection, "SELECT * FROM `Time_shift_request` WHERE `confirmation` = 'No answer';");

	elseif ( $_POST['mode'] == 'confirmed' )
		$search_request = mysqli_query($connection, "SELECT * FROM `Time_shift_request` WHERE `confirmation` = 'Confirmed';");
		
	elseif ( $_POST['mode'] == 'rejected' )
		$search_request = mysqli_query($connection, "SELECT * FROM `Time_shift_request` WHERE `confirmation` = 'Rejected';");


	for ($i = 0; $i < mysqli_num_rows($search_request); $i++) {
		$search_request_res = mysqli_fetch_assoc($search_request);
		echo "
			<div> 
				<span>".$search_request_res['id']."</span>
				<span>".$search_request_res['driver_id']."</span>
				<span>".$search_request_res['order_id']."</span>
				<span>".$search_request_res['updated_time']."</span>
				<span>".$search_request_res['cause']."</span>
				<span>".$search_request_res['confirmation']."</span>
			</div>
		";
	}

mysqli_close($connection);

?>