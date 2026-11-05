<?php
$dbconnection = mysqli_connect('localhost','root','','login-registration-system');

if(!$dbconnection){
    die('Error: ' . mysqli_connect_error());
}


?>