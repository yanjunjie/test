<?php
include "config.php"; //$conn
   
   //echo uniqid();
   //echo date("Y-m-d-H-i-s");
   
   //$file_name       = uniqid().date("Y-m-d-H-i-s").str_replace(" ", "_", $_FILES['image']['name']);

   $file_name       = date("Y-m-d-H-i-s").sha1($_FILES['image']['name']); //hashed file name


   $destination     = "images/".$file_name;
   $filename        = $_FILES['image']['tmp_name'];

   if(move_uploaded_file($filename, $destination))
   {
   	   $sql = "INSERT INTO images (path) VALUES ('$destination')";
   	   mysqli_query($conn,$sql);

   	   $sql = "SELECT * FROM images";
   	   $obj = mysqli_query($conn,$sql);

   	   foreach ($obj as $key => $value) {
   	   	   echo '<img style="width:150px;" src="'.$value['path'].'">';
   	   }
   }
?>