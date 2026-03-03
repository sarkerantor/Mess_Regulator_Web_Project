<?php
session_start();
include "../config/db.php";

$id = $_SESSION['id'];
$curval = $_SESSION['curval'];
$tablename = $curval."deposit".$id;

$message = "";
$msg_type = "";

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $contact = mysqli_real_escape_string($con, $_POST["contact"]);

    $check = "SELECT * FROM $tablename WHERE contact='$contact'";
    $check_res = $con->query($check);

    if($check_res && $check_res->num_rows > 0){
        $message = "This contact number already exists!";
        $msg_type = "danger";
    } 
    else {

        $sql = "INSERT INTO $tablename (name,balance,contact)
                VALUES('$name',0,'$contact')";

        $newtable = $curval.$id;

        $sql1 = "INSERT INTO $newtable (name,contact,d_1,d_2,d_3,total_meal)
                 VALUES('$name','$contact',0,0,0,0)";

        if($con->query($sql) && $con->query($sql1)){
            $message = "Member Added Successfully!";
            $msg_type = "success";
        } 
        else{
            $message = "Something went wrong!";
            $msg_type = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Member List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.card { border-radius: 12px; }
.card-header { font-weight: 600; }
.table-hover tbody tr:hover { background-color: #e9ecef; }
.btn-rounded { border-radius: 50px; }
</style>
</head>
<body>

<div class="container mt-5">

    <!-- Members Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">All Member List of Your Mess</h3>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-striped table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql="SELECT * FROM $tablename";
                $res=$con->query($sql);

                if($res && $res->num_rows>0){
                    while($val=$res->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$val['name']."</td>";
                        echo "<td>".$val['contact']."</td>";
                        echo "<td>
                                <a href='deletemember.php?delid=".$val['id']."' 
                                   class='btn btn-danger btn-sm btn-rounded'>
                                   Delete
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>
                            <td colspan='3' class='text-center text-muted'>
                                No Member Found
                            </td>
                          </tr>";
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- Add Member Form -->
    <div class="card shadow">
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0">Add New Member</h4>
        </div>
        <div class="card-body">

            <!-- Alert Message -->
            <?php if(!empty($message)) { ?>
                <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php } ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter member name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact</label>
                    <input type="text" name="contact" class="form-control" placeholder="Enter contact number" required>
                </div>
                <div class="text-center">
                    <input type="submit" name="submit" class="btn btn-success px-4 btn-rounded" value="Add Member">
                </div>
            </form>

        </div>
    </div>

    <!-- Go to Dashboard -->
    <div class="text-center my-5">
        <a href="dashboard.php" class="btn btn-primary btn-lg px-5 py-3 btn-rounded shadow-lg">
            Go To Dashboard
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>