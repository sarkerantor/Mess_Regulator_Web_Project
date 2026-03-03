<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['mail'])){ header("Location: login.php"); exit(); }

$error_msg = "";

if(isset($_POST['init_next_month'])){
    $email = $_SESSION['mail'];
    $month = strtolower($_POST['month']);
    $year = $_POST['year'];
    $new_curr_val = $month . $year;

    $selected_time = strtotime("01-" . $month . "-" . $year);
    $current_time = strtotime("01-" . date("m-Y"));

    if($selected_time < $current_time){
        $error_msg = "Error: You cannot initialize a past month!";
    } else {
        $u_res = $con->query("SELECT id, curval FROM admin WHERE mail = '$email'");
        $u_row = $u_res->fetch_assoc();
        $admin_id = $u_row['id'];
        $old_curr_val = $u_row['curval'];

        $new_meal_table = $new_curr_val . $admin_id;
        $check_exists = $con->query("SHOW TABLES LIKE '$new_meal_table'");

        if($check_exists->num_rows > 0){
            $error_msg = "Error: This month is already initialized!";
        } else {
            $con->query("UPDATE admin SET curval = '$new_curr_val' WHERE id = $admin_id");
            $_SESSION['curval'] = $new_curr_val;

            $new_deposit_table = $new_curr_val . "deposit" . $admin_id;
            $new_cost_table = $new_curr_val . "cost" . $admin_id;
            $utility_table = $new_curr_val . "_utility_" . $admin_id;
            $old_meal_table = $old_curr_val . $admin_id;

            $day_cols = "";
            for($i=1; $i<=31; $i++){ $day_cols .= "d_$i INT DEFAULT 0, "; }

            $con->query("CREATE TABLE IF NOT EXISTS `$new_deposit_table` (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), contact VARCHAR(20), balance DECIMAL(10,2) DEFAULT 0)");
            $con->query("CREATE TABLE IF NOT EXISTS `$new_cost_table` (id INT AUTO_INCREMENT PRIMARY KEY, Dates DATE, description TEXT, amount DECIMAL(10,2))");
            $con->query("CREATE TABLE IF NOT EXISTS `$new_meal_table` (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), contact VARCHAR(20), $day_cols Total_meal INT DEFAULT 0)");

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

            $check_old = $con->query("SHOW TABLES LIKE '$old_meal_table'");
            if($check_old->num_rows > 0){
                $old_members = $con->query("SELECT name, contact FROM `$old_meal_table` ");
                while($m = $old_members->fetch_assoc()){
                    $m_name = mysqli_real_escape_string($con, $m['name']); 
                    $m_con = mysqli_real_escape_string($con, $m['contact']);
                    $con->query("INSERT INTO `$new_meal_table` (name, contact) VALUES ('$m_name', '$m_con')");
                    $con->query("INSERT INTO `$new_deposit_table` (name, contact) VALUES ('$m_name', '$m_con')");
                    $con->query("INSERT IGNORE INTO `$utility_table` (name, contact) VALUES ('$m_name', '$m_con')");
                }
            }
            header("Location: dashboard.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Initialize Month</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="card shadow p-5 text-center" style="max-width: 500px; border-radius: 20px; width: 100%;">
        <h3 class="fw-bold mb-4 text-primary">Initialize New Month</h3>
        
        <?php if($error_msg != ""): ?>
            <div class="alert alert-danger fw-bold"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <form method="POST">
            <select name="month" class="form-select mb-3" required>
                <?php
                $months = ["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"];
                foreach($months as $m){
                    $selected = ($m == strtolower(date('M'))) ? "selected" : "";
                    echo "<option value='$m' $selected>".ucfirst($m)."</option>";
                }
                ?>
            </select>
            <select name="year" class="form-select" required>
                <?php 
                    $currentYear = date("Y");
                    for($i = $currentYear; $i <= $currentYear + 5; $i++){
                        echo "<option value='$i'>$i</option>";
                    }
                ?>
            </select>
            <button type="submit" name="init_next_month" class="btn btn-primary w-100 fw-bold py-2 mt-4">Start New Month</button>
        </form>

        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-dark px-4 fw-bold shadow">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>