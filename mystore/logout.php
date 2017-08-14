<?php
        include("include/header.php");
?>

<?php
      session_unset();
        session_destroy();
        echo "<td><b>Thank you for visiting our site</b><br>";
		echo "<a href=login.php>Login Again</a>";
?>
<?php
 include ("include/footer.php");
?>

