<?php
    session_start(); 
    include "../config/db.php";
    $id = $_SESSION['id'];  
    $sql = "SELECT mess_name, curval FROM admin WHERE id=$id";
    $result = $con->query($sql);
    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        $messname = $row["mess_name"];
        $curval = $row["curval"];
        $_SESSION['curval']=$curval;
    } else {
        die("Data not found");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mess Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">
            <i class="fa-solid fa-house me-2"></i>Mess Dashboard
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="help.php">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="logout.php">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Header Section -->
<div class="container mt-5">

    <!-- Mess Name Card -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body text-center bg-white">
            <h2 class="fw-bold text-primary">
                <i class="fa-solid fa-building me-2"></i>
                <?php echo $messname; ?>
            </h2>
        </div>
    </div>
    <!-- About Section -->
    <div class="card shadow border-0">
        <div class="card-body bg-white">

            <h4 class="fw-bold text-primary mb-3">
                <i class="fa-solid fa-circle-info me-2"></i>About Our Mess Regulator
            </h4>

            <p class="text-muted">
                This Mess Regulator website is designed to manage all mess related accounts and information in one place.
                It helps members and admin to easily track deposits, costs, balances, and other important records.
            </p>

            <div class="row mt-4">

                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body">
                            <i class="fa-solid fa-users fa-2x text-primary mb-3"></i>
                            <h6 class="fw-bold">Member Management</h6>
                            <p class="small text-muted">
                                Add, update, and manage all mess members easily.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body">
                            <i class="fa-solid fa-money-bill-wave fa-2x text-success mb-3"></i>
                            <h6 class="fw-bold">Expense & Deposit Tracking</h6>
                            <p class="small text-muted">
                                Keep track of daily expenses and member deposits without confusion.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body">
                            <i class="fa-solid fa-chart-line fa-2x text-warning mb-3"></i>
                            <h6 class="fw-bold">Clear Reports</h6>
                            <p class="small text-muted">
                                View balance reports and financial summaries quickly and clearly.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="alert alert-primary mt-4">
                <i class="fa-solid fa-lightbulb me-2"></i>
                Our goal is to make mess management simple, transparent, and stress-free for everyone.
            </div>

        </div>
    </div>
    <!-- about mess end -->
        <!-- Footer -->
        <footer class="bg-dark text-white text-center mt-5 p-3">
            &copy; returnZero 2026 | All Rights Reserved
        </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>