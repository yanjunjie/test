<?php session_start();?>
 <?php include("include/config.php");
 ?>

<html>
<body bgcolor=gainsboro>
<?php//1nd row:?>
<table align=center width=850 border=0 cellspacing=0 cellpadding=0>
<tr bgcolor=#9999BB>
<td>
        <br> <h3> <center>Online Trading in Bangladesh</center></h3>
</t>
</tr>

</tr>
<?php//2nd row:?>
<tr bgcolor=#bbbbdd>
        <td align=center>
        <table width=50% cellpadding=0 cellspacing=0 border=0>
        <tr align=center>
                <td> <a href="index.php">Home</a> </td>
                <td> <a href="products.php">Products</a></td>
                <td> <a href="registration.php">Registration</a></td>
           <?php  if(isset($_SESSION['username']))
                        {  
                        echo "<td> <a href='logout.php'>Logout</a></td>";
                        }        
					   else
                        {
                        echo "<td> <a href='login.php'>Login</a></td>";
                        }
                ?>  

        </tr>
        </table>
        </td>
        </tr>
 <?php//3nd row:?>
<tr><td>

                <table width=100% height=500 border=0 cellpadding=10 cellspacing=0>
                <tr valign=top>

                <td width=135 bgcolor=#BBBBDD>
                <center>
                <b> Product Category</b>
                <?php
                $link=connect_db();
                $sql="select * from category";
                $result = mysql_query($sql, $link);
                while($row = mysql_fetch_array($result))
                {
                //echo $row['category_name']."<br>";
                echo "<a href='category.php?cat_id=$row[category_id]'> $row[category_name]</a> <br>";
                }
                ?>
                </center>

                </td>
                <td bgcolor=#EDEDDC>
