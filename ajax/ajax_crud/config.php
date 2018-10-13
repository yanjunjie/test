<?php 
	$host	=	"localhost";
	$user	=	"root";
	$pass   =	"";
	$db		=	"test";
	$conn	=	new mysqli($host,$user,$pass, $db);

	 if(!$conn){
	 	echo "Failed !!";
	 }  

?>