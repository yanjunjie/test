<?php 

//GET Request {We can also use POST/PUT/DELETE request}
if (!empty($_POST['book_name'])) {
	
	$name = $_POST['book_name'];

	//Resource Address
	$url = "http://localhost/test/restful_api/$name";

	//Send request to Resource 
	$client = curl_init($url);

	//The true will tell curl to return the string instead of print it out
	curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	
	//Get response to Resource
	$response = curl_exec($client);

	//Close the curl session we have created.
	curl_close($client);

	//Decode JSON
	$result = json_decode($response);

	//echo $result->data;

}


?>