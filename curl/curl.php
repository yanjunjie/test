<?php 

//GET Request {We can also use POST/PUT/DELETE request}
if (!empty($_POST['book_name'])) {
	
	$name = $_POST['book_name'];

	//Data with POST Request to the Web Service
	/*$post_data = array(
        'firstname' => 'John',
        'lastname' => 'Doe'
    );*/

	//Resource Address
	$url = "http://localhost/test/restful_api/$name";

	//Send request to Resource 
	$curl = curl_init();
	
	// You can also set the URL like this:
	// $curl = curl_init('http://localhost/echoservice');

	/*
	// If any API has restricted Accept headers for application/json insead of POST request
	$headers = ['Content-Type: application/json'];
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
	OR

	//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	*/

	// For POST Request as usual
	curl_setopt($curl, CURLOPT_POST, 1); //it is it optional while using CURLOPT_POSTFIELDS

	// Insert the data for POST request
	//curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	
	// Set the url path we are sending a request
	curl_setopt($curl, CURLOPT_URL, $url);  
	
	//Set true, It will tell curl to return the string instead of print it out
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	//false will tell curl to ignore the header in the return value.
	//curl_setopt($curl,CURLOPT_HEADER, false); 
	
	// You can also bunch the above commands into an array: curl_setopt_array

	// Send the request and get the response from Resource
	$response = curl_exec($curl);

	/*
	// Get cURL information back
	$info = curl_getinfo($curl);  
	echo 'content type: ' . $info['content_type'] . '<br />';
	echo 'http code: ' . $info['http_code'] . '<br />';
	*/

	//Close the curl session we have created.
	curl_close($curl);

	//Decode JSON Data for use
	$result = json_decode($response);

	echo $result->data;

}


?>