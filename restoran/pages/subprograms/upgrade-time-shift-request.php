<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	if ( $_POST['answer'] == 'confirm' ) {
		$upgrade_request = mysqli_query($connection, "UPDATE `Time_shift_request` SET `confirmation` = 'Confirmed' WHERE `id` = '".$_POST['request-id']."';");
		$search_order_id = mysqli_query($connection, "SELECT * FROM `Time_shift_request` WHERE `id` = '".$_POST['request-id']."';");
		$search_order_id_res = mysqli_fetch_assoc($search_order_id);
		echo $search_order_id_res['updated_time'];
		$update_time = mysqli_query($connection, "UPDATE `Orders` SET `delivery_time` = '".$search_order_id_res['updated_time']."' WHERE `id` = '".$search_order_id_res['order_id']."';");

		function check_time($h, $m, $s) {
			if ($s > 59) {
				$m += floor($s / 60);
				$s -= floor($s / 60) * 60;
			}
			if ($m > 59) {
				$h += floor($m / 60);
				$m -= floor($m / 60) * 60;
			}
			if ($h > 23)
				$h -= floor($h / 24) * 24;
			
			if ($h < 10) $hh = '0'.$h; else $hh = $h;
			if ($m < 10) $mm = '0'.$m; else $mm = $m;
			if ($s < 10) $ss = '0'.$s; else $ss = $s;
			return "$hh:$mm:$ss";
		}
		
		$sum_time = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `id` = '".$search_order_id_res['order_id']."';");
		$sum_time_res = mysqli_fetch_assoc($sum_time);
		if (mysqli_num_rows($sum_time) == 0) 
			echo " ";
		else {
			$st = $sum_time_res['summary_time']; // summary time
			$dt = $sum_time_res['delivery_time']; // delivery time
			$d = substr($sum_time_res['date'], 11); // order date

			// time sum
			$s_h = (int) substr($st, 0, 2) + (int) substr($dt, 0, 2) + (int) substr($d, 0, 2);
			$s_m = (int) substr($st, 3, 2) + (int) substr($dt, 3, 2) + (int) substr($d, 3, 2);
			$s_s = (int) substr($st, 6, 2) + (int) substr($dt, 6, 2) + (int) substr($d, 6, 2);
			echo check_time($s_h, $s_m, $s_s);
			$set_finish_time = mysqli_query($connection, "UPDATE `Orders` SET `finish_time` = '".check_time($s_h, $s_m, $s_s)."' WHERE `id` = '".$search_order_id_res['order_id']."';");
		}
	}
	elseif ( $_POST['answer'] == 'reject' ) {
		$upgrade_request = mysqli_query($connection, "UPDATE `Time_shift_request` SET `confirmation` = 'Rejected' WHERE `id` = '".$_POST['request-id']."';");
	}

mysqli_close($connection);

?>