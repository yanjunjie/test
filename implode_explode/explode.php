<!DOCTYPE html>
<html>
<body>
<!--String to Array-->
<?php
$str = 'one,two,three,four';

// zero limit
print_r(explode(',',$str,0));
print "<br>";

// positive limit
print_r(explode(',',$str,2));
print "<br>";

// negative limit 
print_r(explode(',',$str,-1));
?>  

<br>
<?php
$str = "Hello world. It's a beautiful day.";
print_r (explode(" ",$str));
?> 

</body>
</html>