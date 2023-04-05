<?php 

function check_shelf_life($connection, $shelf_life) {
	$date = date('d.m.Y');
	$d1 = strtotime( $shelf_life );
	$d2 = strtotime( $date );

	if ( $d1 - $d2 <= 0 )
		return false;
	else 
		return true;	
}

function check_this_dish($connection, $dish_name) {
	$dish = trim($dish_name);
	$dish_search = mysqli_query($connection, "SELECT * FROM `Dishes` WHERE `dish` LIKE '%".$dish."%';");
	$good_products = 0;

	if (mysqli_num_rows($dish_search) == 0) 
	{
		return false;
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
				return false;
			} else {
				$good_products++;
			}
		}
		if ($good_products == count($ingredients))
			return true;
		else 
			return false;

	}  
}

function get_cards_by_class($x, $connection) {
	$result = mysqli_query($connection, "SELECT * FROM `Dishes` WHERE `class`='$x'");
	for ($i = 1; $i <= mysqli_num_rows($result); $i++) {
		$res = mysqli_fetch_assoc($result);
		if ( check_this_dish($connection, $res['dish']) )
		echo "
		<div class='dish' id='".$res['id']."'>
			<div class='dish-count'>0</div>
			<div class='dish-name'>".$res['dish']."</div>
			<div class='dish-image'><img src='img/dishes/$x/".$res['id'].".jpg'></div>
			<div class='dish-ingredients'>Інгредієнти: ".$res['products']."</div>
			<div class='dish-info'>
				<div class='dish-time' id='time-".$res['id']."'>".$res['time']."</div>
				<div class='dish-price'>".$res['price']." грн.</div>
				<div class='mdl-tooltip mdl-tooltip--large' for='time-".$res['id']."'>
					Час приготування страви
				</div>
			</div>
			<div class='dish-buttons'>
				<button class='minus' onclick='remove_dish(\"".$res['dish']."\", ".$res['price'].", \"".$res['time']."\")'>-</button>
				<button class='plus' onclick='add_dish(\"".$res['dish']."\", ".$res['price'].", \"".$res['time']."\")'>+</button>
			</div>
		</div>
		";
	}
}

?>