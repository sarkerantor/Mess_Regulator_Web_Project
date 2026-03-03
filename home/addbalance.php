<?php
    session_start();
    include "../config/db.php";
    if(!isset($_SESSION["id"])){
        die("Unauthorized access");
    }
    $id = $_SESSION["id"];
    $curval = $_SESSION['curval'];
    $tablename = $curval."deposit".$id;
    if(isset($_POST['submit'])){
        if(isset($_GET['addid']) && isset($_POST['amount'])){
            $addid = $_GET['addid'];
            $amount = (int)$_POST['amount'];
            if($amount <= 0){
                die("Invalid Amount");
            }
            $sql = "UPDATE $tablename SET balance = balance + $amount WHERE id = '$addid'";
            if($con->query($sql)){
                header("Location: deposit.php");
                exit();
            }else{
                echo "Update Failed";
            }
        }else{
            echo "Invalid Request Data";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Balance</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px;">
        <h4 class="text-center mb-4">Add Balance</h4>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Enter Amount</label>
                <input type="number" name="amount" class="form-control" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-primary">
                    Add Balance
                </button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>