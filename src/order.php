<!DOCTYPE html>
<html>
<head>
	<title>Restoran</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<link rel="shortcut icon" href="img/pizza.ico" type="image/x-icon">
	<link rel="stylesheet" href="../libs/mdl/icon.css">
	<link rel="stylesheet" href="../libs/mdl/material.indigo-pink.min.css">
	<script type="text/javascript" src="../libs/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../libs/jquery-ui.min.js"></script>
	<script defer src="../libs/mdl/material.min.js"></script>
</head>
<body>

<?php

require_once 'config.php';
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['db_name']);
mysqli_query($connection, "set names 'utf8'");


$_POST['order-address'] = $connection -> real_escape_string($_POST['order-address']);
$_POST['summary-time'] = $connection -> real_escape_string($_POST['summary-time']);
$_POST['phone'] = $connection -> real_escape_string($_POST['phone']);


	
	function add_to_statistic($dish, $connection) {
		$search_dish_info = mysqli_query($connection, "SELECT * FROM `Dishes` WHERE `dish` = '".$dish."';");
		$search_dish_info_res = mysqli_fetch_assoc($search_dish_info);
		$add_to_order_statistic = mysqli_query($connection, "INSERT INTO `Order_statistics` (`id`, `dish_id`, `dish_name`, `date`) VALUES (NULL, '".$search_dish_info_res['id']."', '".$search_dish_info_res['dish']."', CURRENT_TIMESTAMP)");
	}

	function check_shelf_life($connection, $shelf_life) {
		$date = date('d.m.Y');
		$d1 = strtotime( $shelf_life );
		$d2 = strtotime( $date );

		if ( $d1 - $d2 <= 0 )
			return false;
		else 
			return true;	
	}

                                                                                
	$sql = mysqli_query($connection, "INSERT INTO `Orders` (`id`, `ordered_dishes`, `address`, `summary_time`, `delivery_time`, `summary_price`, `date`, `phone`) VALUES (NULL, '".$_POST['order']."', '".$_POST['order-address']."', '".$_POST['summary-time']."', NULL, '".$_POST['summary-price']."', CURRENT_TIMESTAMP, '".$_POST['phone']."');");

	$message = '';
	$errors = false;

	$order_id = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `address`='".$_POST['order-address']."' ORDER BY `id` DESC;");
	$res_rows = mysqli_fetch_assoc($order_id);
	$ids = $res_rows['id'];



	// $dishes = split("\n", $_POST['order']);
	$dishes = preg_split("/[\s,]+/", $_POST['order']);
	unset( $dishes[count($dishes)-1] );
	foreach ($dishes as $dish) {


		$dish = trim($dish);
		$dish_search = mysqli_query($connection, "SELECT * FROM `Dishes` WHERE `dish` LIKE '%".$dish."%';");
		
		add_to_statistic($dish, $connection);
		if (mysqli_num_rows($dish_search) == 0) 
		{
			$errors = true;
			$message = 'Страва не знайдена. Спробуйте пізніше.';
			$send_message = mysqli_query($connection, "UPDATE `Orders` SET `finished` = 'True', `message` = '".$message."' WHERE `Orders`.`id` = ".$ids.";");
			break;
		}
		else 
		{
			$dish_search_res = mysqli_fetch_assoc($dish_search);
			$ingredients = preg_split("/\,/ ", $dish_search_res['products']);
			$ingredients_quantity = preg_split("/\,/ ", $dish_search_res['quantity']);
			for ($i = 0; $i < count($ingredients); $i++) {
				$search_product_in_storage = mysqli_query($connection, "SELECT * FROM `Storage` WHERE `product` LIKE '%".trim( $ingredients[$i] )."%';");
				$search_product_in_storage_res = mysqli_fetch_assoc($search_product_in_storage);
				if ( ($search_product_in_storage_res['quantity'] - $ingredients_quantity[$i]) < 0 || !check_shelf_life($connection, $search_product_in_storage_res['shelf_life'])) 
				{
					$errors = true;
					$message = 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.';
					$send_message = mysqli_query($connection, "UPDATE `Orders` SET `finished` = 'True', `message` = '".$message."' WHERE `Orders`.`id` = ".$ids.";");
					break;
				} else {
					$checkquantity_dish_in_storage = mysqli_query($connection, "UPDATE `Storage` SET `quantity` = `quantity` - '".trim( $ingredients_quantity[$i] )."' WHERE `product` LIKE '%".trim( $ingredients[$i] )."%';");


				}
			}

		}  
	}
 
?>
<style>
	@import url('https://fonts.googleapis.com/css?family=Roboto');

	* { padding: 0px; margin: 0px; }
	html { height: 100%; }
	body { height: 100%; width: 100%; font-family: 'Roboto', sans-serif; background: url('/img/background.jpg');}
	a {text-decoration: none;}

	#wrap {
		background-color: rgba(0, 0, 0, 0.3);
		width: 100%;
		height: 100%;

		display: flex;
		justify-content: center;
		align-items: center;
	}

	#content {
		background-color: #f9f9f9;
		width: 50%;
		height: 60%;
		display: grid;
		grid-template-rows: 1fr 2fr 1fr 1fr;
		border-radius: 10px;
	}
	#content > center {
		display: flex;
		justify-content: center;
		align-items: center;
		overflow: auto;
	}

	#content > center:nth-child(1) {
		font-size: 2em;
		font-family: Comic Sans MS;
		margin: 10px;
		font-weight: bold;
		color: #007218;
	}

	#content > center:nth-child(2) {
		font-size: 1.7em;
		font-family: Comic Sans MS;
		margin: 10px;
	}

	#content > center:nth-child(3) div {
		width: 50px;
		height: 50%;
		margin-right: 10px;
	}

	#content > center:nth-child(3) div img {
		width: 500px%;
		height: 100%;
	}

	#content > center:nth-child(3) input[type='password'] {
		outline: none;
		font-size: 1em;
		height: 50%;
		width: 50%;
		border: 1px solid silver;
		border-radius: 10px;
		margin-right: 10px;
		text-align: center;
	}

	#content > center:nth-child(3) button:not(.mdl-button) {
		height: 50%;
		outline: none;
		font-size: 1.5em;
		border: 1px solid silver;
		border-radius: 10px;
	}

	#content > center:nth-child(3) > button:active {
		background-color: #c4c4c4;
	}


	#content > center:nth-child(4) > a > button {
		outline: none;
		font-size: 1.5em;
		padding: 2%;
		border: 1px solid silver;
		border-radius: 10px;
	}

	#content > center:nth-child(4) > a > button:active {
		background-color: #c4c4c4;
	}
	
	@media (max-width: 450px) {
        * {font-size: 0.9em;}
        
        #content {
            width: 90%;
            height: 70%;
        }
        
        #set-order_pass {
            font-size: 0.8em;
        }
    }
    
    @media (min-width: 451px) and (max-width: 1100px) {
         * {font-size: 1em;}
        
        #content {
            width: 70%;
            height: 60%;
        }
    }


</style>
<script>
	$(function () {
		$('#info').click(function () {
			alert('Встановіть пароль для замовлення. Використовуючи його ви зможете дізнатися про теперішннй стан доставки.');
		});

		$('#set-order_pass').click(function () {
			var order_pass_pattern = /[\s]/;
			if (order_pass_pattern.test($("#order-pass").val()) || $("#order-pass").val() == '')
			{
				alert('Пароль не повинен містити пробіли');
			} else {
				$('#content center:nth-child(4) a').attr('href', '/');
				$.ajax({
					url: 'subprograms/set-order-pass.php',
					type: 'POST',
					data: ({
						'order-pass': $('#order-pass').val(),
						'order-id': $('#order-id').text()
					}),
					success: function () {
						$('#order-pass').animate({
							'border-color': '#00ff55'
						}, 500);
						setTimeout(function () {
							$('#order-pass').animate({
							'border-color': 'silver'
						}, 500);
						}, 1000);
					}
				});
			}
		});
	});
</script>
<div id='wrap'>
	<div id='content'>
		<?php 
			if ($errors == false) 
				echo "<center>Замовлення прийнято</center>";
			else 
				echo "<center style='color: #ff3262;'>".$message."</center>";
		?>
		<?php 
			if ( $errors == false ) {
				if (mysqli_num_rows($order_id) == 1) 
				{
					echo "<center>Id вашого замовлення для відстежування: <br><span id='order-id'>".$ids."</span></center>";
				} else {
					echo "<center>Id ваших замовлень для відстежування: <br><span id='order-id'>".$ids."</span></center>";
				}
			} else {
				echo "<center>Не вдалося виконати замовлення з ID: <br><span id='order-id'>".$ids."</span></center>";
			}
		?>
		<?php 
			if ($errors == false) 
				echo "<center>";
			else 
				echo "<center style='visibility: hidden;'>";
		?>
			<div id='info' >
				<button class="mdl-button mdl-js-button mdl-button--fab">
					<i class="material-icons">info</i>
				</button>
			</div>
			<input id='order-pass' placeholder="Пароль для відстежування замовлення" type="password">
			<button id='set-order_pass'>Відіслати</button>
		</center>
		<?php 
			if ($errors == false) 
				echo "<center><a href='#'><button>Повернутися до меню</button></a></center>";
			else 
				echo "<center><a href='/'><button>Повернутися до меню</button></a></center>";
		?>
	</div>
</div>
<?php mysqli_close($connection); ?>
</body>
</html>