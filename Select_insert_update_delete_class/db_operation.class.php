<?php
	class DB_operation{
		public function __construct(){
			mysql_connect('localhost','root','') or die(mysql_error);
			mysql_select_db('test') or die(mysql_error);
		}
		
		public function insert_data($full_name, $email){
			$sql = "insert into oop_test_table (full_name, email) value('$full_name','$email')";
			$result = mysql_query($sql);
			if($result){
				echo "Data inserted successfully";
			}else
				echo "Try again";
		}
		
		public function select_data(){
			$sql = "select * from oop_test_table";
			$result = mysql_query($sql);
			return $result;
		}
		
		public function select_data_row($id){
			$sql = "select * from oop_test_table where id = $id";
			$result = mysql_query($sql);
			return $result;
		}
		
		public function update_data($full_name,$email,$id){
			$sql = "UPDATE oop_test_table
			SET full_name ='$full_name', email='$email' WHERE id='$id'";
			$result = mysql_query($sql);
			return $result;
		}
		
		public function delete_data($id){
			$sql = "DELETE FROM oop_test_table WHERE id='$id'";
			$result = mysql_query($sql);
			return $result;
		}
	}
	
?>