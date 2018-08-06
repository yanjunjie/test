<?php include("include/header.php"); ?>

<?php
       if(isset($_GET['submit']))
       {
		   $form_username=$_GET['form_username'];
			$form_password=$_GET['form_password'];
			echo $form_username;
			echo $form_password;

        $link = connect_db();
       $sql="select * from user where username= '$form_username' and user_pass= '$form_password'";
       $result=mysql_query($sql, $link);
       $row=mysql_fetch_array($result);

            if ($row['username']==null)
       {
       echo "<br>Login failed. Please try again.<br>";
       }
       else
       {
       echo "<br><b>Welcome $row[user_fullname]</b><br>";
       echo "<br><b>Now you can buy products from our Store</b><br>";
	    $_SESSION['username']=$row['username'];
        $_SESSION['user_fullname']=$row['user_fullname'];
        $_SESSION['price']=0;
       }
       }
       else
       {
       ?>

        <br> Enter yout Username and Password for login </br>
        <form action="login.php" method="GET">
        <input name="login_form" type="hidden" value="true">
        Username: <input name="form_username" size=20 ><br>
        Password: <input name="form_password" type="password" size=20><br><br>
        <input type=submit value="Login"  name="submit">
      </form>
<?php
}
?>

<?php
 include ("include/footer.php");
?>

