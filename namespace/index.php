<?php

	require "main.php";
	require "main2.php";
	use function main1\motherboard;
	use main1\manin2;
	use main2\manin2 as main_two;

	class manin{
		public function monitor_type($brand)
		{
			return $brand;
		}
	}


	//main1\motherboard(); //Qualified Namespace
	motherboard(); //Unqualified Namespace

	echo "<br>";

	//$obj_main1 = new manin2; //Unqualified Namespace
	$obj_main1 = new main1\manin2; //Qualified Namespace
	echo $obj_main1->monitor_type('HP');

	echo "<br>";

	$obj_main2 = new main_two; //Unqualified Namespace
	//$obj_main2 = new main2\manin2; //Qualified Namespace
	echo $obj_main2->keyboard_type('Dell');

	echo "<br>";

	$obj_main3 = new \manin; //Global/Root Namespace ('\' is called root)
	echo $obj_main3->monitor_type('Acer');



?>