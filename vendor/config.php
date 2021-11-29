<?php
$connection=mysqli_connect("localhost","root",null,"inimesed");
$connection->set_charset('UTF-8');
if (!$connection){
    die("Error connect to database");
}



?>