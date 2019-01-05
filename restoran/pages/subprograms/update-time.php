<?php 
require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	$delivery_time = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
	$time_res = mysqli_fetch_assoc($delivery_time);
	if (mysqli_num_rows($delivery_time) == 0)
		echo " ";
	else echo $time_res['delivery_time'];

	echo '||'; // Для разделения переменной data в js

	$update_order = mysqli_query($connection, "SELECT * FROM `Time_shift_request` WHERE `driver_id` = '".$_POST['driver-id']."' AND `confirmation` = 'No answer';");
	$update_res = mysqli_fetch_assoc($update_order);
	if (mysqli_num_rows($update_order) == 0)
		echo "||";
	else echo $update_res['updated_time'] . "||" . $update_res['cause'];

	echo '||'; // Для разделения переменной data в js

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
	
	$sum_time = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
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
		$set_finish_time = mysqli_query($connection, "UPDATE `Orders` SET `finish_time` = '".check_time($s_h, $s_m, $s_s)."' WHERE `driver_id` = '".$_POST['driver-id']."' AND `finished` = 'False';");
	}	

mysqli_close($connection);
?>