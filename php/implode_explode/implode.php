<!DOCTYPE html>
<html>
<body>
<!--Array to String-->
<?php
	$arr = array('Hello','World!','Beautiful','Day!');
	echo implode(" ",$arr)."<br>";
	echo implode("+",$arr)."<br>";
	echo implode("-",$arr)."<br>"; 
	echo implode("X",$arr)."<br>";
	echo "'".implode("',' ",$arr)."'";
?>

</body>
</html>