<?php
require '_header.php';
$json = array('error' => true);
if(isset($_GET['id'])){
	$product = $DB->query('SELECT id FROM products WHERE id=:id', array('id' => $_GET['id']));
	if(empty($product)){
		$json['message'] = "This product does not exist";
	}else{
		$panier->add($product[0]->id);
		$json['error']  = false;
		$json['total']  = number_format($panier->total(),2,',',' ');
		$json['count']  = $panier->count();
		$json['message'] = 'The product has been added to your cart';
	}
}else{
	$json['message'] = "You have not selected any product to add to cart";
}
echo json_encode($json);
