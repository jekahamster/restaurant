var dish_price = 0;
var dish_time = [0, 0, 0]
$(function(){
	// Start wow js
	start_animate();

	// PupUP
	$('#entrance').click(function(){
		$('.popup, .popup_overlay').fadeIn(400); //показываем всплывающее окно
	});
	$('.popup_overlay').click(function(){
		$('.popup, .popup_overlay').fadeOut(400); //скрываем всплывающее окно
	});

	// Переворот карт 
	$('#title-2, #title-3').click(function () {
		$('.popup').toggleClass('coup');
	});

	// track
	$('#tracking').click(function () {
		$('.track, .popup_overlay').fadeIn(400);
	});
	$('.popup_overlay').click(function () {
		$('.track, .popup_overlay').fadeOut(400);
	});

	$('#track-button').click(function () {
		var order_pass_pattern = /[\s]/; 
		if (order_pass_pattern.test($("#order-pass").val()) || $("#order-pass").val() == '')
		{
			alert('Поле з паролем не повинно містити пробілів');
		} else {
			$.ajax({
				url: 'subprograms/update-track.php',
				type: 'POST',
				data: ({
					'order-id': $('#order-id').val(),
					'order-pass': $('#order-pass').val()
				}),
				success: function (data) {
					var out_info = data.split('||');
					$('#t-order').text(out_info[0]);
					$('#t-address').text(out_info[1]);
					$('#t-location').text(out_info[2]);
					$('#t-message').text(out_info[3]);
					$('#i-date').val(out_info[4]);
					$('#i-summary_time').val(out_info[5]);
					$('#i-delivery_time').val(out_info[6]);
					$('#i-finish_time').val(out_info[7]);
					$('#i-summary_price').val(out_info[8]);
				}
			});
		}
	});



	// Проверка на ошибки при регистрации
	var username_pattern = /[0-9]/; // не должен содержать цифры
	var login_pattern = /^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/; // должен содержать вот это
	var password_pattern = /[\s]/; // не должен содержать пробелы
	var key_pattern = /[\s]/; // не должен содержать пробелы
	$("#back-card-block-submit input[type='submit']").click(function () {
		var error_text = '';
		var errors = 0;
		if (username_pattern.test($("#back-card-block-username input[type='text']").val()))
		{
			errors++;
			error_text += 'Ім\'я користувача не повинно містити цифри!\n';
		}
		if ($.trim($("#back-card-block-username input[type='text']").val()) == '') {
			errors++;
			error_text += 'Ім\'я користувача повинно бути заповненим!\n';
		}
		if (!login_pattern.test($("#back-card-block-login input[type='text']").val()))
		{
			errors++;
			error_text += 'Неправильно введений E-Mail!\n';
		}
		if (password_pattern.test($("#back-card-block-password input[type='password']").val()) || $("#back-card-block-password input[type='password']").val() == '')
		{
			errors++;
			error_text += 'Пароль не повинен містити пробіли\n';
		}
		if ( $("#back-card-block-password input[type='password']").val() != $("#back-card-block-repeat-password input[type='password']").val() )
		{
			errors++;
			error_text += 'Введені паролі не співпадають!\n';
		}
		if (key_pattern.test($("#back-card-block-key input[type='text']").val()) || $("#back-card-block-key input[type='text']").val() == '')
		{
			errors++;
			error_text += 'Ключ не повинен містити пробіли\n';
		}

		if (errors == 0) {
			$("#back-card-block-username input[type='text']").val( $.trim($("#back-card-block-username input[type='text']").val()) );
			$(".register").attr('action', 'register.php');
		}
		else 
			alert(error_text);
	});

	// Всплывающий список заказаных блюд (shopping-basket)
	$('#shopping-basket-button').on('click', function () {

		let dishes = $('#order-area textarea').html().split("\n");
		let dishes_count = [];
		// Удяляем повторы, считаем количество
		for (var i = 0; i < dishes.length; i++)
		{	
			let count = 1; 	// начальная позиция 1 так как в списке уже есть как минимум 1
			for (var j = i+1; j < dishes.length; j++)
			{
				if ( dishes[j] == dishes[i] )
				{
					dishes.splice(j, 1);
					count++; // сколько раз удалили, столько и повторов
					j--; // зацикливаем что бы отыскать все повторы
				} 
			}

			dishes_count[ dishes_count.length ] = count;
		}

		$('#shopping-basket-list').html('');

		for (var i = 0; i < dishes.length-1; i++)
		{
			$('#shopping-basket-list').append("<tr><td>"+dishes_count[i]+"</td><td>"+dishes[i]+"</td></tr>");
		}

		$('#shopping-basket-overlay').fadeIn(400);
		$('#header, #content').css({
			'transition': '0.4s',
			'filter': 'blur(10px)'
		});

		
		$('#shopping-basket-button').toggleClass('shopping-basket-button--active');
		$('#shopping-basket').toggleClass('shopping-basket--active');

			
	});

	$('#shopping-basket-overlay').on('click', function () {
		$('#shopping-basket-overlay').fadeOut(400);
		$('#header, #content').css({
			'transition': '0.4s',
			'filter': 'blur(0px)'
		});

		$('#shopping-basket-button').toggleClass('shopping-basket-button--active');
		$('#shopping-basket').toggleClass('shopping-basket--active');	
	});


});

function add_dish(x, price, time) {
	$('#order-area textarea').append(x+'\n');
	
	// Добавляем цену
	dish_price += price;
	$('#summary-price').val(dish_price.toFixed(2) + ' грн.');

	// добавляем время
	dish_time[0] += Number(time[0]+time[1]);
	dish_time[1] += Number(time[3]+time[4]);
	dish_time[2] += Number(time[6]+time[7]);
	$('#summary-time').val(check_time(dish_time[0], dish_time[1], dish_time[2]));
}

function remove_dish(x, price, time) {
	var text = $('#order-area textarea').html().split('\n');
	var index = text.indexOf(x);

	if (index != -1) {
		text.splice(index, 1); //удаляем 1 элемент с позиции index
		dish_price -= price; // Снижаем цену если товар в списке заказов
		$('#summary-price').val(dish_price.toFixed(2) + ' грн.');

		// снижаем время
		dish_time[0] -= Number(time[0]+time[1]);
		dish_time[1] -= Number(time[3]+time[4]);
		dish_time[2] -= Number(time[6]+time[7]);
		$('#summary-time').val(check_time(dish_time[0], dish_time[1], dish_time[2]));
	}
	$('#order-area textarea').html('');
	for (var i = 0; i < text.length; i++)
		$('#order-area textarea').append(text[i]+'\n');
	// удаляем переносы строк
	text = $('#order-area textarea').html().split('\n');
	while (text.indexOf("") != -1) {
		text.splice(text.indexOf(""), 1);
	}
	$('#order-area textarea').html('');
	for (var i = 0; i < text.length; i++)
		$('#order-area textarea').append(text[i]+'\n');

}

function check_order() {
	if ( $('#order-area textarea').html().split('\n').length > 1)
		 $('#order-form form').attr('action', 'order.php');
}


function check_time(h, m, s) {
	if (s > 59) {
		m += Math.floor(s / 60);
		s = s - Math.floor(s / 60)*60;
	}
	if (m > 59) {
		h += Math.floor(m / 60);
		m = m - Math.floor(m / 60)*60;
	}
	var hh, mm, ss;
	if (h < 10) hh = '0'+h; else hh = h;
	if (m < 10) mm = '0'+m; else mm = m;
	if (s < 10) ss = '0'+s; else ss = s;
	var str = hh+':'+mm+':'+ss;
	return str;

}

function start_animate() {
	$('.dish').attr('data-wow-offset', 0);
	$('.dish').toggleClass('wow fadeInUp');
	$('#shopping-basket-button').toggleClass('wow bounceInUp');
}