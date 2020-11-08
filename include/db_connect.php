<?php
//change the host, user and  password to match your connection.
$conn = mysqli_connect("localhost","root","","stenden_twitter");
if(!$conn)
{
    echo "Unable to connect to server ".mysqli_error($conn);

    echo "<br>";

}else{echo "Connection Successful"."<br>";}
