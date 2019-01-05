<?php 
    if ( 1 && !$user['id'] ) {
        header("Location: https://eatforyou.tk/");
        exit;
    }
?>
<!-- <meta name="viewport" content="width=device-width, initial-scale = 1"> -->
<link rel="stylesheet" href="../libs/mdl/icon.css">
<link rel="stylesheet" href="../libs/mdl/material.indigo-pink.min.css">
<script defer src="../libs/mdl/material.min.js"></script>
<link rel="stylesheet" type="text/css" href="driver.css">
<script type="text/javascript">
	$(function () {
		
		update_page();
		
		$('button').css({
			'text-transform': 'none',
			'line-height': 'normal'
		});

		//Работа или отдых
		$('#start_or_stop').on('click', function () {
			$.ajax({
				url: 'subprograms/work.php', 
				type: 'POST',
				data: ({
					'driver-id': $('#userid').text(),
					'driver-name': $('#username').text(),
					'mode': $('#work-mode').text()
				}),
				success: function (data) {
					if (data == 'work'){ 
						$("#work div:nth-child(1)").html("<span id='work-mode' style='color: #007218;'>Праця</span>");
						$("#start_or_stop").text('Піти на відпочинок');
					} else if (data == 'relax') {
						$("#work div:nth-child(1)").html("<span id='work-mode' style='color: #ff3262;'>Відпочинок</span>");
						$("#start_or_stop").text('Розпочати роботу');
					}
				}
			});
		});
		// Обновление заказа
		$('#update-order').on('click', function () {
			$.ajax({
				url: 'subprograms/update-order.php', 
				type: 'POST',
				data: ({
					'driver-id': $('#userid').text()
				}),
				success: function (data) {
					// $('#order div:nth-child(2)').html('');
					$('#order div:nth-child(2) div').html(data);
					if ( $("#order div:nth-child(2) div input[type='text']").val() == '') {
						$('#finish-order div div').text('Доставку завершено');
						$('#finish-order div div').animate({
							'color': 'red'
						}, 500);
					} else {
						$('#finish-order div div').text('Доставка триває');
						$('#finish-order div div').animate({
							'color': 'green'
						}, 500);
					}
				}
			});

			$.ajax({
				url: 'subprograms/update-phone-number_driver.php',
				type: 'POST',
				data: ({
					'userid': $('#userid').text()
				}),
				success: function (data) {
					$('#phone-number').val(data);				}
			});
		});

		// Обновление времени 
		function update_time() {
			$.ajax({
				url: 'subprograms/update-time.php',
				type: 'POST',
				data: ({
					'driver-id': $('#userid').text()
				}),
				success: function (data) {
					var out = data.split('||');
					$('#t-input1').val(out[0]);
					$('#t-input2').val(out[1]);
					$('#t-area1').val(out[2]);
					$('#t-input3').val(out[3]);

				}
			});
		}
		$('#update-time').on('click',update_time);

		// Запрос на смену времени
		$('#change-time').on('click', function () {
			if ( $('#order div:nth-child(2) textarea').text() != '') {
				$.ajax({
					url: 'subprograms/change-time.php',
					type: 'POST',
					data: ({
						'driver-id': $('#userid').text(),
						'changed-time': $('#t-input2').val(),
						'order-id': $("#order div:nth-child(2) div input[type='text']").val(),
						'change-cause': $('#t-area1').val()
					}),
					success: function (data) {
						$('#t-area1, #t-input2').animate({
							'border-color': '#00ff55'
						}, 500);
						setTimeout(function () {
							$('#t-area1, #t-input2').animate({
							'border-color': 'silver'
						}, 500);
						}, 1000);
					}

				});
			} else {
				$('#t-area1, #t-input2').animate({
					'border-color': '#ff2b2b'
				}, 500);
				setTimeout(function () {
					$('#t-area1, #t-input2').animate({
					'border-color': 'silver'
				}, 500);
				}, 1000);
			}
		});

		// Обновляем местоположение

		$('#update-location').on('click', function () {
			$.ajax({
				url: 'subprograms/update-location.php',
				type: 'POST', 
				data: ({
					'driver-id': $('#userid').text()
				}),
				success: function (data) {
					$('#l-area1').val(data);
				}
			});
		});

		// Меняем местоположение


		$('#upgrade-location').on('click', function () {
			
			var lat, lon;

			navigator.geolocation.getCurrentPosition(function (position) {
				lat = position.coords.latitude;
				lon = position.coords.longitude;

				$('#l-area1').val(lon+', '+lat);
				$.ajax({
					url: 'subprograms/upgrade-location.php',
					type: 'POST', 
					data: ({
						'driver-id': $('#userid').text(),
						'location': lon+', '+lat
					}),
					success: function (data) {
						if (data == "Error") 
							alert("Неприпустиме значення!");
					}
				});
				
			}, function () {
				$('#l-area1').val('В дорозі');
				$('#l-area1').animate({
					'border-color': '#ff2b2b'
				}, 500);
				setTimeout(function () {
					$('#l-area1').animate({
					'border-color': 'silver'
				}, 500);
				}, 1000);

				$('#l-area1').val('В дорозі');
				$.ajax({
					url: 'subprograms/upgrade-location.php',
					type: 'POST', 
					data: ({
						'driver-id': $('#userid').text(),
						'location': 'В дорозі'
					}),
					success: function (data) {
					    alert(data);
						if (data == "Error") 
							alert("Неприпустиме значення!");
					}
				});
			});

		});

		//Конец заказа 
		$('#finish').on('click', function () {
			if ( $('#finish-order div div').text() == 'Доставка триває' ) {
				var conf = confirm('Ви дійсно хочете завершити доставку? \nПовернути вас до замовлення зможе тільки оператор');
				if (conf == true) 
				{
					$.ajax({
						url: 'subprograms/finish-order.php',
						type: 'POST',
						data: ({
							'driver-id': $('#userid').text()
						}),
						success: function () {
							location.reload();
						}
					});
				}
			}
		});
	});
	
	function update_page() {
	    if ( $('#work-mode').text() != 'Відпочинок' && $('#order > div:nth-child(2) > div > input').val() != false) {
	        $('#upgrade-location').trigger('click');
	    }
	    
	    
	    setTimeout('update_page()',100000);
    }
</script>
<center id='background-block'>
	<span class='user-hide' id='userid'><?php echo $user['id']; ?></span>
	<span class='user-hide' id='username'><?php echo $user['Username']; ?></span>

	<div id='go-back' class='wow bounceInLeft'><a href='/'><img src="/img/back.png"></a></div>
	<div id='content'>
		<div id='welcome'>З поверненням, <?php echo $user['Username']; ?>!</div>
		<div id='work'>
			<?php 
				$check_work = mysqli_query($connection, "SELECT * FROM `Drivers` WHERE `driver_id` = '".$user['id']."';");
				if (mysqli_num_rows($check_work) == 0) 
				{
					echo "<div><span id='work-mode' style='color: #ff3262;'>Відпочинок</span></div>";
					echo "<div><button class='mdl-button mdl-js-button mdl-button--raised' id='start_or_stop'>Розпочати роботу</button></div>";
				} else {
					echo "<div><span id='work-mode' style='color: #007218;'>Праця</span></div>";
					echo "<div><button class='mdl-button mdl-js-button mdl-button--raised' id='start_or_stop'>Піти на відпочинок</button></div>";
				}	
			?>
		</div>
		<div id='order'> 
			<div>Замовлення</div>
			<div>
				<div>
					<?php 
						$order_for_driver = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$user['id']."' AND `finished` = 'False';");
						$search_result = mysqli_fetch_assoc($order_for_driver);
						if (mysqli_num_rows($order_for_driver) == 0)
							echo "
								<span>ID</span>
								<span>Адреса</span>

								<input type=\"text\" value='' readonly>
								<textarea readonly></textarea>
							";
						else 
							echo "
								<span>Id</span>
								<span>Address</span>
								
								<input type=\"text\" value='".$search_result['id']."' readonly>
								<textarea readonly>".$search_result['address']."</textarea>
						";
					?>
				</div>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='update-order'>Оновити</button>
			</div>
			<div id='phone'>
				<?php 
					$phone_number = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$user['id']."' AND `finished` = 'False';");
					$phone_number_res = mysqli_fetch_assoc($phone_number);
				?>
				<label>Номер телефону:</label><br>
				<input type="text" id='phone-number' value="<?php echo $phone_number_res['phone']; ?>" readonly>
			</div>
		</div>
		<div id='order-settings'>
			<div id='order-time'>
				<div>Доставити за</div>
				<div>
					<?php 
						$delivery_time = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$user['id']."' AND `finished` = 'False';");
						$time_res = mysqli_fetch_assoc($delivery_time);
						if (mysqli_num_rows($delivery_time) == 0)
							echo "<input id='t-input1' type='text' value='' readonly>";
						else echo "<input id='t-input1' type='text' value='".$time_res['delivery_time']."' readonly>";
					?>
					<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='update-time'>Оновити</button>
				</div>
				<div>Запит на зміну часу доставки</div>
				<div>
					<?php 
						$update_order = mysqli_query($connection, "SELECT * FROM `Time_shift_request` WHERE `driver_id` = '".$user['id']."' AND `confirmation` = 'No answer';");
						$update_res = mysqli_fetch_assoc($update_order);
						if (mysqli_num_rows($update_order) == 0)
							echo "<input id='t-input2' type='text' value='' placeholder='00:00:00'>
							<textarea placeholder='Причина зміни часу' id='t-area1'></textarea>";
						else echo "<input id='t-input2' type='text' value='".$update_res['updated_time']."' placeholder='00:00:00'>
							<textarea placeholder='Причина зміни часу' id='t-area1'>".$update_res['cause']."</textarea>";
					?>
					<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='change-time'>Відіслати запит на зміну часу доставки</button>

				</div>
				<div>Доставити до: 
					<?php 
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
						$sum_time = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$user['id']."' AND `finished` = 'False';");
						$sum_time_res = mysqli_fetch_assoc($sum_time);
						if (mysqli_num_rows($sum_time) == 0) 
							echo "<input id='t-input3' type='text' value='' readonly>";
						else {
							$st = $sum_time_res['summary_time']; // summary time
							$dt = $sum_time_res['delivery_time']; // delivery time
							$d = substr($sum_time_res['date'], 11); // order date

							// time sum
							$s_h = (int) substr($st, 0, 2) + (int) substr($dt, 0, 2) + (int) substr($d, 0, 2);
							$s_m = (int) substr($st, 3, 2) + (int) substr($dt, 3, 2) + (int) substr($d, 3, 2);
							$s_s = (int) substr($st, 6, 2) + (int) substr($dt, 6, 2) + (int) substr($d, 6, 2);
							echo "<input id='t-input3' type='text' value='".check_time($s_h, $s_m, $s_s)."' readonly>";
							$set_finish_time = mysqli_query($connection, "UPDATE `Orders` SET `finish_time` = '".check_time($s_h, $s_m, $s_s)."' WHERE `driver_id` = '".$user['id']."' AND `finished` = 'False';");
						}	
					?>				
			</div>
			<div id='order-location'>
				<div>Місцезнаходження:</div>
				<div> 
					<?php 
						$search_location = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$user['id']."' AND `finished` = 'False';");
						$search_location_res = mysqli_fetch_assoc($search_location);
						if (mysqli_num_rows($search_location) == 0) 
							echo "<textarea id='l-area1'></textarea>";
						else
							echo "<textarea id='l-area1'>".$search_location_res['location']."</textarea>";

					?>
					
					<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='upgrade-location'>Відіслати</button>
					<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='update-location'>Оновити</button>
				</div>
			</div>
		</div>
		<div id='finish-order'>
			<div>
				<?php 
					$search_finish = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `driver_id` = '".$user['id']."' AND `finished`= 'False';");
					$search_finish_res = mysqli_fetch_assoc($search_finish);
					if (mysqli_num_rows($search_finish) == 0)
						echo "<div style='color: red;'>Доставку завершено</div>";
					else echo "<div style='color: green;'>Доставка триває</div>";
				?>
				<button class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect' id='finish'>Завершити</button>
			</div>
		</div>
	</div>
</center>