<?php 
    if ( 1 && !$user['id'] ) {
        header("Location: https://eatforyou.tk/");
        exit;
    }
?>


<meta name="viewport" content="width=device-width, initial-scale = 1">
<link rel="stylesheet" href="../libs/mdl/icon.css">
<link rel="stylesheet" href="../libs/mdl/material.indigo-pink.min.css">
<script defer src="../libs/mdl/material.min.js"></script>
<link rel="stylesheet" type="text/css" href="operator.css">
<script>
	var drivers_sort_button 			= 1,
		orders_sort_button 				= 1,
		messages_sort_button 			= 1,
		time_shift_request_sort_button 	= 1,
		storage_sort_button 			= 1;

	$(function () {
        
        update_page();
        
		$('button').css({
			'text-transform': 'none',
			'line-height': 'normal'
		});

		$('#navigation-menu').on('mouseover', function () {

			if (window.innerWidth > 450) {
				$('#navigation-menu').css({
						"transition": "0.05s ease",	
						"font-size": "18px",
						"background-color": "#adef88"
				});
				$('#navigation-menu > a').css({
						"transition": "0.3s ease",
						"padding": "20px 0px"
				});
			} else {
				$('#navigation-menu').css({
						"transition": "0.05s ease",	
						"font-size": "0.8em",
						"background-color": "#adef88"
				});
				$('#navigation-menu > a').css({
						"transition": "0.3s ease",
						"padding": "0px 0px"
				});
			}
		});

		$('#navigation-menu').on('mouseout', function () {
			if (window.innerWidth > 450) {
				$('#navigation-menu').css({
						"transition": "0.05s ease",	
						"font-size": "15px",
						"background-color": "#d4ffb2"
				});
				$('#navigation-menu > a').css({
						"transition": "0.3s ease",
						"padding": "0px 0px"
				});
			} else {
				$('#navigation-menu').css({
						"transition": "0.05s ease",	
						"font-size": "0.8em",
						"background-color": "#d4ffb2"
				});
				$('#navigation-menu > a').css({
						"transition": "0.3s ease",
						"padding": "0px 0px"
				});
			}
		});

		var $page = $('html, body');
		$('a[href*="#"]').click(function() {
		    $page.animate({
		        scrollTop: $($.attr(this, 'href')).offset().top
		    }, 400);
		    return false;
		});

		// Drivers
		$('#free').click(function () {
			$.ajax({
				url: 'subprograms/update-drivers-list.php',
				type: 'POST',
				data: ({
					'mode': 'free'
				}),
				success: function (data) {
					$('#drivers-list').html(data);
					drivers_sort_button = 1;
				}
			});
		});

		$('#on-order').click(function () {
			$.ajax({
				url: 'subprograms/update-drivers-list.php',
				type: 'POST',
				data: ({
					'mode': 'on-order'
				}),
				success: function (data) {
					$('#drivers-list').html(data);
					drivers_sort_button = 2;
				}
			});
		});

		$('#on-rest').click(function () {
			$.ajax({
				url: 'subprograms/update-drivers-list.php',
				type: 'POST',
				data: ({
					'mode': 'on-rest'
				}),
				success: function (data) {
					$('#drivers-list').html(data);
					drivers_sort_button = 3;
				}
			});
		});

		$('#in-restaurant').click(function () {
			$.ajax({
				url: 'subprograms/update-drivers-list.php',
				type: 'POST',
				data: ({
					'mode': 'in-restaurant'
				}),
				success: function (data) {
					$('#drivers-list').html(data);
					drivers_sort_button = 4;
				}
			});
		});

		// Orders
		$('#unfulfilled').click(function () {
			$.ajax({
				url: 'subprograms/update-orders-list.php',
				type: 'POST',
				data: ({
					'mode': 'unfulfilled'
				}),
				success: function (data) {
					$('#orders-list').html(data);
					orders_sort_button = 1;
				}
			});
		});

		$('#executed').click(function () {
			$.ajax({
				url: 'subprograms/update-orders-list.php',
				type: 'POST',
				data: ({
					'mode': 'executed'
				}),
				success: function (data) {
					$('#orders-list').html(data);
					orders_sort_button = 2;
				}
			});
		});

		$('#all-orders').click(function () {
			$.ajax({
				url: 'subprograms/update-orders-list.php',
				type: 'POST',
				data: ({
					'mode': 'all-orders'
				}),
				success: function (data) {
					$('#orders-list').html(data);
					orders_sort_button = 3;
				}
			});
		});

		// Recommended drivers list
		$('#update-recommended-drivers-list').click(function () {
			$.ajax({
				url: 'subprograms/update-recommended-drivers-list.php',
				type: 'POST',
				success: function (data) {
					$('#recommended-drivers-list').html(data);
				}
			});
		});

		// Set driver

		$('#search-driver').click(function () {
			$.ajax({
				url: 'subprograms/search-driver.php',
				type: 'POST',
				data: ({
					'driver-id': $('#search-driver-inp').val()
				}),
				success: function (data) {
					var out = data.split('||');
					$('#driver-name').val(out[0]);
					$('#delivery-time').val(out[1]);
					$('#set-order-inp').val(out[2]);
				}
			});
		});

		$('#set-order').click(function () {
			var space_pattern = /[\s]/;
			var inp_time = $('#delivery-time').val();
			if (space_pattern.test($("#search-driver-inp").val()) || $("#search-driver-inp").val() == '')
				alert('Полке з ID водія не повинно містити пробіли!');
			else if (space_pattern.test($('#delivery-time').val()))
				alert('Полке з delivery time водія не повинно містити пробіли!');
			else if ($('#delivery-time').val() != '')
				if (isNaN(parseInt(inp_time[0]+inp_time[1])) || isNaN(parseInt(inp_time[3]+inp_time[4])) || isNaN(parseInt(inp_time[6]+inp_time[7])))
					alert('Час доставки повинен бути у форматі ГГ:ХХ:СС');
			else
				$.ajax({
					url: 'subprograms/upgrade-driver-order.php',
					type: 'POST',
					data: ({
						'driver-id': $('#search-driver-inp').val(),
						'order-id': $('#set-order-inp').val(),
						'delivery-time': $('#delivery-time').val()
					}),
					success: function (data) {
						if (data != '')
							alert(data);
					}
				});
		});

		// Change finished

		$('#cancel-order, #l-cancel-order').click(function () {
			$("#cancel-order").attr("checked", "checked");
			$("#сontinue-order").removeAttr("checked");
		});

		$('#сontinue-order, #l-сontinue-order').click(function () {
			$("#cancel-order").removeAttr("checked");
			$("#сontinue-order").attr("checked", "checked");
		});

		$('#send-changes').click(function () {
			var ans;
			if ($('#cancel-order').attr("checked") == 'checked')
				ans = 'cancel';
			else if ($('#сontinue-order').attr("checked") == 'checked')
				ans = 'сontinue';
			$.ajax({
				url: 'subprograms/upgrade-finished.php',
				type: 'POST',
				data: ({
					'order-id': $('#order-id').val(),
					'answer': ans
				})
			});
		});

		// Check message

		$('#messgae_all-orders').click(function () {
			$.ajax({
				url: 'subprograms/update-message.php',
				type: 'POST',
				data: ({
					'mode': 'all-orders'
				}),
				success: function (data) {
					$('#message-list').html(data);
					messages_sort_button = 1;
				}
			});
		});
		
		$('#message_unfulfilled').click(function () {
			$.ajax({
				url: 'subprograms/update-message.php',
				type: 'POST',
				data: ({
					'mode': 'unfulfilled'
				}),
				success: function (data) {
					$('#message-list').html(data);
					messages_sort_button = 2;
				}
			});
		});
		
		$('#message_executed').click(function () {
			$.ajax({
				url: 'subprograms/update-message.php',
				type: 'POST',
				data: ({
					'mode': 'executed'
				}),
				success: function (data) {
					$('#message-list').html(data);
					messages_sort_button = 3;
				}
			});
		});

		// Message

		$('#search-message').click(function () {
			$.ajax({
				url: 'subprograms/order-message.php',
				type: 'POST',
				data: ({
					'message-mode': 'search',
					'order-id': $('#message-order-id').val(),
					'message': $('#order-message').val()
				}),
				success: function (data) {
					$('#order-message').val(data);
				}
			});
		});

		$('#send-message').click(function () {
			$.ajax({
				url: 'subprograms/order-message.php',
				type: 'POST',
				data: ({
					'message-mode': 'send',
					'order-id': $('#message-order-id').val(),
					'message': $('#order-message').val()
				}),
				success: function (data) {
					if ( $('#message-order-id').val() == '' ) {
						$('#order-message').animate({
							'border-color': '#ff2b2b'
						}, 500);
						setTimeout(function () {
							$('#order-message').animate({
							'border-color': 'silver'
						}, 500);
						}, 1000);
					} else {
						$('#order-message').animate({
							'border-color': '#00ff55'
						}, 500);
						setTimeout(function () {
							$('#order-message').animate({
							'border-color': 'silver'
						}, 500);
						}, 1000);
					}
				}
			});
		});

		// Time shift request

		$('#time-shift-request-all').click(function () {
			$.ajax({
				url: 'subprograms/update-time-shift-request.php',
				type: 'POST',
				data: ({
					'mode': 'all'
				}),
				success: function (data) {
					$('#time-shift-request-list').html(data);
					time_shift_request_sort_button = 1;
				}
			});
		});

		$('#time-shift-request-no-answer').click(function () {
			$.ajax({
				url: 'subprograms/update-time-shift-request.php',
				type: 'POST',
				data: ({
					'mode': 'no-answer'
				}),
				success: function (data) {
					$('#time-shift-request-list').html(data);
					time_shift_request_sort_button = 2;
				}
			});
		});

		$('#time-shift-request-confirmed').click(function () {
			$.ajax({
				url: 'subprograms/update-time-shift-request.php',
				type: 'POST',
				data: ({
					'mode': 'confirmed'
				}),
				success: function (data) {
					$('#time-shift-request-list').html(data);
					time_shift_request_sort_button = 3;
				}
			});
		});

		$('#time-shift-request-rejected').click(function () {
			$.ajax({
				url: 'subprograms/update-time-shift-request.php',
				type: 'POST',
				data: ({
					'mode': 'rejected'
				}),
				success: function (data) {
					$('#time-shift-request-list').html(data);
					time_shift_request_sort_button = 4;
				}
			});
		});

		// Set request

		$('#confirm, #l-confirm').click(function () {
			$("#confirm").attr("checked", "checked");
			$("#reject").removeAttr("checked");
		});

		$('#reject, #l-reject').click(function () {
			$("#confirm").removeAttr("checked");
			$("#reject").attr("checked", "checked");
		});

		$('#send-request').click(function () {
			var ans;
			if ( $('#confirm').attr("checked") == "checked" )
				ans = 'confirm';
			if ( $('#reject').attr("checked") == "checked" )
				ans = 'reject';
			$.ajax({
				url: 'subprograms/upgrade-time-shift-request.php',
				type: 'POST',
				data: ({
					'mode': 'upgrade',
					'answer': ans,
					'request-id': $('#request-id').val()
				})
			});
		});

		// Products

		$('#sort-by-id').click(function () {
			$.ajax({
				url: 'subprograms/update-products-list.php',
				type: 'POST',
				data: ({
					'sort-by': 'id'
				}),
				success: function (data) {
					$('#products-list').html(data);
					storage_sort_button = 1;
				}
			});
		});

		$('#sort-by-name').click(function () {
			$.ajax({
				url: 'subprograms/update-products-list.php',
				type: 'POST',
				data: ({
					'sort-by': 'name'
				}),
				success: function (data) {
					$('#products-list').html(data);
					storage_sort_button = 2;
				}
			});
		});

		$('#sort-by-quantity').click(function () {
			$.ajax({
				url: 'subprograms/update-products-list.php',
				type: 'POST',
				data: ({
					'sort-by': 'quantity'
				}),
				success: function (data) {
					$('#products-list').html(data);
					storage_sort_button = 3;
				}
			});
		});

		$('#sort-by-shelf-life').click(function () {
			$.ajax({
				url: 'subprograms/update-products-list.php',
				type: 'POST',
				data: ({
					'sort-by': 'shelf-life'
				}),
				success: function (data) {
					$('#products-list').html(data);
					storage_sort_button = 4;
				}
			});
		});

		// Update warnings 

		$('#update-warnings').click(function () {
			$.ajax({
				url: 'subprograms/update-warnings.php',
				type: 'POST',
				success: function (data) {
					var out = data.split("||");
					// out[0] - quantity notification
					// out[1] - quantity warning
					// out[2] - shelf time notification
					// out[3] - quantity warning
					
					$('#t-warning-1').text(out[0]);
					$('#t-warning-2').text(out[2]);
					$('#t-warning-3').text(out[1]);
					$('#t-warning-4').text(out[3]);
				}
			});
		});

	});
	
	function update_page() {
	    $("#drivers-filter > button:nth-child("+drivers_sort_button+")").trigger('click');
	    $("#orders-filter > button:nth-child("+orders_sort_button+")").trigger('click');
	    $("#message-filter > button:nth-child("+messages_sort_button+")").trigger('click');
	    $("#time-shift-request-filter > button:nth-child("+time_shift_request_sort_button+")").trigger('click');
	    $("#products-filter > button:nth-child("+storage_sort_button+")").trigger('click');
	    $("#update-warnings").trigger('click');
	    
	    setTimeout('update_page()', 30000);
    }
</script>
<center id='background-block'>
	<span class='user-hide' id='userid'><?php echo $user['id']; ?></span>
	<span class='user-hide' id='username'><?php echo $user['Username']; ?></span>

	<div id='go-back' class='wow bounceInLeft'><a href='/'><img src="/img/back.png"></a></div>
	<div id='content'>
		<div id='welcome'>З поверненням, <?php echo $user['Username']; ?>!</div>
		<div id='navigation-menu'>
			<a href='#drivers'>Водії</a>
			<a href='#orders'>Замовлення</a>
			<a href='#check-message'>Повідомлення</a>
			<a href='#time-shift-request'>Запити на зміну часу</a>
			<a href='#products'>Склад</a>
		</div>

		<div id='drivers'>
			<div>Список водіїв</div>
			<div id='drivers-filter'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='free'>Вільні</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='on-order'>На замовленні</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='on-rest'>На відпочинку</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='in-restaurant'>В ресторані</button>
			</div>
			<div>
				<span class='driver-id'>ID водія</span>
				<span class='driver-name'>Ім'я водія</span>
				<span class='driver-location'>Місцезнаходження</span>
				<span class='driver-order-id'>ID замовлення</span>
			</div>
			<div id='drivers-list'>
				<?php
					$search_drivers = mysqli_query($connection, "SELECT * FROM `Drivers` WHERE `order_id` is NULL;");
					for ($i = 0; $i < mysqli_num_rows($search_drivers); $i++) {
						$search_drivers_res = mysqli_fetch_assoc($search_drivers);
						echo "
							<div>
								<span>".$search_drivers_res['driver_id']."</span>
								<span>".$search_drivers_res['driver_name']."</span>
								<span>".$search_drivers_res['location']."</span>
								<span>".$search_drivers_res['order_id']."</span>
							</div>
						";
					}
				?>
			</div>
		</div>

		<hr>

		<div id='orders'>
			<div>Список замовлень</div>
			<div id='orders-filter'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='unfulfilled'>Невиконані</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='executed'>Виконані</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='all-orders'>Всі</button>
			</div>
			<div>
				<span>ID</span>
				<span>Страви</span>
				<span>Адреса</span>
				<span>Приготування</span>
				<span>Доставки</span>
				<span>Дата</span>
				<span>Прибуття</span>
				<span>Ціна</span>
				<span>ID водія</span>
				<span>Виконано</span>
			</div>
			<div id='orders-list'>
				<?php
					$search_orders = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `finished` = 'False' ORDER BY `Orders`.`id` DESC;");
					for ($i = 0; $i < mysqli_num_rows($search_orders); $i++) {
						$search_orders_res = mysqli_fetch_assoc($search_orders);
						echo "
							<div>
								<span>".$search_orders_res['id']."</span>
								<span>".$search_orders_res['ordered_dishes']."</span>
								<span>".$search_orders_res['address']."</span>
								<span>".$search_orders_res['summary_time']."</span>
								<span>".$search_orders_res['delivery_time']."</span>
								<span>".$search_orders_res['date']."</span>
								<span>".$search_orders_res['finish_time']."</span>
								<span>".$search_orders_res['summary_price']."</span>
								<span>".$search_orders_res['driver_id']."</span>
								<span>".$search_orders_res['finished']."</span>
							</div>
						";
					}
				?>
			</div>
		</div>


		<div id='set-driver'>
			<div>Встановити/замінити водія для замовлення</div>
			<div>
				<input type='text' id='search-driver-inp' placeholder='ID водія'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='search-driver'>Знайти</button>
			</div>
			<div>
				<input type='text' id='driver-name' placeholder="Ім'я водія" readonly>
			</div>
			<div>
				<input type='text' id='delivery-time' placeholder='Час доставки(00:00:00)'>
			</div>
			<div>
				<input type="text" id='set-order-inp' placeholder='ID замовлення'>
				<button class="mdl-button mdl-js-button mdl-button--raised" id='set-order'>Встановити/Замінити</button>
			</div>
		</div>

		<div id='change-finished'>
			<div>Продовжити/відмінити замовлення</div>
			<div>
				<input type="text" id='order-id' placeholder='ID замовлення'>
				<form>
					<label id='l-cancel-order' class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="cancel-order">
						<input type="radio" id="cancel-order" class="mdl-radio__button" name="finished" style='z-index: 0;'>
						<span class="mdl-radio__label">Відмінити</span>
					</label>
					<label id='l-сontinue-order' class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="сontinue-order">
						<input type="radio" id="сontinue-order" class="mdl-radio__button" name="finished" style='z-index: 0;'>
						<span class="mdl-radio__label">Продовжити</span>
					</label>
				</form>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='send-changes'>Відіслати</button>
			</div>
		</div>

		<hr>

		<div id='check-message'>
			<div>Повідомлення до замовлення</div>
			<div id='message-filter'>
				<button id='messgae_all-orders' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Всі</button>
				<button id='message_unfulfilled' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Невиконані</button>
				<button id='message_executed' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Виконані</button>
			</div>
			<div>
				<span>ID замовлення</span>
				<span>Повідомлення</span>
				<span>Виконано</span>
			</div>
			<div id='message-list'>
				<?php
					$search_message = mysqli_query($connection, "SELECT * FROM `Orders`;");
					for ($i = 0; $i < mysqli_num_rows($search_message); $i++) {
						$search_message_res = mysqli_fetch_assoc($search_message);
						echo "
							<div>
								<span>".$search_message_res['id']."</span>
								<span>".$search_message_res['message']."</span>
								<span>".$search_message_res['finished']."</span>
							</div>
						";
					}
				?>
			</div>
		</div>

		<div id='message'>
			<div>Відіслати повідомлення замовнику</div>
			<div>
				<input type="text" id='message-order-id' placeholder='ID замовлення'> <br>
				<textarea id='order-message' placeholder='Повідомлення'></textarea> <br>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='search-message'>Знайти</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='send-message'>Відіслати</button>
			</div>
		</div>

		<hr>

		<div id='time-shift-request'>
			<div>Запити на зміну часу доставки від водіїв</div>
			<div id='time-shift-request-filter'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='time-shift-request-all'>Всі</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='time-shift-request-no-answer'>Без відповіді</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='time-shift-request-confirmed'>Підтверджені</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='time-shift-request-rejected'>Не підтверджені</button>
			</div>
			<div>
				<span>№ (ID)</span>
				<span>ID водія</span>
				<span>ID замовлення</span>
				<span>Змінений час</span>
				<span>Причина</span>
				<span>Підтвердження</span>
			</div>
			<div id='time-shift-request-list'>
				<?php 
					$search_request = mysqli_query($connection, "SELECT * FROM `Time_shift_request`");
					for ($i = 0; $i < mysqli_num_rows($search_request); $i++) {
						$search_request_res = mysqli_fetch_assoc($search_request);
						echo "
							<div> 
								<span>".$search_request_res['id']."</span>
								<span>".$search_request_res['driver_id']."</span>
								<span>".$search_request_res['order_id']."</span>
								<span>".$search_request_res['updated_time']."</span>
								<span>".$search_request_res['cause']."</span>
								<span>".$search_request_res['confirmation']."</span>
							</div>
						";
					}
				?>
			</div>
		</div>

		<div id='set-request'>
			<div>Відповісти на запит</div>
			<div> 
				<input type='text' id='request-id' placeholder='ID запиту'>
				<form>
					<label id='l-reject' class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="reject">
						<input type="radio" id="reject" class="mdl-radio__button" name="request" style='z-index: 0;'>
						<span class="mdl-radio__label">Відхилити</span>
					</label>
					<label id='l-confirm' class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="confirm">
						<input type="radio" id="confirm" class="mdl-radio__button" name="request" style='z-index: 0;'>
						<span class="mdl-radio__label">Підтвердити</span>
					</label>
				</form>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='send-request'>Відіслати</button>
			</div>
		</div>

		<hr>

		<div id='products'>
			<div>Склад</div> 
			<div id='products-filter'>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='sort-by-id'>Сортування по ID</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='sort-by-name'>Сортування по назві</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='sort-by-quantity'>Сортування по кількості</button>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='sort-by-shelf-life'>Сортування по терміну придатності</button>
			</div>
			<div>
				<span>ID</span>
				<span>Продукти</span>
				<span>Кількість</span>
				<span>Термін придатності</span>
			</div>
			<div id='products-list'>
				<?php 
					$search_products = mysqli_query($connection, "SELECT * FROM `Storage` ORDER BY `Storage`.`id` ASC;");
					for ($i = 0; $i < mysqli_num_rows($search_products); $i++) {
						$search_products_res = mysqli_fetch_assoc($search_products);

						$date = date('d.m.Y');
						$d1 = strtotime( $search_products_res['shelf_life'] );
						$d2 = strtotime( $date );

						if ( $search_products_res['quantity'] <= 0 or $d1 - $d2 <= 0 )
							echo "
								<div>
									<span style='color: red;'><span style='color: red;'> ! </span>".$search_products_res['id']."</span>
									<span style='color: red;'><span style='color: red;'> ! </span>".$search_products_res['product']."</span>
									<span style='color: red;'><span style='color: red;'> ! </span>".$search_products_res['quantity']."</span>
									<span style='color: red;'><span style='color: red;'> ! </span>".$search_products_res['shelf_life']."</span>
								</div>
							";
						elseif ( ($search_products_res['quantity'] <= 20 and $search_products_res['quantity'] > 0) or ($d1 - $d2 < 86400*5 and $d1 - $d2 > 0) ) 
							echo "
								<div>
									<span style='color: #ffa100;'><span style='color: red;'> ! </span>".$search_products_res['id']."</span>
									<span style='color: #ffa100;'><span style='color: red;'> ! </span>".$search_products_res['product']."</span>
									<span style='color: #ffa100;'><span style='color: red;'> ! </span>".$search_products_res['quantity']."</span>
									<span style='color: #ffa100;'><span style='color: red;'> ! </span>".$search_products_res['shelf_life']."</span>
								</div>
							";
						else
							echo "
								<div>
									<span>".$search_products_res['id']."</span>
									<span>".$search_products_res['product']."</span>
									<span>".$search_products_res['quantity']."</span>
									<span>".$search_products_res['shelf_life']."</span>
								</div>
							";
					}
				?>
			</div>
			<div id='warnings'>
				<div>
					Попередження:
				</div>
				<div id='warnings-list'>
					<?php 
						$end_products_warning = '';
						$end_products_notification = '';
						$end_shelf_life_warning = '';
						$end_shelf_life_notification = '';

						$get_products = mysqli_query($connection, "SELECT * FROM `Storage` ORDER BY `Storage`.`id` ASC;");

						for ($i = 0; $i < mysqli_num_rows($get_products); $i++){
							$get_products_res = mysqli_fetch_assoc($get_products);

							$date = date('d.m.Y');
							$d1 = strtotime( $get_products_res['shelf_life'] );
							$d2 = strtotime( $date );

							if ( $get_products_res['quantity'] <= 0 )
								$end_products_warning .= $get_products_res['id'] . " - " . $get_products_res['product'] . "\n";
							elseif ( $get_products_res['quantity'] <= 20 && $get_products_res['quantity'] > 0 )
								$end_products_notification .= $get_products_res['id'] . " - " . $get_products_res['product'] . "\n";

							if ( $d1 - $d2 <= 0 )
								$end_shelf_life_warning .= $get_products_res['id'] . " - " . $get_products_res['product'] . "\n";
							elseif ( $d1 - $d2 < 86400*5 && $d1 - $d2 > 0 )
								$end_shelf_life_notification .= $get_products_res['id'] . " - " . $get_products_res['product'] . "\n";
						}
					?>
					<div style='color: #ffa100;' id='warning-1'>Закінчуються товари</div> 
					<textarea id='t-warning-1' readonly><?php echo $end_products_notification; ?></textarea>

					<div style='color: #ffa100;' id='warning-2'>Закінчується термін придатності у товарів</div> 
					<textarea id='t-warning-2' readonly><?php echo $end_shelf_life_notification; ?></textarea>

					<div style='color: red;' id='warning-3'>Закінчились товари</div> 
					<textarea id='t-warning-3' readonly><?php echo $end_products_warning; ?></textarea>

					<div style='color: red;' id='warning-4'>Закінчився термін придатності у товарів</div> 
					<textarea id='t-warning-4' readonly><?php echo $end_shelf_life_warning; ?></textarea>
				</div>
				<div>
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id='update-warnings'>Оновити</button>
				</div>
			</div>
		</div>
	</div>
</center>
