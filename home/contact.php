<?php
    session_start(); 
    include "../config/db.php";
    $id = $_SESSION['id'];  
    //echo "id=".$id."<br>";
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
                    <a class="nav-link active" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="help.php">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
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
    <!-- Contact Section -->
        <div class="container mt-4">

            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="fa-solid fa-address-card me-2"></i>Contact Information</h4>
                </div>

                <div class="card-body text-center">
                    <p class="fs-5">
                        <i class="fa-solid fa-location-dot text-primary me-2"></i>
                        Address: Barishal
                    </p>

                    <p class="fs-5">
                        <i class="fa-solid fa-phone text-success me-2"></i>
                        Phone: 01879667004
                    </p>

                    <p class="fs-5">
                        <i class="fa-solid fa-envelope text-danger me-2"></i>
                        Email: antor.s.cse10.bu@gmail.com
                    </p>
                </div>

                <div class="card-footer text-muted text-center">
                    Feel free to contact us anytime
                </div>
            </div>

        </div>
        <!-- Footer -->
        <footer class="bg-dark text-white text-center mt-5 p-3">
            &copy; returnZero 2026 | All Rights Reserved
        </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>