<?php 
	$host	=	"localhost";
	$user	=	"root";
	$pass   =	"";
	$db		=	"tutorial";
	$conn	=	new mysqli($host,$user,$pass, $db);

	 if(!$conn){
	 	echo "Failed !!";
	 }  

?>