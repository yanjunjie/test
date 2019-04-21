<?php
/*
$conn = mysqli_connect('localhost', 'root','');

	mysqli_select_db($conn,'test');
	$sql = "select * from test_table";
	$result = mysqli_query($conn,$sql);
	
	while($row = mysqli_fetch_array($result)){
		echo $row['id'].'<br>';
		echo $row['full_name'].'<br>';
		echo $row['email'].'<br>';
	}*/
	
	//new array example
	$student = array(
						array('name'=>'Md. Bablu Mia','id'=>'51', 'pro'=>'CSE'),
						array('name'=>'Lovlu','id'=>'52', 'pro'=>'CMT'),
						array('name'=>'Dablu','id'=>'53', 'pro'=>'EEE'),
						
					);
					
	$fieldName = reset($student);
	$arrKeys = array_keys($fieldName);

	//echo $student[0]['name']; //Formula
	$n = count($student);
	
	//output 1
	for($i=0; $i<$n; $i++){
		foreach($arrKeys as $key){
			echo $student[$i][$key]."<br>";
		}
	}
	
	//output 1
	foreach($student as $key=>$value){
		foreach($arrKeys as $field){
			echo $student[$key][$field]."<br>";
		}
	}
	
?>