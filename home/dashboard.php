<?php
session_start(); 
include "../config/db.php";

// id finder 
$id = $_SESSION['id'];

$sql = "SELECT mess_name, curval FROM admin WHERE id=$id";
$result = $con->query($sql);

if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();
    $messname = $row["mess_name"];
    $curval = $row["curval"];
    $_SESSION['curval'] = $curval;
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

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

<!-- Custom Background CSS -->
<style>
body.custom-bg {
    /* Gradient background: purple to blue */
    background: linear-gradient(135deg, #b357f4, #558df49f);
    min-height: 100vh;
    color: #fff; /* Text color white for contrast */
}

.navbar, footer {
    /* Optional: slightly darker overlay for navbar and footer */
    background-color: rgba(0, 0, 0, 0.6) !important;
}

.card {
    background-color: rgba(255, 255, 255, 0.95);
    color: #000;
}

.btn-outline-primary, .btn-outline-secondary, .btn-outline-success, .btn-outline-danger, .btn-outline-warning {
    color: #1e3c72;
    border-color: #1e3c72;
}

.btn-outline-primary:hover, .btn-outline-secondary:hover, .btn-outline-success:hover, 
.btn-outline-danger:hover, .btn-outline-warning:hover {
    background-color: #1e3c72;
    color: #fff;
}
</style>
</head>

<body class="custom-bg">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">Mess Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="help.php">Help</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="logout.php">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <!-- Header -->
    <div class="text-center mb-4">
        <h2 class="fw-bold">Mess Name : <?php echo $messname; ?></h2>
    </div>

    <!-- Member Management -->
    <div class="text-center mb-4">
        <a href="allmember.php" class="btn btn-outline-primary px-4 py-2 fw-bold">
            <i class="fa-solid fa-users me-2"></i> All Members
        </a>
    </div>

    <!-- Manager Info -->
    <div class="card shadow border-0 mb-4 mx-auto" style="max-width: 500px;">
        <div class="card-body text-center">
            <h5 class="fw-bold text-primary mb-3">
                <i class="fa-solid fa-user-tie me-2"></i> Manager Information
            </h5>

            <p class="text-muted">
                View and manage mess manager details from here.
            </p>

            <div class="d-grid gap-2 mt-3">
                <a href="update_manager.php" class="btn btn-outline-primary fw-bold">
                    <i class="fa-solid fa-address-card me-2"></i> View Manager Info
                </a>
            </div>
        </div>
    </div>

    <!-- Options -->
    <div class="row text-center mb-5">
        <div class="col-md-4 mb-3">
            <a href="deposit.php" class="btn btn-success w-100 p-3">
                <i class="fa-solid fa-money-bill-wave"></i> Add Deposit
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="cost.php" class="btn btn-danger w-100 p-3">
                <i class="fa-solid fa-cart-shopping"></i> Add Cost
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="rule.php" class="btn btn-warning w-100 p-3">
                <i class="fa-solid fa-book"></i> Rules
            </a>
        </div>
    </div>

    <!-- Current Balance -->
    <div class="text-center mb-5">
        <div class="card shadow-sm border-0 mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h5 class="fw-bold mb-3">
                    <i class="fa-solid fa-wallet text-success me-2"></i>
                    Current Balance
                </h5>

                <p class="text-muted">
                    Click below to view full transaction and current balance details.
                </p>

                <a href="transaction.php" class="btn btn-primary w-100 fw-bold">
                    <i class="fa-solid fa-eye me-2"></i> Show Balance
                </a>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow">
                <div class="card-body text-center">

                    <h5 class="fw-bold mb-4 text-primary">
                        <i class="fa-solid fa-receipt me-2"></i>
                        Transaction History
                    </h5>

                    <div class="d-grid gap-3">
                        <a href="previousmonth_input.php" class="btn btn-outline-secondary fw-bold py-3">
                            <i class="fa-solid fa-calendar-minus me-2"></i>
                            Previous Month
                        </a>

                        <a href="currentmonth.php" class="btn btn-outline-success fw-bold py-3">
                            <i class="fa-solid fa-calendar-day me-2"></i>
                            Current Month
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- House Rent & Utility Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-body text-center">

                    <h5 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-house me-2"></i>
                        House Rent & Utility Bills
                    </h5>

                    <p class="text-muted">
                        View and manage monthly house rent, electricity, water and other utility expenses from here.
                    </p>

                    <div class="d-grid gap-2 mt-3">
                        <a href="utility.php" class="btn btn-outline-primary fw-bold py-2">
                            <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                            Show Rent & Utility Details
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center p-3">
    &copy; returnZero 2026 | All Rights Reserved
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>