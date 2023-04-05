<!DOCTYPE html>
<html>
<head>
  <title>Restoran</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="img/pizza.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="register.css">
  <link rel="stylesheet" type="text/css" href="libs/wow/animate.min.css">
  <script type="text/javascript" src="libs/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="libs/jquery-ui.min.js"></script>
  <script type="text/javascript" src="libs/wow/wow.min.js"></script>
  <script type="text/javascript">new WOW().init();</script>
  <?php require_once 'config.php'; ?>
</head>
<body>
<?php 
  $connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']); 
  mysqli_query($connection, "set names 'utf8'");
?>
<?php


function makeValidPassword($pass) {
        // Просто хеш из строки (можно даже не экранировать) и рандомной соли
    return hash('sha512', $pass . "Wvkp10NSfftI");
}
    $repeat = false;
    $_POST['key'] = $connection -> real_escape_string($_POST['key']);
    $_POST['login'] = $connection -> real_escape_string($_POST['login']);
    $_POST['username'] = $connection -> real_escape_string($_POST['username']);
    $_POST['position'] = $connection -> real_escape_string($_POST['position']);
    $_POST['password'] = makeValidPassword($_POST['password']);


  $repeated_login = mysqli_query($connection, "SELECT `login` FROM `Users` WHERE `login` = '".$_POST['login']."';");
  $search_key = mysqli_query($connection, "SELECT * FROM `Registration_keys` WHERE `registration_key` = '".$_POST['key']."';");
  if (mysqli_num_rows($repeated_login) > 0) {
   $repeat = true;
  } 
  elseif ( mysqli_num_rows($search_key) == 0 ) {
   $key_error = true;
  }
  else {
   $search_key_res = mysqli_fetch_assoc($search_key);
   if ( $search_key_res['position'] == 'admin' ) {
    $add_user = mysqli_query($connection, "INSERT INTO `Users` (`id`, `Username`, `Login`, `Password`, `Position`) VALUES (NULL, '".$_POST['username']."', '".$_POST['login']."', '".$_POST['password']."', 'admin'); ");
    $_POST['position'] = 'admin';
    $repeat = false;
    $key_error = false;
   }
   elseif ( $search_key_res['position'] != $_POST['position'] ) {
    $key_error = true;
   }
   else {
    $add_user = mysqli_query($connection, "INSERT INTO `Users` (`id`, `Username`, `Login`, `Password`, `Position`) VALUES (NULL, '".$_POST['username']."', '".$_POST['login']."', '".$_POST['password']."', '".$_POST['position']."'); ");
    $repeat = false;
    $key_error = false;
   }
  }
?>
<div id='wrap'>
  <div id='content'>
   <?php 
   if ($repeat) echo "<center style='color: #ff3262;'>Користувач з таким логіном вже існує</center>";
   elseif ($key_error) echo "<center style='color: #ff3262;'>Ключ не знайдено</center>";
   else echo "<center style='color: #007218;'>Реєстрація користувача ".$_POST['username']." пройшла успішно</center>";
   ?>
   <!-- <center>Реєстрація користувача <?php echo $_POST['username']; ?> пройшла успішно</center> -->
   <center>
    <div>Username:<br><input type="text" value="<?php echo $_POST['username']; ?>" readonly></div>
    <div>Login:<br><input type="text" value="<?php echo $_POST['login']; ?>" readonly></div>
    <div>Position:<br><input type="text" value="<?php echo $_POST['position']; ?>" readonly></div>
   </center>
   <center><a href='/'><button><?php if ($repeat) echo "Повернутися до меню"; else echo "Увійти в аккаунт"; ?></button></a></center>
  </div>
</div>

<?php mysqli_close($connection); ?>
</body>
</html>







