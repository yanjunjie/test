<?php
        include ("include/header.php");
?>
<?php
        //echo $_SESSION['username'];
        //echo $_GET[cat_id]."<br>";
		 $cat_id=$_GET['cat_id'];

?>



 <?php
 if(isset($_SESSION['username']))
 {
/* if ($cat_id==null)
 {
 $cat_id=1;
 }*/
 $link=connect_db();
 $sql="select * from products where category_id=$cat_id";
  $result=mysql_query($sql,$link);
 while($row=mysql_fetch_array($result))
 {
 echo "<b>$row[product_name]</b><br>";
 echo "<img src=$row[product_image]><br>";
 echo "<b>$row[description]</b><br>";
 echo "<b>$row[unit_price]</b><br>";
 echo "<b>$row[total_unit]</b><br>";
 echo "<br><br>";

 }
 }
 else
 {
 echo "<b> You have to login to view products.</b>";
 }
?>

<?php
        include("include/footer.php");
?>
