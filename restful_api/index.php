<?php
	header("Content-Type:application/json");
	include('books.php');
	
	//process client request
	if(!empty($_GET['name'])){
		//valid request
		$name = $_GET['name'];
		$price = get_price($name);
		if($price){
			//Book found
			deliver_response(200, "Book Found", $price);
		}else{
			//Book not found
			deliver_response(200, "Book not Found", NULL);
		}
	}else{
		//Invalid request
		deliver_response(400, "Invalid Request", NULL);
	}
	//End request process
	
	//
	function deliver_response($status, $status_message, $data){
		header("HTTP/1.1 $status $status_message");
		$response['status'] = $status;
		$response['status_message'] = $status_message;
		$response['data'] = $data;
		
		$json_response = json_encode($response);
		echo $json_response;
	}