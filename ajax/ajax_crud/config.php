<?php 
	$host	=	"localhost";
	$user	=	"root";
	$pass   =	"123456";
	$db		=	"test";
	$conn	=	new mysqli($host,$user,$pass, $db);

	 if(!$conn){
	 	echo "Failed !!";
	 }  

?>