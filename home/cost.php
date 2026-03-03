<?php
    session_start();
    include "../config/db.php";
    $id=$_SESSION['id'];
    $curval=$_SESSION['curval'];
    $tablename=$curval."cost".$id;
    //echo "curval=".$curval." id=".$id;
    if(isset($_POST['submit'])){
        $dates=$_POST['dates'];
        $description=$_POST['description'];
        $amount=$_POST['amount'];

        $sql="INSERT INTO $tablename (dates,description,amount) 
              VALUES('$dates','$description','$amount')";

        if($con->query($sql)){
            header("Location:cost.php");
            exit();
        }
        else{
            echo "Error";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <!-- Cost List Card -->
    <div class="card shadow-lg mb-5">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">All Cost List of Your Mess</h3>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount (৳)</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql="SELECT * FROM $tablename ORDER BY dates DESC";
                    $res=$con->query($sql);

                    if($res && $res->num_rows>0){
                        while($val=$res->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>".$val['Dates']."</td>";
                            echo "<td>".$val['description']."</td>";
                            echo "<td class='fw-bold text-success'>".$val['amount']."</td>";
                            echo "<td><a class='btn btn-danger btn-sm' 
                                    href='deletecost.php?delid=".$val['id']."' 
                                    onclick=\"return confirm('Are you sure to delete?')\">
                                    Delete</a></td>";
                            echo "</tr>";
                        }
                    }else{
                        echo "<tr>
                                <td colspan='3' class='text-muted'>
                                    No Cost Found
                                </td>
                              </tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Cost Form Card -->
    <div class="card shadow">
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0">Add New Cost Record</h4>
        </div>

        <div class="card-body">
            <form method="post">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" name="dates" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Enter description" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount" required>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <button type="submit" name="submit" class="btn btn-success px-5">
                            Add Cost
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>
    <div class="text-center my-4">
        <a href="dashboard.php" class="btn btn-outline-primary btn-lg shadow">
            <i class="bi bi-house-door-fill"></i> Go To Dashboard
        </a>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>