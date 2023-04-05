<?php 
    if ( 1 && !$user['id'] ) {
        header("Location: https://eatforyou.tk/");
        exit;
    }
?>
<link rel="stylesheet" href="../libs/mdl/icon.css">
<link rel="stylesheet" href="../libs/mdl/material.indigo-pink.min.css">
<script defer src="../libs/mdl/material.min.js"></script>
<link rel="stylesheet" href="../libs/mdl2/material.css">
<link rel="stylesheet" type="text/css" href="admin.css">
<script>
	var set_dish_name = null;
	var set_dish_class = null;
	var set_dish_time = null;
	var set_dish_price = null;
	var set_dish_ingredients = null;
	var set_dish_quantity = null;
	var date_statistic_list = [1, 2];
	var data_statistic_1 = null;
	var month_data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

	var dishes_sort_button	= 1;
		storage_sort_button = 1,
		order_sort_button 	= 1;

	function get_dish_info(id) {
		$.ajax({
			url: 'subprograms/get-dish-info.php', 
			type: 'POST',
			data: ({
				'id': id
			}),
			success: function (data) {
				var dish_info = data.split("||");
				var products_list = dish_info[4].split(", ");
				var quantity_list = dish_info[5].split(", ");

				$('#name-info').val(dish_info[0]);
				$('#class-info').val(dish_info[1]);
				$('#time-info').val(dish_info[2]);
				$('#price-info').val(dish_info[3]);

				$('#dish-info-product').html('');
				for (var i = 0; i < products_list.length; i++) {
					$('#dish-info-product').append("<div> <input type='text' class='products-info' value='"+products_list[i]+"'> <input type='number' min='0.1' class='quantity-info' value='"+quantity_list[i]+"' step='0.1'> </div>");
				}
				$('#id-info').html(id);
				
			}
		});
	}

	function get_selected(stack, data) {
		let selected_list = [];
		for (var i = 0; i < $('.'+stack).length; i++)
			if ( $('.'+stack).eq(i).prop("checked") )
				selected_list[ selected_list.length ] = $('.'+stack).eq(i).attr(data);

		return selected_list;
	}

	function check_min(id) {
		if ( $('#'+id).val() < 0 )
			$('#'+id).val(0);
	}

	function statistic_1_change() {
		$('#build-statistic-1').trigger('click');
	}

	function update_product_info() {
		$.ajax({
			url: 'subprograms/update-product-info.php',
			type: 'POST',
			data: ({
				'id': $('#apply-to-product').val()
			}),
			success: function (data) {
				let product_info = data.split("||");
				$('#update-product-name').val(product_info[0]);
				$('#update-product-quantity').val(product_info[1]);
				$('#update-product-shelf-life').val(product_info[2]);
			}
		});
	}

	function get_month_data(x) {
		$.ajax({
			url: 'subprograms/get-statistic-2-data.php',
			type: 'POST', 
			async: false,
			data: ({
				'year': $('#statistic-2-year').val(),
				'month' : x
			}),
			success: function (data) {
				month_data[Number(x)-1] = Number(data);
			}
		});
	}

	function drawww() {
		var ctx = document.getElementById('chart-2').getContext('2d');
		Chart.defaults.global.hover.mode = 'nearest';
		var chart = new Chart(ctx, {
		    type: 'line',

		    data: {
		        labels: ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
		        datasets: [{
		            label: "Замовлено страв за рік",
		            // backgroundColor: 'rgb(255, 99, 132)',
		            borderColor: 'rgb(255, 99, 132)',
		            data: month_data,
		        }],
		    },
		    options: {
		    	tootlips: {
		    		enabled: false
		    	}	
		    }
		});
	}

	function update_page() {
	    $("#dishes-filter > button:nth-child("+dishes_sort_button+")").trigger('click');
	    $("#products-filter > button:nth-child("+storage_sort_button+")").trigger('click');
	    $("#orders-filter > button:nth-child("+order_sort_button+")").trigger('click');
	    // $("#build-statistic-1").trigger('click');
	    // $("#build-statistic-2").trigger('click');
	    
	    setTimeout('update_page()', 30000);
    }

	$(function () {

		update_page();

		$('button').css({
			'text-transform': 'none',
			'line-height': 'normal'
		});
		

		$('#dish-sort-by-id').click(function () {
			$.ajax({
				url: 'subprograms/update-dishes-list.php',
				type: 'POST',
				data: ({
					'sort-by': 'id'
				}),
				success: function (data) {
					$('#out-dishes-list').html(data);
					dishes_sort_button = 1;
				}
			});
		});

		$('#dish-sort-by-name').click(function () {
			$.ajax({
				url: 'subprograms/update-dishes-list.php',
				type: 'POST',
				data: ({
					'sort-by': 'name'
				}),
				success: function (data) {
					$('#out-dishes-list').html(data);
					dishes_sort_button = 2;
				}
			});
		});

		$('#dish-sort-by-class').click(function () {
			$.ajax({
				url: 'subprograms/update-dishes-list.php',
				type: 'POST',
				data: ({
					'sort-by': 'class'
				}),
				success: function (data) {
					$('#out-dishes-list').html(data);
					dishes_sort_button = 3;
				}
			});
		});

		$('#dish-sort-by-time').click(function () {
			$.ajax({
				url: 'subprograms/update-dishes-list.php',
				type: 'POST',
				data: ({
					'sort-by': 'time'
				}),
				success: function (data) {
					$('#out-dishes-list').html(data);
					dishes_sort_button = 4;
				}
			});
		});

		$('#dish-sort-by-price').click(function () {
			$.ajax({
				url: 'subprograms/update-dishes-list.php',
				type: 'POST',
				data: ({
					'sort-by': 'price'
				}),
				success: function (data) {
					$('#out-dishes-list').html(data);
					dishes_sort_button = 5;
				}
			});
		});

		$('#dishes-delete-button').click(function () {
			var selected_checkbox = [];
			var dishes_id_list = [];

			for (var i = 0; i < $('#out-dishes-list tr').length; i++)
				if ( $('#out-dishes-list tr td label input[type="checkbox"]').eq(i).prop("checked") == true ) {
					selected_checkbox[ selected_checkbox.length ] = i+1;
					dishes_id_list[dishes_id_list.length] = $('#out-dishes-list tr:nth-child('+(i+1)+') td:nth-child(2)').text();
				}

			$.ajax({
				url: 'subprograms/delete-dishes.php',
				type: 'POST', 
				data: ({
					'dishes-id-list': dishes_id_list
				}),
				success: function (data) {
					$('#out-dishes-list').html(data);
					$("#dishes-filter > button:nth-child("+dishes_sort_button+")").trigger('click');
				}
			});

		});

		$('#dishes-append-button').click(function () {

			if ( $('#edit-dish').css('heigth') != 0 )
				$('#edit-dish').css({
					'transition': '0.2s',
					'border': '0px solid rgba(0,0,0,.12)',
					'height': '0px',
					'padding-top': '0px'
				});

			if ( $('#append-dish').css('height') == '0px' ) 
			{
				$('#append-dish').css({
					'transition': '0.2s',
					'border': '1px solid rgba(0,0,0,.12)',
					'height': '506px',
					'padding-top': '20px'
				});
			}
			else 
			{
				$('#append-dish').css({
					'transition': '0.2s',
					'border': '0px solid rgba(0,0,0,.12)',
					'height': '0px',
					'padding-top': '0px'
				});
			}

		});

		$('#dish-settings-next').click(function () {

			var space_pattern = /[\s]/;
			if ( $("#settings-list-1 div:nth-child(5) input[type='text']").val() != '' ) {
				set_dish_ingredients = $("#settings-list-1 div:nth-child(5) input[type='text']").val().split(", ");
				$('#settings-list-2').html('');
			}
			else {
				set_dish_ingredients = [];
				$('#settings-list-2').html("<span style='font-size: 2em; display: block; padding-top: 15%;'>Необхідно вказати інгредієнти з яких буде складатися страва</span>");
			}

			for (var i = 0; i < set_dish_ingredients.length; i++)
				$('#settings-list-2').append("<div class='settings-list-2-block'><label class='number-of-products-label'>"+set_dish_ingredients[i]+":</label> <br><input class='number-of-products' min='0.1' type='number' step='0.1'></div>"); 

			$('#settings-page-1').css({
				'transition': '0.2s',
				'width': '0%'
			});
			$('#settings-page-2').css({
				'transition': '0.2s',
				'width': '99%'
			});

			set_dish_name = $('#set-dish-name').val();
			set_dish_class = $('#set-dish-class').val();
			set_dish_time = $('#set-dish-time').val();
			set_dish_price = $('#set-dish-price').val();

		});

		$('#dish-settings-back').click(function () {
			$('#settings-page-1').css({
				'transition': '0.2s',
				'width': '99%'
			});
			$('#settings-page-2').css({
				'transition': '0.2s',
				'width': '0%'
			});
		});

		$('#dish-settings-next2').click(function () {
			set_dish_quantity = [];
			for (var i = 0; i < $('.number-of-products').length; i++) {
				if ( $('.number-of-products').eq(i).val() < 0.1 ) {
					alert('Мінімальна кількість 0.1');
					return 0;
				}

				set_dish_quantity[ set_dish_quantity.length ] = $('.number-of-products').eq(i).val();
			}

			$('#settings-page-2').css({
				'transition': '0.2s',
				'width': '0%'
			});
			$('#settings-page-3').css({
				'transition': '0.2s',
				'width': '98%'
			});


			$('#append-final-name').val( set_dish_name );
			$('#append-final-class').val( set_dish_class );
			$('#append-final-time').val( set_dish_time );
			$('#append-final-price').val( set_dish_price );
			$('#append-final-ingredients').val( set_dish_ingredients.join(", ") );
			$('#append-final-quantity').val( set_dish_quantity.join(", ") );

		});

		$('#dish-settings-back2').click(function () {
			$('#settings-page-2').css({
				'transition': '0.2s',
				'width': '98%'
			});
			$('#settings-page-3').css({
				'transition': '0.2s',
				'width': '0%'
			});
		});

		$('#dish-settings-done').click(function () {
			$('#append-dish').css({
				'transition': '0.2s',
				'border': '0px solid rgba(0,0,0,.12)',
				'height': '0px',
				'padding-top': '0px'
			});

			$('#settings-page-1').css({
				'width': '99%'
			});
			$('#settings-page-2').css({
				'width': '0%'
			});
			$('#settings-page-3').css({
				'width': '0%'
			});

			$.ajax({
				url: 'subprograms/append-dish.php',
				type: 'POST',
				data: ({
					'dish-name': $('#append-final-name').val(),
					'dish-class': $('#append-final-class').val(),
					'dish-time': $('#append-final-time').val(),
					'dish-price': $('#append-final-price').val(),
					'dish-ingredients': $('#append-final-ingredients').val(),
					'dish-quantity': $('#append-final-quantity').val()
				}),
				success: function (data) {
					$("#dishes-filter > button:nth-child("+dishes_sort_button+")").trigger('click');
					if (data != '')
						alert(data); 
				}
			});


			$('#set-dish-name').val('');
			$('#set-dish-class').val('Basic');
			$('#set-dish-time').val('');
			$('#set-dish-price').val('');
			$('#set-dish-ingredients').val('');

			set_dish_name = null;
			set_dish_class = null;
			set_dish_time = null;
			set_dish_price = null;
			set_dish_ingredients = null;
			set_dish_quantity = null;
		});

		$('#dishes-edit-button').click(function () {

			if ( $('#append-dish').css('height') != 0 ) {
				$('#append-dish').css({
					'transition': '0.2s',
					'border': '0px solid rgba(0,0,0,.12)',
					'height': '0px',
					'padding-top': '0px'
				});
			}

			var dishes_id_list = [];
			var class_list = [];
			var name_list = [];

			for (var i = 0; i < $('#out-dishes-list tr').length; i++)
				if ( $('#out-dishes-list tr td label input[type="checkbox"]').eq(i).prop("checked") == true ) {
					dishes_id_list[dishes_id_list.length] = $('#out-dishes-list tr:nth-child('+(i+1)+') td:nth-child(2)').text();
					class_list[ class_list.length ] = $('#out-dishes-list tr:nth-child('+(i+1)+') td:nth-child(4)').text();
					name_list[ name_list.length ] = $('#out-dishes-list tr:nth-child('+(i+1)+') td:nth-child(3)').text();
				}


			$('#selected-dishes-list').html('');
			for (var i = 0; i < class_list.length; i++) {
				$('#selected-dishes-list').append("<div id='dish-"+dishes_id_list[i]+"' data-dish-id='"+dishes_id_list[i]+"' class='selected-dish-card' onclick=\"get_dish_info("+dishes_id_list[i]+")\"> <div class='selected-dish-name'>"+name_list[i]+"</div> <div class='selected-dish-image'> <img src='../img/dishes/"+class_list[i]+"/"+dishes_id_list[i]+".jpg' alt='"+name_list[i]+"'> </div> </div>");
			}

			$('#name-info').val('');
			$('#class-info').val('');
			$('#time-info').val('');
			$('#price-info').val('');
			
			$('#dish-info-product').html('');
				$('#dish-info-product').append("<div> <input type='text' class='products-info'> <input type='number' min='0.1' class='quantity-info' step='0.1'> </div>");

			if ( $('#edit-dish').css('height') == '0px' ) 
			{
				$('#edit-dish').css({
					'transition': '0.2s',
					'border': '1px solid rgba(0,0,0,.12)',
					'height': '846px',
					'padding-top': '20px'
				});
			}
			else 
			{
				$('#edit-dish').css({
					'transition': '0.2s',
					'border': '0px solid rgba(0,0,0,.12)',
					'height': '0px',
					'padding-top': '0px'
				});
			}

		});

		$('#dish-edit-button-refresh').click(function () {
			var dishes_id_list = [];
			var class_list = [];
			var name_list = [];

			for (var i = 0; i < $('#out-dishes-list tr').length; i++)
				if ( $('#out-dishes-list tr td label input[type="checkbox"]').eq(i).prop("checked") == true ) {
					dishes_id_list[dishes_id_list.length] = $('#out-dishes-list tr:nth-child('+(i+1)+') td:nth-child(2)').text();
					class_list[ class_list.length ] = $('#out-dishes-list tr:nth-child('+(i+1)+') td:nth-child(4)').text();
					name_list[ name_list.length ] = $('#out-dishes-list tr:nth-child('+(i+1)+') td:nth-child(3)').text();
				}


			$('#selected-dishes-list').html('');
			for (var i = 0; i < class_list.length; i++) {
				$('#selected-dishes-list').append("<div id='dish-"+dishes_id_list[i]+"' data-dish-id='"+dishes_id_list[i]+"' class='selected-dish-card' onclick=\"get_dish_info("+dishes_id_list[i]+")\"> <div class='selected-dish-name'>"+name_list[i]+"</div> <div class='selected-dish-image'> <img src='../img/dishes/"+class_list[i]+"/"+dishes_id_list[i]+".jpg' alt='"+name_list[i]+"'> </div> </div>");
			}

			$('#name-info').val('');
			$('#class-info').val('');
			$('#time-info').val('');
			$('#price-info').val('');
			
			$('#dish-info-product').html('');
				$('#dish-info-product').append("<div> <input type='text' class='products-info'> <input type='number' min='0.1' class='quantity-info' step='0.1'> </div>");
		});

		$('#dish-edit-button-done').click(function () {
			var new_name 	 = $('#name-info').val(),
				new_class 	 = $('#class-info').val(),
				new_time 	 = $('#time-info').val(),
				new_price	 = $('#price-info').val(),
				new_products = [],
				new_quantity = [];

			for (var i = 0; i < $('.products-info').length; i++) {
				new_products[ new_products.length ] = $('.products-info').eq(i).val();
				new_quantity[ new_quantity.length ] = $('.quantity-info').eq(i).val();
			}

			$.ajax({
				url: 'subprograms/upgrade-dishes.php', 
				type: 'POST',
				data: ({
					'id': $('#id-info').text(),
					'new-name': new_name,
					'new-class': new_class,
					'new-time': new_time,
					'new-price': new_price,
					'new-products': new_products,
					'new-quantity': new_quantity
				}),
				success: function (data) {
					$("#dishes-filter > button:nth-child("+dishes_sort_button+")").trigger('click'); 
				}
			});

			
		});

		$('#key-button-refresh').click(function () {
			$.ajax({
				url: 'subprograms/update-keys.php',
				type: 'POST',
				success: function (data) {
					var keys = data.split(', ');
					$('#admin-key').val(keys[0]);
					$('#operator-key').val(keys[1]);
					$('#driver-key').val(keys[2]);
				}
			});
		});

		$('#key-button-done').click(function () {
			$.ajax({
				url: 'subprograms/upgrade-keys.php',
				type: 'POST',
				data: ({
					'admin-key': $('#admin-key').val(),
					'operator-key': $('#operator-key').val(),
					'driver-key': $('#driver-key').val()
				})
			});
		});


		// Stroage

		function get_products(data) {
			$('#out-products-list').html(data);
		}

		$('#product-sort-by-id').click(function () {
			$.ajax({
				url: 'subprograms/update-products-list_admin.php',
				type: 'POST',
				data: ({
					'sort-by': 'id'
				}),
				success: get_products
			});
			storage_sort_button = 1;
		});

		$('#product-sort-by-name').click(function () {
			$.ajax({
				url: 'subprograms/update-products-list_admin.php',
				type: 'POST',
				data: ({
					'sort-by': 'name'
				}),
				success: get_products
			});
			storage_sort_button = 2;
		});

		$('#product-sort-by-quantity').click(function () {
			$.ajax({
				url: 'subprograms/update-products-list_admin.php',
				type: 'POST',
				data: ({
					'sort-by': 'quantity'
				}),
				success: get_products
			});
			storage_sort_button = 3;
		});

		$('#product-sort-by-shelf-life').click(function () {
			$.ajax({
				url: 'subprograms/update-products-list_admin.php',
				type: 'POST',
				data: ({
					'sort-by': 'shelf-life'
				}),
				success: get_products
			});
			storage_sort_button = 4;
		});



		$('#storage-delete-button').click(function () {
			let select_products = get_selected('storage-checkbox', 'data-product-id');
			$.ajax({
				url: 'subprograms/delete-product.php',
				type: 'POST',
				data: ({
					'product-id-list': select_products
				}),
				success: function (data) {
					$("#products-filter > button:nth-child("+storage_sort_button+")").trigger('click');
				}
			});



		});

		$('#storage-edit-button').click(function () {
			if ( $('#append-product').css('display') != 'none')
				$('#append-product').hide();

			if ( $('#edit-product').css('display') == 'none' ) {
				$.ajax({
					url: 'subprograms/get-products-list.php',
					type: 'POST',
					success: function (data) {
						$('#apply-to-product').html(data);
						$('#apply-to-product').val('');
					}
				});
				$('#edit-product').fadeIn();
			} else $('#edit-product').fadeOut();
		});

		$('#storage-append-button').click(function () {
			if ( $('#edit-product').css('display') != 'none')
				$('#edit-product').hide();

			if ( $('#append-product').css('display') == 'none' )
				$('#append-product').fadeIn();
			else 
				$('#append-product').fadeOut();

		});

		$('#append-product-done').click(function () {
			$.ajax({
				url: 'subprograms/append-product.php',
				type: 'POST',
				data: ({
					'name': $('#set-product-name').val(),
					'quantity': $('#set-product-quantity').val(),
					'shelf-life': $('#set-product-shelf-life').val()
				}),
				success: function (data) {
					if (data)
						alert(data);
					else {
						$('#set-product-name').val('');
						$('#set-product-quantity').val('');
						$('#set-product-shelf-life').val('');
						$('#append-product').fadeOut();
						$.ajax({
							url: 'subprograms/get-products-list.php',
							type: 'POST',
							success: function (data) {
								$('#apply-to-product').html(data);
								$('#apply-to-product').val('');
							}
						});

						$("#products-filter > button:nth-child("+storage_sort_button+")").trigger('click');
					}
				}
			});
		});

		$('#edit-product-done').click(function () {
			$.ajax({
				url: 'subprograms/upgrade-product-info.php',
				type: 'POST',
				data: ({
					'id': $('#apply-to-product').val(),
					'name': $('#update-product-name').val(),
					'quantity': $('#update-product-quantity').val(),
					'shelf-life': $('#update-product-shelf-life').val()
				}),
				success: function (data) {
					if (data)
						alert(data)
					else {
						$('#apply-to-product').val('');
						$('#update-product-name').val('');
						$('#update-product-quantity').val('');
						$('#update-product-shelf-life').val('');
						$('#edit-product').fadeOut();
						$("#products-filter > button:nth-child("+storage_sort_button+")").trigger('click');
					}
				}
			});
		});

		$('#order-sort-by-unfulfilled').click(function () {
			$.ajax({
				url: 'subprograms/update-orders_admin.php',
				type: 'POST',
				data: ({
					'mode': 'sort-by-unfulfilled'
				}),
		
				success: function (data) {
					$('#out-orders-list').html(data);
					order_sort_button = 1;
				}
			});
		});
		$('#order-sort-by-executed').click(function () {
			$.ajax({
				url: 'subprograms/update-orders_admin.php',
				type: 'POST',
				data: ({
					'mode': 'sort-by-executed'
				}),
				success: function (data) {
					$('#out-orders-list').html(data);
					order_sort_button = 2;
				}
			});
		});
		$('#order-sort-by-all').click(function () {
			$.ajax({
				url: 'subprograms/update-orders_admin.php',
				type: 'POST',
				data: ({
					'mode': 'sort-by-all'
				}),
				success: function (data) {
					$('#out-orders-list').html(data);
					order_sort_button = 3;
				}
			});
		});

		$('#orders-delete-button').click(function () {
			let select_orders = get_selected('order-checkbox', 'data-order-id');
			$.ajax({
				url: 'subprograms/delete-order.php',
				type: 'POST',
				data: ({
					'order-id-list': select_orders
				}),
				success: function (data) {
					$("#orders-filter > button:nth-child("+order_sort_button+")").trigger('click');
				}
			});


 
		});

		$('#build-statistic-1').click(function () {
			$.ajax({
				url: 'subprograms/get-statistic-1-data.php',
				type: 'POST',
				data: ({
					// 'day'	: $('#statistic-1-day').val(), 
					'month'	: $('#statistic-1-month').val(),
					'year'	: $('#statistic-1-year').val()
				}),
				success: function (data) {
					data_statistic_1 = data.split(", ");
					for ( var i =0; i < 32; i++ ) 
						data_statistic_1[i] = Number(data_statistic_1[i]);
					

					var numbers = [];
					for ( var i = 1; i <= 31; i++) {
						numbers[ numbers.length ] = i;
					}

					var ctx = document.getElementById('chart-1').getContext('2d');
						Chart.defaults.global.hover.mode = 'nearest';
						var chart = new Chart(ctx, {
						    type: 'line',

						    data: {
						        labels: numbers,
						        datasets: [{
						            label: "Замовлено страв за місяць",
						            // backgroundColor: 'rgb(255, 99, 132)',
						            borderColor: 'rgb(255, 99, 132)',
						            data: data_statistic_1,
						        }],
						    },
						    options: {
						    	tootlips: {
						    		enabled: false
						    	}	
						    }
						});


					
				}
			});
		});




		$('#build-statistic-2').click(function () {

					
			for (var i = 1; i <= 12; i++) {
				var x = get_month_data(i);	
			}
			

			// setTimeout('drawww()', 500);
			drawww();
			



			
		});

	});

	
</script>
<center id='background-block'>
	<span class='user-hide' id='userid'><?php echo $user['id']; ?></span>
	<span class='user-hide' id='username'><?php echo $user['Username']; ?></span>

	<div id='go-back' class='wow bounceInLeft'><a href='/'><img src="/img/back.png"></a></div>
	<div id='content'>
		<div id='welcome'>З поверненням, <?php echo $user['Username']; ?>!</div>

		<div id='dishes'>
			<div>Список страв</div>
			<div id='dishes-filter'>
				<button id='dish-sort-by-id' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Сорт по ID</button>
				<button id='dish-sort-by-name' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Сорт по назві</button>
				<button id='dish-sort-by-class' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Сорт по класу</button>
				<button id='dish-sort-by-time' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Сорт по часу</button>
				<button id='dish-sort-by-price' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Сорт по ціні</button>
			</div>
			<table id='dishes-list' class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"> 
				<thead id='dishes-lisgt-head'>
					<tr> 
						<th style='padding: 12px 0 0 45%;'>
						</th>
						<th style='padding: 12px 0 0 0;'>ID</th>
						<th style='padding: 12px 0 0 0;'>Назва</th>
						<th style='padding: 12px 0 0 0;'>Клас</th>
						<th style='padding: 12px 0 0 0;'>Приготування</th>
						<th style='padding: 12px 0 0 0;'>Ціна</th>
						<th style='padding: 12px 0 0 0;'>Інгрідієнти</th>
						<th style='padding: 12px 0 0 0;'>Кількість</th>
					</tr>
				</thead>
				<tbody id='dishes-lisgt-body'> 
					<tr>
						<td colspan='8' style='padding: 0px;'> 
							<div>
								<table id='out-dishes-list' style='width: 100%' class='mdl-data-table mdl-js-data-table'>
									<?php 
										$search_dishes = mysqli_query($connection, "SELECT * FROM `Dishes` ORDER BY `Dishes`.`id` ASC;");
										for ( $i = 0; $i < mysqli_num_rows($search_dishes); $i++ ) {
											$search_dishes_res = mysqli_fetch_assoc($search_dishes);
											echo "
												<tr>
													<td>
														<label class='material-checkbox'>
															<input id='dish-".$search_dishes_res['id']."' type='checkbox'>
															<span></span>
														</label>
													</td>
													<td>".$search_dishes_res['id']."</td>
													<td>".$search_dishes_res['dish']."</td>
													<td>".$search_dishes_res['class']."</td>
													<td>".$search_dishes_res['time']."</td>
													<td>".$search_dishes_res['price']."</td>
													<td>".$search_dishes_res['products']."</td>
													<td>".$search_dishes_res['quantity']."</td>
												</tr>
											";
										}
									?>
								</table>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div id='dishes-buttons'> 
				<div>
					<button id='dishes-delete-button' class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
						<i class="material-icons">delete</i>
					</button>
				</div>
				<div>
					<button id='dishes-edit-button' class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
						<i class="material-icons">edit</i>
					</button>
				</div>
				<div>
					<button id='dishes-append-button' class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
						<i class="material-icons">add</i>
					</button>
				</div>
			</div>
		</div>
		<div id='append-dish'>
			<div>Додати страву</div>
			<div id='dish-settings'>
				<div id='settings-page-1'> 
					<div id='settings-list-1'>
						<div>
							<label>Назва:</label> <br>
							<input id='set-dish-name' type="text" placeholder='Coca Cola'>
						</div>
						<div>
							<label>Клас:</label> <br>
							<select id='set-dish-class'>
								<?php
									$search_class = mysqli_query($connection, "SELECT `class` FROM `Dishes` GROUP BY `class`;");
										for ($i = 0; $i < mysqli_num_rows($search_class); $i++) {
											$search_class_res = mysqli_fetch_assoc($search_class);
											echo "
												<option>".$search_class_res['class']."</option>
											";
										}
								?>
							</select>
						</div>
						<div>
							<label>Час приготування:</label> <br>
							<input id='set-dish-time' type="time" step='1' placeholder='00:00:00'>
						</div>
						<div>
							<label>Ціна:</label> <br>
							<input id='set-dish-price' type="text" placeholder='0.00'>
						</div>
						<div>
							<label>Інгрідієнти:</label> <br>
							<input id='set-dish-ingredients' type="text" placeholder='Product, Product...'>
						</div>
					</div>
					<div>
						<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='dish-settings-next'>
							<i class="material-icons">arrow_forward</i>
						</button>
					</div>
				</div>
				<div id='settings-page-2'> 
					<div id='settings-list-2'> 
					</div>
					<div>
						<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='dish-settings-back'>
							<i class="material-icons">arrow_back</i>
						</button>
						<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='dish-settings-next2'>
							<i class="material-icons">arrow_forward</i>
						</button>
					</div>
				</div>
				<div id='settings-page-3'> 
					<div id='settings-list-3'> 
						<div>
							<label>Назва:</label> <br>
							<input id='append-final-name' type='text'>
						</div>
						<div>
							<label>Клас:</label> <br>
							<input id='append-final-class' type='text'>
						</div>
						<div>
							<label>Приготування:</label> <br>
							<input id='append-final-time' type='text'>
						</div>
						<div>
							<label>Ціна:</label> <br>
							<input id='append-final-price' type='text'>
						</div>
						<div>
							<label>Інгрідієнти:</label> <br>
							<input id='append-final-ingredients' type='text'>
						</div>
						<div>
							<label>Кількість:</label> <br>
							<input id='append-final-quantity' type='text'>
						</div>

					</div>
					<div>
						<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='dish-settings-back2'>
							<i class="material-icons">arrow_back</i>
						</button>
						<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='dish-settings-done'>
							<i class="material-icons">done</i>
						</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id='edit-dish'> 
			<div>Змінити страву</div>
			<div id='selected-dishes-list'> 
			</div>
			<div id='dish-info'>
				<div id='id-info' style='display: none;'></div>
				<div>
					<label>Назва:</label> <br>
					<input type='text' id='name-info'> 
				</div>

				<div>
					<label>Клас:</label> <br>
					<select id='class-info'> 
						<?php 
							$search_class = mysqli_query($connection, "SELECT `class` FROM `Dishes` GROUP BY `class`;");
							for ($i = 0; $i < mysqli_num_rows($search_class); $i++) {
								$search_class_res = mysqli_fetch_assoc($search_class);
								echo "
									<option>".$search_class_res['class']."</option>
								";
							}
						?>
					</select>
				</div>

				<div>
					<label>Час приготування:</label> <br>
					<input type="time" step='1' placeholder='00:00:00' id='time-info'>
				</div>

				<div>
					<label>Ціна:</label> <br>
					<input type='text' id='price-info'>
				</div>
				
				<div> 
					<label>Продукти і кількість: </label>
					<div id='dish-info-product'>
						<div>  
							<input type='text' class='products-info'>
							<input type='number' min='0.1' class='quantity-info' step="0.1">
						</div>
					</div>
				</div>
				<div>
					<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='dish-edit-button-refresh'>
						<i class="material-icons">refresh</i>
					</button>
					<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='dish-edit-button-done'>
						<i class="material-icons">done</i>
					</button>
				</div>
			</div>
		</div>

		

		<div id='storage' style='padding: 20px 0px 20px 0px;'>
			<div>Склад</div>
			<div id='products-filter'>
				<button id='product-sort-by-id' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Сорт по ID</button>
				<button id='product-sort-by-name' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Сорт по назві</button>
				<button id='product-sort-by-quantity' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Сорт по кількості</button>
				<button id='product-sort-by-shelf-life' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Сорт по терміну придатності</button>
			</div> 
			<table id='products-list' class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"> 
				<thead id='products-lisgt-head'>
					<tr> 
						<th style='padding: 12px 0 0 45%;'>
						</th>
						<th style='padding: 12px 0 0 0;'>ID</th>
						<th style='padding: 12px 0 0 0;'>Назва</th>
						<th style='padding: 12px 0 0 0;'>Кількість</th>
						<th style='padding: 12px 0 0 0;'>Придатність</th>
					</tr>
				</thead>
				<tbody id='products-lisgt-body'> 
					<tr>
						<td colspan='5' style='padding: 0px;'> 
							<div>
								<table id='out-products-list' style='width: 100%' class='mdl-data-table mdl-js-data-table'>
									<?php 
										$get_products = mysqli_query($connection, "SELECT * FROM `Storage` ORDER BY `Storage`.`id` ASC;");

										for ($i = 0; $i < mysqli_num_rows($get_products); $i++) {
											$get_products_res = mysqli_fetch_assoc($get_products);
											
											$date = date('d.m.Y');
											$d1 = strtotime( $get_products_res['shelf_life'] );
											$d2 = strtotime( $date );

											if ( $get_products_res['quantity'] <= 0 or $d1 - $d2 <= 0 )
												echo "
													<tr style='background-color: rgba(255, 0, 0, 0.2);'>
														<td>
															<label class='material-checkbox'>
																<input class='storage-checkbox' data-product-id=".$get_products_res['id']." id='dish-".$get_products_res['id']."' type='checkbox'>
																<span></span>
															</label>
														</td>
														<td>".$get_products_res['id']."</td>
														<td>".$get_products_res['product']."</td>
														<td>".$get_products_res['quantity']."</td>
														<td>".$get_products_res['shelf_life']."</td>
													</tr>
												";
											elseif ( ($get_products_res['quantity'] <= 20 and $get_products_res['quantity'] > 0) or ($d1 - $d2 < 86400*5 and $d1 - $d2 > 0) ) 
												echo "
													<tr style='background-color: rgba(255, 232, 0, 0.3);'>
														<td>
															<label class='material-checkbox'>
																<input class='storage-checkbox' data-product-id=".$get_products_res['id']." id='dish-".$get_products_res['id']."' type='checkbox'>
																<span></span>
															</label>
														</td>
														<td>".$get_products_res['id']."</td>
														<td>".$get_products_res['product']."</td>
														<td>".$get_products_res['quantity']."</td>
														<td>".$get_products_res['shelf_life']."</td>
													</tr>
												";
											else
												echo "
													<tr>
														<td>
															<label class='material-checkbox'>
																<input class='storage-checkbox' data-product-id=".$get_products_res['id']." id='dish-".$get_products_res['id']."' type='checkbox'>
																<span></span>
															</label>
														</td>
														<td>".$get_products_res['id']."</td>
														<td>".$get_products_res['product']."</td>
														<td>".$get_products_res['quantity']."</td>
														<td>".$get_products_res['shelf_life']."</td>
													</tr>
												";
										}
									?>
								</table>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div id='storage-buttons'>
				<button id='storage-delete-button' class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
					<i class="material-icons">delete</i>
				</button>
				<button id='storage-edit-button' class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
					<i class="material-icons">edit</i>
				</button>
				<button id='storage-append-button' class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
					<i class="material-icons">add</i>
				</button>
			</div>
			<div id='append-product'> 
				<span>Додати продукт</span>
				<div>
					<div>
						<label>Назва:</label> <br>
						<input type="text" id="set-product-name"> 
					</div>
					<div>
						<label>Кількість:</label> <br>
						<input type="number" min='0.1' step='0.1' id="set-product-quantity" onchange='check_min("set-product-quantity")'> 
					</div>
					<div>
						<label>Придатність:</label> <br>
						<input type="date" id="set-product-shelf-life"> 
					</div>
				</div>
				<div>
					<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='append-product-done'>
						<i class="material-icons">done</i>
					</button>
				</div>
			</div>
			<div id='edit-product'>
				<span>Редагувати</span>
				<div>
					<div>
						<label>Застосувати до:</label> <br>
						<select id='apply-to-product' onchange='update_product_info()'>

						</select>
					</div>
					<div>
						<label>Назва:</label> <br>
						<input type="text" id="update-product-name"> 
					</div>
					<div>
						<label>Кількість:</label> <br>
						<input type="number" min='0.1' step='0.1' id="update-product-quantity" onchange='check_min("update-product-quantity")'> 
					</div>
					<div>
						<label>Придатність:</label> <br>
						<input type="date" id="update-product-shelf-life"> 
					</div>
				</div>
				<div>
					<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='edit-product-refresh' onclick='update_product_info()'>
						<i class="material-icons">refresh</i>
					</button>
					<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='edit-product-done'>
						<i class="material-icons">done</i>
					</button>
				</div>
			</div>
		</div>

		<div id='orders' style='padding: 20px 0px 20px 0px;'>
			<div>Замовлення</div>
			<div id='orders-filter'>
				<button id='order-sort-by-unfulfilled' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Невиконані</button>
				<button id='order-sort-by-executed' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Виконані</button>
				<button id='order-sort-by-all' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Всі</button>
			</div> 
			<table id='orders-list' class="mdl-data-table mdl-js-data-table mdl-shadow--2dp"> 
				<thead id='orders-lisgt-head'>
					<tr> 
						<th style='padding: 12px 0 0 45%;'>
						</th>
						<th style='padding: 12px 0 0 0;'>ID</th>
						<th style='padding: 12px 0 0 0;'>Страви</th>
						<th style='padding: 12px 0 0 0;'>Адреса</th>
						<th style='padding: 12px 0 0 0;'>Номер телефону</th>
					</tr>
				</thead>
				<tbody id='orders-lisgt-body'> 
					<tr>
						<td colspan='5' style='padding: 0px;'> 
							<div>
								<table id='out-orders-list' style='width: 100%' class='mdl-data-table mdl-js-data-table'>
									<?php 
										$get_orders = mysqli_query($connection, "SELECT * FROM `Orders` WHERE `finished` = 'False' ORDER BY `Orders`.`id` DESC;");

										for ($i = 0; $i < mysqli_num_rows($get_orders); $i++) {
											$get_orders_res = mysqli_fetch_assoc($get_orders);
											
											echo "
												<tr>
													<td>
														<label class='material-checkbox'>
															<input class='order-checkbox' data-order-id=".$get_orders_res['id']." id='order-".$get_orders_res['id']."' type='checkbox'>
															<span></span>
														</label>
													</td>
													<td>".$get_orders_res['id']."</td>
													<td>".$get_orders_res['ordered_dishes']."</td>
													<td>".$get_orders_res['address']."</td>
													<td>".$get_orders_res['phone']."</td>
												</tr>
											";
										}
									?>
								</table>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div id='orders-buttons'>
				<button id='orders-delete-button' class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
					<i class="material-icons">delete</i>
				</button>
			</div>
		</div>

		<div style='padding: 20px 0px 20px 0px;' id='keys-list'> 
			<div>Ключі для реєстрації</div>
			<?php 
				$search_keys = mysqli_query($connection, "SELECT `registration_key` FROM `Registration_keys`;");
				$keys = [];

				for ($i = 0; $i < mysqli_num_rows($search_keys); $i++){
					$search_keys_res = mysqli_fetch_assoc($search_keys);
					array_push($keys, $search_keys_res['registration_key']);
				}
			?>
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" id='registration_keys'>
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">ID</th>
						<th>Посада</th>
						<th style='text-align: center;'>Ключ</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">1</td>
						<td>Admin</td>
						<td><input type="text" class='keys' id='admin-key' value="<?php echo $keys[0]; ?>"></td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">2</td>
						<td>Operator</td>
						<td><input type="text" class='keys' id='operator-key' value="<?php echo $keys[1]; ?>"></td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">3</td>
						<td>Driver</td>
						<td><input type="text" class='keys' id='driver-key' value="<?php echo $keys[2]; ?>"></td>
					</tr>
			</tbody>
			</table>
			<div id='keys-buttons'>
				<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='key-button-refresh'>
					<i class="material-icons">refresh</i>
				</button>
				<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" id='key-button-done'>
					<i class="material-icons">done</i>
				</button>
			</div>
		</div>
		<style type="text/css">
			#statistic-1 > span:nth-child(1) {
				font-size: 1.5em;
			}

			#statistic-1 > div:nth-child(2) > div {
				margin: 5px 0px 5px 0px;
			}

			#statistic-1 > div:nth-child(3) {
				margin: 10px 0px 10px 0px;
			}

			#chart-1-block {
				width: 98%;
				height: 500px;
			}

			#chart-1 {
				width: 100%;
				height: 100%;
			}


			#statistic-2 > span:nth-child(1) {
				font-size: 1.5em;
			}

			#statistic-2 > div:nth-child(2) > div {
				margin: 5px 0px 5px 0px;
			}

			#statistic-2 > div:nth-child(3) {
				margin: 10px 0px 10px 0px;
			}

			#chart-2-block {
				width: 98%;
				height: 500px;
			}

			#chart-2 {
				width: 100%;
				height: 100%;
			}

		</style>
		<div id='statistic-1' style='padding: 20px 0px 20px 0px;'> 
		    <span>Статистика замовлених страв за місяць:</span>
		    <div> 
		    	<div>
		    		<label>Місяць:</label> <br>
		    		<select id='statistic-1-month' onchange='statistic_1_change()'>
		    			<option>Січень</option>
		    			<option>Лютий</option>
		    			<option>Березень</option>
		    			<option>Квітень</option>
		    			<option>Травень</option>
		    			<option>Червень</option>
		    			<option>Липень</option>
		    			<option>Серпень</option>
		    			<option>Вересень</option>
		    			<option>Жовтень</option>
		    			<option>Листопад</option>
		    			<option>Грудень</option>
		    		</select>
		    	</div>
		    	<div>
		    		<label>Рік:</label> <br>
		    		<select id='statistic-1-year'>
		    			<?php 
		    				$query = mysqli_query($connection, "SELECT DISTINCT YEAR(date) as `date` FROM `Orders`;");
		    				for ($i = 0; $i < mysqli_num_rows($query); $i++)
		    				{
		    					$query_res = mysqli_fetch_assoc($query);
		    					echo "<option>" . $query_res['date'] . "</option>";
		    				}
		    			?>
		    		</select>
		    	</div>
		    </div>
		    <div id='statistic-1-filter'>
		        <button id='build-statistic-1' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Оновити</button>
		    </div>
		    <div id='chart-1-block'>
		    	<canvas id="chart-1"></canvas>
		    </div>
		</div>
		<div id='statistic-2' style='padding: 20px 0px 20px 0px'>
			<span>Статистика статистика замволених страв за рік:</span> 
			<div>
				<div>
					<label>Рік:</label> <br>
					<select id='statistic-2-year'> 
						<?php 
		    				$query = mysqli_query($connection, "SELECT DISTINCT YEAR(date) as `date` FROM `Orders`;");
		    				for ($i = 0; $i < mysqli_num_rows($query); $i++)
		    				{
		    					$query_res = mysqli_fetch_assoc($query);
		    					echo "<option>" . $query_res['date'] . "</option>";
		    				}
		    			?>
					</select>
				</div>
			</div>
			<div id='statistic-2-filter'>
		        <button id='build-statistic-2' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect'>Оновити</button>
		    </div>
		    <div id='chart-2-block'>
		    	<canvas id='chart-2'></canvas>
		    </div>
		</div>
	</div>
</center>
<script type="text/javascript" defer>

	// Chart 1

	var numbers = [];
	for ( var i = 1; i <= 31; i++) {
		numbers[ numbers.length ] = i;
	}

	var ctx = document.getElementById('chart-1').getContext('2d');
		Chart.defaults.global.hover.mode = 'nearest';
		var chart = new Chart(ctx, {
		    type: 'line',

		    data: {
		        labels: [''],
		        datasets: [{
		            label: "Замовлено страв за місяць",
		            // backgroundColor: 'rgb(255, 99, 132)',
		            borderColor: 'rgb(255, 99, 132)',
		            data: [''],
		        }],
		    },


		    options: {
		    	tootlips: {
		    		enabled: false
		    	}	
		    }
		});

	// Chart 2

	var ctx = document.getElementById('chart-2').getContext('2d');
		Chart.defaults.global.hover.mode = 'nearest';
		var chart = new Chart(ctx, {
		    type: 'line',

		    data: {
		        labels: ['Січень', 'Лютий', 'Березень', 'Квітень', 'Травень', 'Червень', 'Липень', 'Серпень', 'Вересень', 'Жовтень', 'Листопад', 'Грудень'],
		        datasets: [{
		            label: "Замовлено страв за рік",
		            // backgroundColor: 'rgb(255, 99, 132)',
		            borderColor: 'rgb(255, 99, 132)',
		            data: [],
		        }],
		    },


		    options: {
		    	tootlips: {
		    		enabled: false
		    	}	
		    }
		});

</script>