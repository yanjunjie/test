<?php
include('../lib/nusoap.php');
$client = new nusoap_client('http://localhost/test/soap/webService.php?wsdl');

$book_name = "c"; //$_POST/$_GET

$price = $client->call(
	'get_price', //method name
	array("find"=>"$book_name")  //input
	);

//print_r($price);

echo $price;
?>