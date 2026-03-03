<?php
session_start();
$id=$_SESSION['id'];
//echo "id=".$id."<br>";
include "../config/db.php";

if(!isset($_SESSION['mail'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['mail'];
$sql = "SELECT contact, details FROM admin WHERE mail = '$email'";
$result = $con->query($sql);
$row = $result->fetch_assoc();

if(isset($_POST['update'])){
    $new_contact = mysqli_real_escape_string($con, $_POST['contact']);
    $new_details = mysqli_real_escape_string($con, $_POST['details']);

    $update_sql = "UPDATE admin SET contact = '$new_contact', details = '$new_details' WHERE mail = '$email'";

    if($con->query($update_sql)){
        header("Location: manager_info.php");
        exit();
    } else {
        $error = "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Manager Info</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .update-card {
            border-radius: 20px;
            border: none;
            padding: 40px;
        }
        .form-label {
            font-size: 1.3rem;
            font-weight: 700;
            color: #4e73df;
        }
        .form-control {
            font-size: 1.1rem;
            padding: 12px;
            border-radius: 10px;
            border: 2px solid #dee2e6;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: none;
        }
        .btn-lg-custom {
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 10px;
            transition: 0.3s;
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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            
            <div class="card shadow-lg update-card">
                <h2 class="fw-bold text-center mb-5 text-dark">
                    <i class="fa-solid fa-user-gear me-2 text-primary"></i> Update Information
                </h2>
                
                <?php if(isset($error)){ echo "<div class='alert alert-danger'>$error</div>"; } ?>

                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact" class="form-control" value="<?php echo $row['contact']; ?>" required>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Manager Details</label>
                        <textarea name="details" class="form-control" rows="8" required><?php echo $row['details']; ?></textarea>
                    </div>

                    <div class="d-grid gap-3">
                        <button type="submit" name="update" class="btn btn-success btn-lg-custom fw-bold shadow">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i> Save Updated Info
                        </button>
                        <a href="manager_info.php" class="btn btn-light btn-lg-custom fw-bold border">Cancel</a>
                    </div>
                </form>
            </div>

            <div class="text-center mt-4">
                <a href="dashboard.php" class="btn btn-outline-dark btn-lg-custom fw-bold mt-5 mb-5 shadow-sm">
                    <i class="fa-solid fa-house-chimney me-2"></i> Back to Dashboard
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