<?php
session_start();
    include "../config/db.php";

if(!isset($_SESSION['mail'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['view_history'])){
    $month = strtolower($_POST['month']);
    $year = $_POST['year'];
    $_SESSION['history_curr_val'] = $month . $year;
    header("Location: previousmonth.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Previous Month</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #6610f2, #6f42c1); min-height: 100vh; }
        .card { border-radius: 20px; border: none; }
        .btn-lg-custom { padding: 12px 30px; font-size: 1.1rem; border-radius: 10px; }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card shadow-lg p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-calendar-check fa-3x text-primary mb-3"></i>
                    <h2 class="fw-bold">View History</h2>
                    <p class="text-muted">Select the month and year you want to check.</p>
                </div>

                <form method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Month</label>
                            <select name="month" class="form-select form-select-lg" required>
                                <option value="jan">January</option>
                                <option value="feb">February</option>
                                <option value="mar">March</option>
                                <option value="apr">April</option>
                                <option value="may">May</option>
                                <option value="jun">June</option>
                                <option value="jul">July</option>
                                <option value="aug">August</option>
                                <option value="sep">September</option>
                                <option value="oct">October</option>
                                <option value="nov">November</option>
                                <option value="dec">December</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Year</label>
                            <select name="year" class="form-select form-select-lg" required>
                                <?php 
                                    $y = date("Y");
                                    for($i = $y; $i >= $y - 5; $i--){ echo "<option value='$i'>$i</option>"; }
                                ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" name="view_history" class="btn btn-primary w-100 btn-lg-custom fw-bold mt-4 shadow">
                        <i class="fa-solid fa-magnifying-glass me-2"></i> Show Records
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="dashboard.php" class="text-decoration-none text-muted fw-bold">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>