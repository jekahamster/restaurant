<?php 

require_once '../../config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");

	mysqli_query($connection, "	UPDATE `Registration_keys` SET `registration_key` = '".$_POST['admin-key']."' WHERE `Registration_keys`.`id` = 1;");
	mysqli_query($connection, "	UPDATE `Registration_keys` SET `registration_key` = '".$_POST['operator-key']."' WHERE `Registration_keys`.`id` = 2;");
	mysqli_query($connection, "	UPDATE `Registration_keys` SET `registration_key` = '".$_POST['driver-key']."' WHERE `Registration_keys`.`id` = 3;");


mysqli_close($connection);

?>