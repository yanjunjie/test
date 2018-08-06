<?php
include("include/header.php");
?>

<?php
if(isset($_GET['submit']))
 {
	$user_name=$_GET['user_name'];
	$user_pass=$_GET['user_pass'];
	$user_fullname=$_GET['user_fullname'];
 $link=connect_db();
 $sql="insert into user values( '$user_name', '$user_pass', '$user_fullname')";
 $result=mysql_query($sql, $link);

 if($result==null)
 {
 echo "<br><b> Registration faild. Please try again</b><br>";
 }
 else
 {
 echo "<br> Welcome <b>$_GET[user_fullname]</b><br>";
 }
}

else
  {
?>
  <form action="registration.php" method="get" name="frm">
   <input name ="register_form" type="hidden" value="true">
 Username: <input name = "user_name" type="text"><br>
 Password: <input name = "user_pass" type="password"><br>
Fullname: <input name = "user_fullname" type="text"><br><br>
  <input type="submit" value="Register Me" name="submit">
  </form>

<?php
  }
?>
<?php
 include ("include/footer.php");
?>
