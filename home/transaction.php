<?php
    session_start();
    include "../config/db.php";

    $curval = $_SESSION['curval'];
    $id = $_SESSION['id'];

    $deposittable = $curval ."deposit".$id;
    $costtable = $curval."cost".$id;  

    $alldeposit = 0;
    $allcost = 0;

    $sql = "SELECT * FROM $deposittable";
    $res = $con->query($sql);
    while($val = $res->fetch_assoc()){
        $alldeposit += $val['balance'];
    }

    $sql = "SELECT * FROM $costtable";
    $res = $con->query($sql);
    while($val = $res->fetch_assoc()){
        $allcost += $val['amount'];
    }
    $curbalance = $alldeposit - $allcost;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Summary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Account Summary</h2>
        <p class="text-muted">Total financial overview</p>
    </div>
    <div class="row g-4">
        <!-- Total Deposit -->
        <div class="col-md-4">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title text-success">Total Deposit</h5>
                    <h3 class="fw-bold"><?php echo $alldeposit; ?></h3>
                </div>
            </div>
        </div>
        <!-- Total Cost -->
        <div class="col-md-4">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title text-danger">Total Cost</h5>
                    <h3 class="fw-bold"><?php echo $allcost; ?></h3>
                </div>
            </div>
        </div>
        <!-- Current Balance -->
        <div class="col-md-4">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title text-primary">Current Balance</h5>
                    <h3 class="fw-bold"><?php echo $curbalance; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
           <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card border-0 shadow text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Back to Dashboard</h5>
                            <a href="dashboard.php" class="btn btn-primary w-100">
                                Go to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</body>
</html>