<?php 
   $capital = file_get_contents('http://country.io/capital.json');

   $data    = json_decode($capital);

   foreach ($data  as $key => $value) {
   	 echo "<li>".$key.":".$value."</li>";
   }
?>