<?php
    $server="localhost";
    $user="root";
    $password="";
    $dbname="messregulator";
    $con=new mysqli($server,$user,$password,$dbname);
    if($con->connect_error){
        die("connection failed.".$con->connect_error);
    }
?>