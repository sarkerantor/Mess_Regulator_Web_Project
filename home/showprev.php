<?php
    session_start();
    include "../config/db.php";
    $id=$_SESSION['id'];
    $curval=$_SESSION['history_curr_val'];
    $cost=$curval."cost".$id;
    $deposit=$curval."deposit".$id;
    $curmonth=$curval.$id;

    $totalcost=0;
    $totalmeal=0;

    $costtable="SELECT * FROM $cost";
    $res=$con->query($costtable);
    while($row=$res->fetch_assoc()){
        $totalcost+=$row['amount'];
    }

    $meal="SELECT * FROM $curmonth";
    $res=$con->query($meal);
    while($row=$res->fetch_assoc()){
        $totalmeal+=$row['Total_meal'];
    }

    $mealcharge = ($totalmeal > 0) ? ($totalcost/$totalmeal) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- Header Card -->
    <div class="card shadow-lg mb-4">
        <div class="card-body text-center">
            <h2 class="fw-bold text-primary">Monthly Transaction Report</h2>
            <?php
                $month=strtoupper($curval[0]).$curval[1].$curval[2];
                $year=$curval[3].$curval[4].$curval[5].$curval[6];
            ?>
            <h5 class="text-muted"><?php echo $month . " " . $year; ?></h5>

            <div class="mt-3">
                <h4 class="badge bg-success p-3">
                    Meal Charge = <?php echo number_format($mealcharge,2); ?> ৳
                </h4>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Total Meal</th>
                            <th>Deposit</th>
                            <th>Cost</th>
                            <th>Final Balance</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        $sql="SELECT * FROM $curmonth";
                        $res=$con->query($sql);

                        while($row=$res->fetch_assoc()){
                            $name=$row['name'];
                            $contact=$row['contact'];
                            $tmeal=$row['Total_meal'];

                            $sql1="SELECT balance FROM $deposit WHERE name='$name' AND contact='$contact'";
                            $res1=$con->query($sql1);
                            $val=$res1->fetch_assoc();
                            $tdeposit=$val['balance'];

                            $percost=ceil($mealcharge*$tmeal);
                            $final=$tdeposit-$percost;

                            $balanceClass = ($final >= 0) ? "text-success fw-bold" : "text-danger fw-bold";

                            echo "<tr>";
                            echo "<td>$name</td>";
                            echo "<td>$contact</td>";
                            echo "<td>$tmeal</td>";
                            echo "<td>৳ ".number_format($tdeposit,2)."</td>";
                            echo "<td>৳ ".number_format($percost,2)."</td>";
                            echo "<td class='$balanceClass'>৳ ".number_format($final,2)."</td>";
                            echo "</tr>";
                        }
                    ?>

                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer text-center bg-white border-0 py-4">
            <a href="dashboard.php" 
            class="btn btn-primary btn-lg px-5 shadow-sm rounded-pill">
                <i class="bi bi-speedometer2 me-2"></i>
                Go to Dashboard
            </a>
        </div>
        <div class="card-footer bg-light border-0 py-4">

    </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>