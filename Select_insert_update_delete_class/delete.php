<?php
	include 'db_operation.class.php';
	$db_obj = new DB_operation();
	
	if(isset($_GET['id'])){
		$result = $db_obj->delete_data($_GET['id']);
		if($result){
			header('location: select.php');
		}
	}
?>
