<?php
session_start();
include "config/db.php";
$id=$_SESSION['id'];
$mail=$_SESSION['mail'];
$messname=$_SESSION['mess_name'];
//echo "id=".$id."<br>mail=".$mail."<br>messname=".$messname."<br>";
if(!isset($_SESSION['mail'])){
    header("Location: signup.php");
    exit();
}

if(isset($_POST['set_date'])){
    $month = strtolower($_POST['month']);
    $year = $_POST['year'];
    $curr_val = $month . $year; 
    $email = $_SESSION['mail'];

    $user_query = "SELECT id FROM admin WHERE mail = '$email'";
    $user_result = mysqli_query($con, $user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $admin_id = $user_data['id'];

    $update_sql = "UPDATE admin SET curval = '$curr_val' WHERE mail = '$email'";

    if(mysqli_query($con, $update_sql)){

        $deposit_table = $curr_val . "deposit" . $admin_id;
        $costs_table = $curr_val . "cost" . $admin_id;
        $meal_table = $curr_val . $admin_id; 
        $rule_table="rule".$admin_id;
        $sql_rule = "CREATE TABLE IF NOT EXISTS `$rule_table` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            descr varchar(255)not null
        )";
        $sql_deposit = "CREATE TABLE IF NOT EXISTS `$deposit_table` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            contact VARCHAR(20) NOT NULL,
            balance DECIMAL(10,2) DEFAULT 0.00
        )";

        $sql_costs = "CREATE TABLE IF NOT EXISTS `$costs_table` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            Dates DATE NOT NULL,
            description TEXT NOT NULL,
            amount DECIMAL(10,2) NOT NULL
        )";
        //utility table start
        $utility_table = $curr_val . "_utility_" . $admin_id;

        $sql_utility = "CREATE TABLE IF NOT EXISTS `$utility_table` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            contact VARCHAR(20) NOT NULL UNIQUE,
            house_rent DECIMAL(10,2) DEFAULT 0,
            h_status ENUM('Due', 'Paid') DEFAULT 'Due',
            electric_bill DECIMAL(10,2) DEFAULT 0,
            e_status ENUM('Due', 'Paid') DEFAULT 'Due',
            internet_bill DECIMAL(10,2) DEFAULT 0,
            i_status ENUM('Due', 'Paid') DEFAULT 'Due',
            gas_bill DECIMAL(10,2) DEFAULT 0,
            g_status ENUM('Due', 'Paid') DEFAULT 'Due',
            garbage_bill DECIMAL(10,2) DEFAULT 0,
            gr_status ENUM('Due', 'Paid') DEFAULT 'Due',
            shef_bill DECIMAL(10,2) DEFAULT 0,
            s_status ENUM('Due', 'Paid') DEFAULT 'Due'
        )";
        mysqli_query($con, $sql_utility);
        //utility table end
        $day_columns = "";
        for ($i = 1; $i <= 31; $i++) {
            $day_columns .= "d_$i INT DEFAULT 0, ";
        }

        $sql_meals = "CREATE TABLE IF NOT EXISTS `$meal_table` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            contact VARCHAR(20) NOT NULL,
            $day_columns
            Total_meal INT DEFAULT 0
        )";

        if(mysqli_query($con, $sql_deposit) && mysqli_query($con, $sql_costs) &&
         mysqli_query($con, $sql_meals) && mysqli_query($con, $sql_rule)){
            $_SESSION['curval'] = $curr_val;
            header("Location: home/dashboard.php");
            exit();
        } else {
            $error = "Table Creation Error: " . mysqli_error($con);
        }

    } else {
        $error = "Update Failed: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finish Setup - Mess Regulator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1cc88a, #4e73df);
        }
        .card { border-radius: 1rem; border: none; }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-9 col-md-7 col-lg-5">
            <div class="card shadow-lg p-4 p-md-5 text-center">
                <div class="mb-4">
                    <h2 class="text-success fw-bold">Congratulations! 🎉</h2>
                    <p class="text-muted">Final step: Initialize your mess database for this month.</p>
                </div>

                <?php if(isset($error)){ ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <form method="POST">
                    <div class="row g-3 text-start">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Select Month</label>
                            <select name="month" class="form-select" required>
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
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Select Year</label>
                            <select name="year" class="form-select" required>
                                <?php 
                                    $currentYear = date("Y");
                                    for($i = $currentYear; $i <= $currentYear + 75; $i++){
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="set_date" class="btn btn-primary w-100 py-2 shadow-sm fw-bold mt-3">
                            Finish & Go to Dashboard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>






