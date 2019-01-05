var dish_price = 0;
var dish_time = [0, 0, 0];
var time_array = [];
var shopping_basket_button_num = 0;

$(function(){
	// Start wow js
	// start_animate();

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
					// $('#t-location').text(out_info[2]);
					$('#t-message').text(out_info[3]);
					$('#i-date').val(out_info[4]);
					$('#i-summary_time').val(out_info[5]);
					$('#i-delivery_time').val(out_info[6]);
					$('#i-finish_time').val(out_info[7]);
					$('#i-summary_price').val(out_info[8]);

					if (out_info[0]) {
						delete map;
						delete lonLat;
						delete markers;
						
						$('#mapdiv').html('');

						$('#mapdiv').css('width', '95%');
						let map_w = $('#mapdiv').css('width'),
							map_h = Math.round(75 * parseInt(map_w) / 100);

						$('#mapdiv').css('height', 500+'px');

						let coords 	= out_info[2].split(", ");
							lon 	= coords[0],
							lat 	= coords[1];

						map = new OpenLayers.Map("mapdiv");
						map.addLayer(new OpenLayers.Layer.OSM());

						var lonLat = new OpenLayers.LonLat( lon, lat )
						      .transform(
						        new OpenLayers.Projection("EPSG:4326"),
						        map.getProjectionObject() 
						      );
						      
						var zoom=16;

						var markers = new OpenLayers.Layer.Markers( "Markers" );
						map.addLayer(markers);


						markers.addMarker(new OpenLayers.Marker(lonLat));

						map.setCenter (lonLat, zoom);
					}
					
				}
			});
		}

	});

	$('#burger-menu').click(function () {
		if ( $(this).hasClass("blur-overlay") )
			return 0;
		
		$('#shopping-basket-button').toggleClass("shopping-basket-button__active");
		$('#shopping-basket-button-num').toggleClass("shopping-basket-button-num__active");
		$('#go-top-button').toggleClass("go-top-button__active");
	});

	$('#go-top-button').click(function () {
		if ( $(this).hasClass("blur-overlay") )
			return 0;

		$('#burger-menu').trigger('click');
		$("body,html").animate({
			scrollTop:0
		}, 800);
		return false;

		$('#burger-menu').trigger('click');
	})

/* 

			let map_w = $('#mapdiv').css('width'),
				map_h = Math.round(75 * parseInt(map_w) / 100);

			$('#mapdiv').css('height', 500+'px');

			map = new OpenLayers.Map("mapdiv");
			map.addLayer(new OpenLayers.Layer.OSM());

			var lonLat = new OpenLayers.LonLat( 33.3969193, 49.1145028 )
			      .transform(
			        new OpenLayers.Projection("EPSG:4326"),
			        map.getProjectionObject() 
			      );
			      
			var zoom=16;

			var markers = new OpenLayers.Layer.Markers( "Markers" );
			map.addLayer(markers);

			markers.addMarker(new OpenLayers.Marker(lonLat));

			map.setCenter (lonLat, zoom);

*/

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
		if ( $(this).hasClass("blur-overlay") )
			return 0;

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

		$('#shopping-basket-overlay, #shopping-basket').fadeIn(400);
		// $('#header, #content, #shopping-basket-button, #shopping-basket-button-num, #burger-menu, #go-top-button, #footer').css({
		// 	'transition': '0.2s',
		// 	'filter': 'blur(10px)'
		// });
		$('#header, #content, #shopping-basket-button, #shopping-basket-button-num, #burger-menu, #go-top-button, #footer').toggleClass('blur-overlay');
		

			
	});

	$('#shopping-basket-overlay').on('click', function () {
		$('#shopping-basket-overlay, #shopping-basket').fadeOut(400);
		// $('#header, #content, #shopping-basket-button, #shopping-basket-button-num, #burger-menu, #go-top-button, #footer').css({
		// 	'transition': '0.2s',
		// 	'filter': 'none'
		// });
		$('#header, #content, #shopping-basket-button, #shopping-basket-button-num, #burger-menu, #go-top-button, #footer').toggleClass('blur-overlay');
	});

	$('.plus').click(function () {
		var order = $('#order-area textarea').html().split('\n');
		let index = $('.plus').index(this);
		let name  = $('.dish-name').eq(index).text();
		if ($('.dish-count').eq(index).css('display') == 'none')
			$('.dish-count').eq(index).css('display', 'flex');
		$('.dish-count').eq(index).text(count_in_array(order, name));
	});


	$('.minus').click(function () {
		var order = $('#order-area textarea').html().split('\n');
		let index = $('.minus').index(this);
		let name  = $('.dish-name').eq(index).text();
		if (count_in_array(order, name) <= 0 && $('.dish-count').eq(index).css('display') != 'none')
		{
			$('.dish-count').eq(index).css('display', 'none');
		}
		$('.dish-count').eq(index).text(count_in_array(order, name));
	});

});

function push_message(x) {
	if (x == 0)
	{
		$('body').append("<div class='push-message'>Страву видалено з кошика</div>");
		$('.push-message').fadeIn(500);
		$('.push-message').css('display', 'flex');
		setTimeout(function () {
			$('.push-message').fadeOut(500);
		}, 1000);
		setTimeout(function () {
			$('.push-message:first').remove();
		}, 1500);
	}
	else if (x == 1)
	{
		$('body').append("<div class='push-message'>Страву додано до кошика</div>");
		$('.push-message').fadeIn(500);
		$('.push-message').css('display', 'flex');
		setTimeout(function () {
			$('.push-message').fadeOut(500);
		}, 1000);
		setTimeout(function () {
			$('.push-message:first').remove();
		}, 1500);
	} 
}

function add_dish(x, price, time) {
	$('#order-area textarea').append(x+'\n');
	
	// Добавляем цену
	dish_price += price;
	$('#summary-price').val(dish_price.toFixed(2) + ' грн.');

	time_array[ time_array.length ] = time;
	$('#summary-time').val(max_time(time_array));

	// добавляем время
	dish_time[0] += Number(time[0]+time[1]);
	dish_time[1] += Number(time[3]+time[4]);
	dish_time[2] += Number(time[6]+time[7]);
	// $('#summary-time').val(check_time(dish_time[0], dish_time[1], dish_time[2]));

	shopping_basket_button_num++;
	$('#shopping-basket-button-num').attr('data-badge', shopping_basket_button_num);

	// stroka 247

	push_message(1);
}

function remove_dish(x, price, time) {
	var text = $('#order-area textarea').html().split('\n');
	var index = text.indexOf(x);

	if (index != -1) {
		text.splice(index, 1); //удаляем 1 элемент с позиции index
		dish_price -= price; // Снижаем цену если товар в списке заказов
		$('#summary-price').val(Math.abs(dish_price).toFixed(2) + ' грн.');

		time_array.splice( time_array.indexOf(time), 1 );
		$('#summary-time').val(max_time(time_array));

		// снижаем время
		dish_time[0] -= Number(time[0]+time[1]);
		dish_time[1] -= Number(time[3]+time[4]);
		dish_time[2] -= Number(time[6]+time[7]);
		// $('#summary-time').val(check_time(dish_time[0], dish_time[1], dish_time[2]));

		shopping_basket_button_num--;
		$('#shopping-basket-button-num').attr('data-badge', shopping_basket_button_num);

		push_message(0);
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

	// line 257

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

function max_time(time) {
	if (time.length == 0)
		return "00:00:00";
	let time_arr = [];
	for (var i = 0; i < time.length; i++) {
		time_arr[time_arr.length] = Number(time[i][0]+time[i][1])*3600 + Number(time[i][3] + time[i][4])*60 + Number(time[i][6]+time[i][7]);
	}
	
	let mx = time_arr[0];
	for (var i = 1; i < time_arr.length; i++) {
		if ( time_arr[i] > mx ) mx = time_arr[i];
	}

	let h = Math.floor(mx / 3600);
	let m = Math.floor(mx / 60 % 60);
	let s = Math.floor(mx % 3600 % 60);

	return check_time(h, m, s);
}

function count_in_array(array, element) {
	var count = 0;
	array.sort();
	var b_start = false,
		b_stop 	= false;
	for (let i = 0; i < array.length; i++)
	{
		if (array[i] == element)
		{
			if (b_start == false)
				b_start = true;
			count++;
		}
		else if (!b_stop && b_start)
			break;
	}
	return count;
}

function start_animate() {
	$('.dish').attr('data-wow-offset', 0);
	$('.dish').toggleClass('wow fadeInUp');
	$('#shopping-basket-button').toggleClass('wow bounceInUp');
}