<?php
session_start();
include "../config/db.php";

$id = $_SESSION['id'];
$curval = $_SESSION['curval'];
$tablename = $curval.$id;
$sql="SELECT * FROM $tablename";
$res=$con->query($sql);

while($val=$res->fetch_assoc()){
    $total=0;
    for($i=1;$i<=31;$i++){
        $idx="d_".$i;
        $total += (int)$val[$idx];
    }

    $name=$val['name'];
    $contact=$val['contact'];

    $totalset="UPDATE $tablename 
               SET total_meal=$total 
               WHERE name='$name' AND contact='$contact'";
    $con->query($totalset);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Meal Report</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #eef2f3, #d9e4f5);
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

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h4 class="mb-0 fw-bold">📊 Meal Report Table</h4>
        </div>

        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">

                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <?php
                                for($i=1;$i<=31;$i++){
                                    echo "<th class='day-cell'>".$i."</th>";
                                }
                            ?>
                            <th class="bg-success text-white">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        $sql = "SELECT * FROM $tablename";
                        $res = $con->query($sql);
                        $member_count = $res->num_rows;

                        while($val = $res->fetch_assoc()){

                            echo "<tr>";

                            echo "<td class='fw-semibold text-primary'>".$val['name']."</td>";
                            echo "<td>".$val['contact']."</td>";

                            $rowsum = 0;

                            for($i=1;$i<=31;$i++){
                                $day="d_".$i;
                                $meal = $val[$day];
                                $rowsum += (int)$meal;

                                if($meal == 0 || $meal == ""){
                                    echo "<td class='text-muted'>-</td>";
                                } else {
                                    echo "<td>".$meal."</td>";
                                }
                            }

                            echo "<td class='table-success fw-bold total-cell'>".$rowsum."</td>";
                            echo "</tr>";
                        }
                    ?>
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer text-center text-muted fw-semibold">
            Total Members: <?php echo $member_count; ?>
        </div>
    </div>

    <!-- Buttons Section -->
    <div class="text-center mt-4">

        <a href="updatemeal.php" class="btn btn-warning btn-lg shadow me-2">
            ✏️ Update Your Meal Details
        </a>

        <a href="showdetail.php" class="btn btn-info btn-lg shadow me-2">
            🔍 Show Details
        </a>

        <a href="dashboard.php" class="btn btn-success btn-lg shadow">
            🚀 Go to Dashboard
        </a>

    </div>

</div>

</body>
</html>