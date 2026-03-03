<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['mail'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['mail'];
$sql = "SELECT * FROM admin WHERE mail = '$email'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Information</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .info-card { 
            border-radius: 20px; 
            overflow: hidden; 
            border: none;
        }
        .left-box { 
            background: #ffffff; 
            border-right: 2px solid #f0f2f5; 
            padding: 60px 40px !important;
        }
        .right-box { 
            background: #ffffff; 
            padding: 60px 50px !important;
        }
        .profile-icon { 
            font-size: 120px; 
            color: #4e73df; 
            margin-bottom: 20px;
        }
        .manager-name {
            font-size: 2rem; 
            font-weight: 800;
        }
        .contact-title {
            font-size: 1.25rem;
            color: #333;
        }
        .contact-val {
            font-size: 1.5rem; 
            font-weight: 600;
            color: #1cc88a;
        }
        .about-title {
            font-size: 1.8rem;
            border-bottom: 3px solid #4e73df;
            display: inline-block;
        }
        .details-text {
            font-size: 1.2rem; 
            line-height: 1.8;
            color: #444;
            text-align: justify;
        }
        .social-icons i { 
            font-size: 30px; 
            margin: 0 15px; 
            color: #4e73df; 
            transition: 0.3s;
        }
        .social-icons i:hover { transform: scale(1.2); color: #1cc88a; }
        .btn-lg-custom {
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
                    <li class="nav-item"><a class="nav-link text-warning" href="logout.php">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-lg info-card">
                <div class="row g-0">
                    <div class="col-md-5 left-box text-center">
                        <div class="profile-icon">
                            <i class="fa-solid fa-circle-user"></i>
                        </div>
                        <h2 class="manager-name text-dark mb-1"><?php echo $row['mess_name']; ?></h2>
                        <p class="text-muted fs-5">Chief Manager</p>
                        
                        <hr class="my-4">
                        
                        <p class="contact-title fw-bold mb-1">
                            <i class="fa-solid fa-phone-volume me-2 text-success"></i>Contact Number
                        </p>
                        <p class="contact-val"><?php echo $row['contact']; ?></p>
                        
                        <div class="social-icons mt-5">
                            <a href="https://www.facebook.com/"><i class="fa-brands fa-facebook"></i></a>
                            <a href="https://www.whatsapp.com/"><i class="fa-brands fa-whatsapp"></i></a>
                            <a href="https://www.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
                        </div>
                    </div>

                    <div class="col-md-7 right-box">
                        <h3 class="about-title fw-bold text-primary mb-4">
                            <i class="fa-solid fa-file-lines me-2"></i>Manager Details
                        </h3>
                        <div class="details-text p-4 bg-light rounded shadow-sm">
                            <?php echo nl2br($row['details']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="update_manager.php" class="btn btn-primary btn-lg-custom fw-bold shadow">
                    <i class="fa-solid fa-user-pen me-2"></i> Update Manager Info
                </a>
                <a href="dashboard.php" class="btn btn-outline-dark btn-lg-custom ms-3 fw-bold">
                    <i class="fa-solid fa-house me-2"></i> Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
    <footer class="bg-dark text-white text-center p-3">
        &copy; Antor Sarker 2026 | All Rights Reserved
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>