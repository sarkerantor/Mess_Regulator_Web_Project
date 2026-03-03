<?php
    session_start();
    include "../config/db.php";
    if(!isset($_SESSION["id"])){
        die("Unauthorized access");
    }
    $id = $_SESSION["id"];
    $ruletable = "rule".$id;
    if(isset($_GET['ruledelid'])){
        $delid = $_GET['ruledelid'];
        $sql="DELETE FROM $ruletable WHERE id=$delid";
        if($con->query($sql)){
            header("Location: rule.php");
            exit();
        }else{
            echo "Delete Failed";
        }
    }else{
        echo "Invalid Request";
    }
?>