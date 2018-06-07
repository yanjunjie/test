<?php
function get_price($find=""){
	$books=array(
		"java"=>299,
		"c"=>384,
		"php"=>267,
		"javascript"=>300
	);
	
	foreach($books as $book=>$price){
		if($book==$find){
			return $price;
		}
	}
}