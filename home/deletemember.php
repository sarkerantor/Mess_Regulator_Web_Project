<?php
    session_start();
    include "../config/db.php";
    if(!isset($_SESSION["id"])){
        die("Unauthorized access");
    }
    $id = $_SESSION["id"];
    $curval=$_SESSION['curval'];
    $tablename=$curval."deposit".$id;
    if(isset($_GET['delid'])){
        $delid = $_GET['delid'];
        $sql="DELETE FROM $tablename WHERE id=$delid";
        $sqlall="SELECT * FROM $tablename WHERE id=$delid";
        $res=$con->query($sqlall);
        $row=$res->fetch_assoc();
        $name=$row["name"];
        $contact=$row["contact"];
        $monthtable=$curval.$id;
        $sql1="DELETE FROM $monthtable WHERE name='$name' and contact='$contact'";
        if($con->query($sql1)){
            if($con->query($sql)){
                header("Location:allmember.php");
                exit();
            }
            else {
                echo "Error";
            }
            
        }else{
            echo "Delete Failed";
        }
    }else{
        echo "Invalid Request";
    }
?>