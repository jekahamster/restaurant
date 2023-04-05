<?php 



function makeValidPassword($pass) {
        // Просто хеш из строки (можно даже не экранировать) и рандомной соли
    return hash('sha512', $pass . "Wvkp10NSfftI");
}


require_once 'config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
        
    $login = $connection -> real_escape_string($_POST['login']);
    $pass = makeValidPassword($_POST['password']);
    $sQuery = "SELECT * FROM Users WHERE login = '$login' AND password = '$pass';";
  $users = mysqli_query($connection, $sQuery);
  if (mysqli_num_rows($users) == 1) {
    $user = mysqli_fetch_assoc($users);
    include "driver.php";
  } 
  else echo 'User not found';

mysqli_close($connection);


