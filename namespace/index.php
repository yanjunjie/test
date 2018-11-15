<?php

namespace main1;
function motherboard(){
    echo "Motherboard brand name is Intel";
}

const mouse='A4 Tech';

class manin2{
    public function monitor_type($brand)
    {
        return $brand;
    }
}

namespace main2;
function motherboard(){
    echo "Motherboard brand name is Gigabyte";
}

const mouse='A4 Tech';

class main2{
    public function keyboard_type($brand)
    {
        return $brand;
    }
}

	/*
	use function main1\motherboard;
	use main1\manin2;
	use main2\manin2 as main_two;
	use const main1\mouse;;
    */
	//namespace main;

namespace main;
use function main1\motherboard as myMotherboard;
use const main1\mouse as myMouse;
use main1\manin2 as myMain1;
//use main2\main2 as myMain2;

	class main2{
		public function monitor_type($brand)
		{
			return $brand;
		}
	}

	$obj = new myMain1();
	echo $obj->monitor_type('Dell');

	echo "<br>";

	$obj2 = new \main2\main2;
	echo $obj2->keyboard_type('A4 Tech');

    echo "<br>";

    $obj3 = new \main\main2;
    echo $obj3->monitor_type('haadsf');








/*
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

	$obj_main3 = new \manin; //Global/Root Namespace ('\' is called root) or fully qualified class name
	echo $obj_main3->monitor_type('Acer');

    echo "<br>";

    echo mouse; //Unqualified Namespace
    echo main1\mouse; //Qualified Namespace

*/
?>