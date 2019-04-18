<?php
	class DB_operation{
	    private $conn;
		public function __construct(){
			//mysql_connect('localhost','root','') or die(mysql_error);
			//mysql_select_db('tutorial') or die(mysql_error);

            $this->conn = mysqli_connect('localhost','root','', 'tutorial');
		}
		
		public function insert_data($name, $email){
			$sql = "insert into user (name, email) value('$name','$email')";
			return mysqli_query($this->conn,$sql); // returns status as true/false
		}
		
		public function select_data(){
			$sql = "select * from user";
			return mysqli_query($this->conn,$sql); // returns resultset
		}
		
		public function select_data_row($id){
			$sql = "select * from user where id = $id";
			return mysqli_query($this->conn,$sql); // returns result
		}
		
		public function update_data($name,$email,$id){
			$sql = "UPDATE user
			SET name ='$name', email='$email' WHERE id='$id'";
			return mysqli_query($this->conn,$sql); // returns status true/false
		}
		
		public function delete_data($id){
			$sql = "DELETE FROM user WHERE id='$id'";
			return mysqli_query($this->conn,$sql); // returns true/false
		}
	}
	
?>