<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");
	
	// $search_date = mysqli_query($connection, "SELECT * FROM `Order_statistics`;");
	// $res = mysqli_fetch_assoc($search_date);
	// $date = strtotime( $res['date'] );
	// echo date('Y', $date) ;

	$month = $_POST['month'];
	$year = $_POST['year'];
	$date_arr = [];

	$month_array = array(
		"Всі"		=> "0",
		"Січень"	=> "01",
		"Лютий"		=> "02",
		"Березень"	=> "03",
		"Квітень"	=> "04",
		"Травень"	=> "05",
		"Червень"	=> "06", 
		"Липень"	=> "07",
		"Серпень"	=> "08",
		"Вересень"	=> "09",
		"Жовтень"	=> "10",
		"Листопад"	=> "11",
		"Грудень"	=> "12",
	);

	$result = "";

	for ($i = 1; $i <= 31; $i++) {
		$d = "" . intval($i/10) . $i%10; 
		$sql = "SELECT COUNT(*) AS cnt FROM `Order_statistics` WHERE `date` >= '$year-".$month_array[$month]."-$d 00:00:00' AND `date` <= '$year-".$month_array[ $month]."-$d 23:59:59'";
		file_put_contents("kek.txt", $sql);
		$search_date = mysqli_query($connection, $sql);
		$search_date_res = mysqli_fetch_assoc($search_date);
		$result .= $search_date_res['cnt'] . ', ';
	}
	$result .= "0";		
	
	echo $result;

mysqli_close($connection);

?>