<?php include('config.php');

if(!empty($_POST['name']) && !empty($_POST['actionType']))
{
    if($_POST['actionType']=='u')
    {
        $name=$_POST['name'];
        $email=$_POST['email'];
        $sql="INSERT INTO info (name, email) VALUES('$name','$email')";
        if(mysqli_query($conn,$sql))
        {
            echo "200"; //OK
        }
        else
        {
            echo "500"; //Internal Server Error
        }
    }
    else
    {
        echo '403'; //Forbidden
    }
}
else
{
    echo '400'; //Bad Request
}
exit();
?>