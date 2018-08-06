<?php
/*
1. Healthy
    -> Salad
    -> Pasta
    -> Vegetables
2. Unhealthy
    -> Pizza
    -> Ice cream
*/

//$foods = array(array('Salad','Pasta','Vegetables'), array('Pizza','Ice cream'));
//echo $foods[0][0].' ';
//var_dump($foods);

//$foodsObj = (object)$foods;
//var_dump($foodsObj);

//$foods = array('Healthy'=>array('Salad','Pasta','Vegetables'), 'Unhealthy'=>array('Pizza','Ice cream'));
//echo $foods['Healthy'][0];

/*foreach ($foods as $food_cat => $food_elements){ // $food_cat is an array and $food_elements are elements of the array ($food_cat)
   echo '<b>'.$food_cat.'</b>'; // As the array $food_cat is a key hence it is echo without loop
    //var_dump($food) .'<br>';
    foreach ($food_elements as $food_item){ // As $food_elements is an array hence it will need a loop for displaying item.
        echo $food_item.'';
    }
}*/

/*echo '<br>'.'++++++++++++++'.'<br></br>';

$arr = ['name'=>'Md. Bablu Mia', 'id'=>'51', 'program'=>'CSE'];*/
//$arrObj=(object)$arr;
//echo $arrObj->name;
//echo gettype($arrObj);

/*$object = json_decode(json_encode($arr), FALSE); //json_decode returns an object when false, if true it will return an array
$object->program = 'EEE';
echo $object->program;*/

//Multidimen test 3
$cars = array
  (
	  $carr['car1'] = array("Volvo",22,18,19), //1
	  $carr['car2'] = array("BMW",15,13, ''), //2
	  $carr['car3'] = array("Saab",5,2, ''), //3
	  $carr['car4'] = array("Land Rover",17,15, '') //4
  );
  
  echo '<table border="1">';
  foreach($cars as $key=>$value){ //$key = field name or array name
	  echo '<tr>';
	  echo $value[$key];
	  foreach($value as $index =>$cell){ //$cell = cell value or array element
		  echo '<td>'.$cell.'</td>';
	  }
	  echo '</tr>';
	  
  }
echo '</table>';

?>