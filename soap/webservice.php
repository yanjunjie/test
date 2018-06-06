<?php
	require_once('lib/nusoap.php');
	include('books.php');

	$server = new nusoap_server();
	$server->configureWSDL("Demo");
	$server->register(
		'get_price', //name of funtion
		array('find'=>'xsd:string'), //inputes
		array('return'=>'xsd:integer') //outputs
		);

	//process client request
	// $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)? $HTTP_RAW_POST_DATA : '';
	// $server->service($HTTP_RAW_POST_DATA);

	@$server->service(file_get_contents("php://input"));
