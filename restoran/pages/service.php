<!DOCTYPE html>
<html>
<head>
	<title>Restoran</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="/img/pizza.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../libs/wow/animate.min.css">
	<script type="text/javascript" src="../libs/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../libs/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../libs/chart/Chart.min.js"></script>
	<script type="text/javascript" src="../libs/wow/wow.min.js"></script>
	<script type="text/javascript">new WOW().init();</script>
	<?php require_once '../config.php'; ?>
	<?php // require_once '../lib.php'; ?>
</head>
<body>


<?php 
    
    
function makeValidPassword($pass) {
        // Просто хеш из строки (можно даже не экранировать) и рандомной соли
    return hash('sha512', $pass . "Wvkp10NSfftI");
}

//echo makeValidPassword("admin2");
    
    $host = $config['server'];
    $user = $config['username'];
    $pass = $config['password']; 
    $base = $config['db_name'];
    $connection = new mysqli($host, $user, $pass, $base);
    
    if ( $connection -> connect_error )
        die("Connection failed: " . $connection -> connect_error);
    $connection -> set_charset('utf8');
    
    $lllogin = $connection -> real_escape_string($_POST['login']);
	$users = mysqli_query($connection, "SELECT * FROM `Users` WHERE login = '$lllogin' AND password = '".makeValidPassword($_POST['password'])."';");
	if (mysqli_num_rows($users) == 1) {
		$user = mysqli_fetch_assoc($users);
		if ($user['Position'] == 'Driver')
			include "driver.php";
		elseif ($user['Position'] == 'Operator') 
			include "operator.php";
		elseif ($user['Position'] == 'admin')
			include "admin.php";
	} 
	else include "error.php";

    mysqli_close($connection); 
    
?>

</body>
</html>