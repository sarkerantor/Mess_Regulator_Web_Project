<?php
    session_start();
    include "../config/db.php";
    if(!isset($_SESSION["id"])){
        die("Unauthorized access");
    }
    $id = $_SESSION["id"];
    $curval=$_SESSION['curval'];
    $tablename=$curval."cost".$id;
    if(isset($_GET['delid'])){
        $delid = $_GET['delid'];
        $sql="DELETE FROM $tablename WHERE id=$delid";
        if($con->query($sql)){
            header("Location:cost.php");
            exit();
        }else{
            echo "Delete Failed";
        }
    }else{
        echo "Invalid Request";
    }
?>