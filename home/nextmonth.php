<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['mail'])){ header("Location: login.php"); exit(); }

$email = $_SESSION['mail'];
$u_res = $con->query("SELECT id, curval FROM admin WHERE mail = '$email'");
$u_row = $u_res->fetch_assoc();
$admin_id = $u_row['id'];
$current_val = $u_row['curval'];

$meal_table = $current_val . $admin_id;
$depo_table = $current_val . "deposit" . $admin_id;

if(isset($_POST['add_member'])){
    $name = mysqli_real_escape_string($con, $_POST['m_name']);
    $contact = mysqli_real_escape_string($con, $_POST['m_contact']);
    $con->query("INSERT INTO `$meal_table` (name, contact) VALUES ('$name', '$contact')");
    $con->query("INSERT INTO `$depo_table` (name, contact) VALUES ('$name', '$contact')");
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $con->query("DELETE FROM `$meal_table` WHERE id = $id");
    $con->query("DELETE FROM `$depo_table` WHERE id = $id");
    header("Location: nextmonth.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light p-4">
    <div class="container">
        <div class="card shadow border-0 p-4 mb-4 text-center">
            <h2 class="fw-bold">Members of <?php echo strtoupper($current_val); ?></h2>
        </div>

        <div class="card shadow border-0 p-4 mb-4">
            <table class="table table-hover text-center">
                <thead class="table-dark">
                    <tr><th>SL</th><th>Name</th><th>Contact</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php
                    $res = $con->query("SELECT * FROM `$meal_table` ");
                    if($res && $res->num_rows > 0){
                        $sl = 1;
                        while($row = $res->fetch_assoc()){
                            echo "<tr>
                                    <td>$sl</td><td>{$row['name']}</td><td>{$row['contact']}</td>
                                    <td><a href='?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Remove member?\")'><i class='fa-trash'></i> Delete</a></td>
                                  </tr>";
                            $sl++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="dashboard.php" class="btn btn-dark px-4 fw-bold shadow">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>