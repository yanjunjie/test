<?php
include('../lib/nusoap.php');
$client = new nusoap_client('http://localhost/test/soap/webservice.php?wsdl');

if (!empty($_POST['book_name'])) {
	$book_name = $_POST['book_name'];
}

//$book_name = "c";

$price = $client->call(
	'get_price', //method name
	array("find"=>"$book_name")  //input
	);

if(!$price){
	$price = "Book Not Found";
}

//echo $price;
?>
