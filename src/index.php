<!DOCTYPE html>
<html>
<head>
	<title>Restoran</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1">
	<link rel="shortcut icon" href="img/pizza.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="libs/wow/animate.min.css">
	<link rel="stylesheet" href="libs/mdl/icon.css">
	<link rel="stylesheet" href="libs/mdl/material.indigo-pink.min.css">
	<script type="text/javascript" src="libs/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="libs/jquery-ui.min.js"></script>
	<script defer src="libs/mdl/material.min.js"></script>
	<script type="text/javascript" src="libs/wow/wow.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
    <script type="text/javascript">new WOW().init();</script>
    <script src="libs/OSM/OpenLayers.js"></script>
	<?php require_once 'config.php'; ?>
	<?php include 'cards.php'; ?>
</head>
<body>
<?php 
	$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']); 
	mysqli_query($connection, "set names 'utf8'");
?>
	<div id='header'>
		<div id='menu'>
			<ul>
				<li id='tracking'>Відстежити замовлення</li>
				<li id='entrance'>Увійти</li>
			</ul>
		</div>
		<div id='header-text'>
			
				<span>Ресторан "Eat for you"</span>
			
		</div>
	</div>
	<div id='content'>
		<div id='content-menu'>
		<br><br>
		<div class='categories'><span>Основні страви</span></div>
		<div class='dishes' id='basic'>
			<?php get_cards_by_class('Basic', $connection); ?>
		</div>

		<div class='categories'><span>Салати</span></div>
		<div class='dishes'  id='salads'>
			<?php get_cards_by_class('Salads', $connection); ?>
		</div>

		<div class='categories'><span>Фастфуд</span></div>
		<div class='dishes' id='fastfood'>
			<?php get_cards_by_class('Fastfood', $connection); ?>
		</div>

		<div class='categories'><span>Напої</span></div>
		<div class='dishes' id='drinks'>
			<?php get_cards_by_class('Drinks', $connection); ?>
		</div>
		</div>
		<div id='order'>
			<div id='order-form'>
				<span>Ваше замовлення</span>
				<form method="POST" action="">
					<div id='order-area'><textarea name='order' readonly></textarea></div>
					<div id='address'>
						<div>
							
						</div>
						<div>
							<textarea id='order-address' name='order-address' placeholder='Адреса' required></textarea>
						</div>
					</div>
					<div id='phone'> 
						<div></div>
						<div>
							<input type="text" name="phone" placeholder='Номер телефону' required="">
						</div>
					</div>
					<div id='order-info'>
						<center>
							<input type="text" name="summary-price" id='summary-price' value='0.00 грн.' readonly>
						</center>
						<center>
							<input type="text" name="summary-time" id='summary-time' value='00:00:00' readonly> 
						</center>
					</div>
					<div id='order-button'>
						<center>
							<input type="submit" name="send" value='Замовити' onclick='check_order()'>
						</center>
					</div>
				</form>
			</div>
		</div>

	</div>
	<footer id='footer'>
		Команда ліцею "ПОЛІТ"
	</footer>


	<button class="mdl-button mdl-js-button mdl-button--fab shopping-basket-button wow bounceInUp" id='shopping-basket-button'>
		<i class="material-icons">shopping_basket</i>
	</button>
	<div class="mdl-badge mdl-badge--overlap wow bounceInUp" data-wow-delay="0.1s" id="shopping-basket-button-num" data-badge="0"></div>

	<button class="mdl-button mdl-js-button mdl-button--fab wow bounceInUp" id="burger-menu">
		<i class="material-icons">menu</i>
	</button>

	<button class="mdl-button mdl-js-button mdl-button--fab wow bounceInUp" id="go-top-button">
		<i class="material-icons">arrow_upward</i>
	</button>

	<!-- <div class='push-message'>asd</div> -->

	<div class="popup_overlay"></div>
	<div class="popup">
		<form class="front login" method='POST' action='pages/service.php'>
			<div id='front-popup-title'>
				<div id='title-1'>
					Вхід
				</div>
				<div id='title-2'>
					Реєстрація
				</div>
			</div>
			<center id='front-card-block-login'>
				<div>Логін:</div>
				<input type="text" name="login" required>
			</center>
			<center id='front-card-block-password'>
				<div>Пароль:</div>
				<input type="password" name="password" required>
			</center>
			<center id='front-card-block-submit'>
				<input type="submit" name="check" value='Увійти'>
			</center>
		</form>
		<form class="back register" method='POST' action=''>
			<div id='back-popup-title'>
				<div id='title-3'>
					Вхід
				</div>
				<div id='title-4'>
					Реєстрація
				</div>
			</div>
			<center id='back-card-block-username' class='back-card-block'>
				<div>Ім'я:</div>
				<input type="text" name="username" required>
			</center>
			<center id='back-card-block-login' class='back-card-block'>
				<div>Логін(E-Mail):</div>
				<input type="text" name="login" required>
			</center>
			<center id='back-card-block-password' class='back-card-block'>
				<div>Пароль:</div>
				<input type="password" name="password" required>
			</center>
			<center id='back-card-block-repeat-password' class='back-card-block'>
				<div>Повторити пароль:</div>
				<input type="password" name="repeat-password" required>
			</center>
			<center id='back-card-block-select' class='back-card-block'>
				<div>Посада:</div>
				<select name='position'>
					<option>Operator</option>
					<option>Driver</option>
				</select>
			</center>
			<center id='back-card-block-key' class='back-card-block'>
				<div>Ключ:</div>
				<input type="text" name="key" required>
			</center>
			<center id='back-card-block-submit'>
				<input type="submit" name="check" value='Зареєструватися'>
			</center>
		</form>
	</div>

	<div class="track">
		<div>
			<div>
				<input type="text" placeholder="ID замовлення" id='order-id'>
				<input type="password" placeholder="Password" id='order-pass'>
				<button id='track-button'>Відстежити</button>
			</div>
		</div>
		<div>
			<center>Замовлення:<br><textarea id='t-order' rows='3' readonly></textarea> </center>
			<center>Адреса:<br><textarea id='t-address' rows='2' readonly></textarea> </center>
			<center>Повідомлення:<br><textarea id='t-message' rows='2' readonly></textarea> </center>
			<center>Дата і час замовлення:<br><input id='i-date' type='text' readonly> </center>
			<center>Час приготування:<br><input id='i-summary_time' type='text' readonly> </center>
			<center>Час доставки:<br><input id='i-delivery_time' type='text' readonly> </center>
			<center>Приблизний час прибуття:<br><input id='i-finish_time' type='text' readonly> </center>
			<center>Ціна:<br><input id='i-summary_price' type='text' readonly> </center>
			<!-- <center>Місцезнаходження водія:<br><textarea id='t-location' rows='2' readonly></textarea> </center> -->
			<center>Місцезнаходження водія:<br><div id="mapdiv"></div></textarea> </center>
				
		</div>
	</div>

	<div id="shopping-basket-overlay"></div>
	<div id='shopping-basket' class='shopping-basket'> 
		<table>
			<thead>
				<tr>
					<th>Кількість</th>
					<th>Страва</th>
				</tr>
			</thead>
			<tbody id='shopping-basket-list'>
				
			</tbody>
		</table>
	</div>

<?php mysqli_close($connection); ?>
</body>
</html>