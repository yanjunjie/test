<?php session_start();
	include 'db_operation.class.php';
	$db_obj = new DB_operation();
	
	if(isset($_GET['id'])){
		$result = $db_obj->delete_data($_GET['id']);

		if($result){
            $_SESSION['success'] = 'Record deleted successfully';
		} else {
            $_SESSION['error'] = 'Record not deleted successfully';
		}

        header('location: view.php');
	}
?>
