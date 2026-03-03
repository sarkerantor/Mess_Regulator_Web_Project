<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['mail']) || !isset($_SESSION['history_curr_val'])){
    header("Location: dashboard.php");
    exit();
}

$email = $_SESSION['mail'];
$history_val = $_SESSION['history_curr_val'];

$user_sql = "SELECT id FROM admin WHERE mail = '$email'";
$user_res = $con->query($user_sql);
$user_data = $user_res->fetch_assoc();
$admin_id = $user_data['id'];

$meal_table = $history_val . $admin_id;
// $_SESSION['prevmonth']=$meal_table;
$check_table = $con->query("SHOW TABLES LIKE '$meal_table'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Meal History - <?php echo strtoupper($history_val); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body {
    background: linear-gradient(135deg, #eef2f3, #d9e4f5);
}

.history-header {
    background: linear-gradient(45deg, #0d6efd, #0dcaf0);
    color: white;
    border-radius: 12px;
    padding: 25px;
}

.table thead th {
    font-size: 13px;
}

.table tbody td {
    font-size: 14px;
}

.day-cell {
    min-width: 40px;
}

.total-cell {
    font-size: 15px;
}
</style>
</head>

<body>

<div class="container py-5">

    <!-- Header Card -->
    <div class="history-header text-center shadow mb-4">
        <h2 class="fw-bold mb-2">
            <i class="fa-solid fa-clock-rotate-left me-2"></i>
            Meal History
        </h2>
        <span class="badge bg-light text-dark fs-6 px-4 py-2">
            <?php echo strtoupper($history_val); ?>
        </span>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            <?php if($check_table->num_rows > 0): ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">

                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Member</th>
                                <th>Contact</th>
                                <?php for($d=1; $d<=31; $d++): ?>
                                    <th class="day-cell"><?php echo $d; ?></th>
                                <?php endfor; ?>
                                <th class="bg-success text-white">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $data_query = "SELECT * FROM `$meal_table`";
                        $data_res = $con->query($data_query);

                        while($row = $data_res->fetch_assoc()):
                            $row_sum = 0;
                            for($i=1; $i<=31; $i++) {
                                $row_sum += (int)$row['d_'.$i];
                            }
                        ?>
                            <tr>
                                <td class="fw-bold"><?php echo $row['id']; ?></td>
                                <td class="fw-semibold text-primary">
                                    <?php echo $row['name']; ?>
                                </td>
                                <td><?php echo $row['contact']; ?></td>

                                <?php for($d=1; $d<=31; $d++): ?>
                                    <td class="day-cell">
                                        <?php echo $row['d_'.$d] ?: '-'; ?>
                                    </td>
                                <?php endfor; ?>

                                <td class="table-success fw-bold total-cell">
                                    <?php echo $row_sum; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>

                <div class="alert alert-warning text-center py-5 rounded-4 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation fa-3x mb-3 text-warning"></i>
                    <h5 class="fw-bold">
                        No Records Found for "<?php echo strtoupper($history_val); ?>"
                    </h5>
                    <p class="text-muted">
                        Make sure the table was created for this month.
                    </p>
                </div>

            <?php endif; ?>

            <!-- Buttons -->
            <div class="text-center mt-5">

                <a href="dashboard.php"
                   class="btn btn-dark btn-lg px-4 shadow-sm me-2">
                    <i class="fa-solid fa-house me-2"></i> Dashboard
                </a>

                <a href="previousmonth_input.php"
                   class="btn btn-outline-primary btn-lg px-4 shadow-sm me-2">
                    <i class="fa-solid fa-search me-2"></i> Search Month
                </a>

                <a href="showprev.php"
                   class="btn btn-success btn-lg px-4 shadow-sm">
                    <i class="fa-solid fa-money-bill-wave me-2"></i> Show Transaction
                </a>

            </div>

        </div>
    </div>

</div>

</body>
</html>