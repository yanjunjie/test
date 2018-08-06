<?php 
   $connection = mysqli_connect('localhost','root','','tutorials');
   
   //echo uniqid();
   //echo date("Y-m-d-H-i-s");
   
   //$file_name       = uniqid().date("Y-m-d-H-i-s").str_replace(" ", "_", $_FILES['image']['name']);

   $file_name       = date("Y-m-d-H-i-s").sha1($_FILES['image']['name']);


   $destination     = "images/".$file_name;
   $filename        = $_FILES['image']['tmp_name'];

   if(move_uploaded_file($filename, $destination))
   {
   	   $sql = "INSERT INTO images (path) VALUES ('$destination')";
   	   mysqli_query($connection,$sql);

   	   $sql = "SELECT * FROM images";
   	   $obj = mysqli_query($connection,$sql);

   	   foreach ($obj as $key => $value) {
   	   	   echo "<img style='width:150px;' src=".$value['path'].">"; 
   	   }
   }
?>