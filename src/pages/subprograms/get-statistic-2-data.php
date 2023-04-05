<?php 

function f($x) {
    return sprintf("%'02s", $x);
}	

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	$sql = "SELECT COUNT(*) AS cnt FROM `Order_statistics` WHERE DATE_FORMAT(date,\"%m-%Y\") = '" . f($_POST['month']) . "-".$_POST['year']."';";
//	error_log($sql);
	$search_data = mysqli_query($connection, $sql);
	$search_data_res =  mysqli_fetch_assoc($search_data);
	echo $search_data_res['cnt'];
	//file_put_contents("kek{$_POST['month']}.txt", $sql . "\n" . $search_data_res['cnt']);

mysqli_close($connection);

