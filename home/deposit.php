<?php
    session_start();
    include "../config/db.php";

    $id=$_SESSION['id'];
    $curval=$_SESSION['curval'];
    $tablename=$curval."deposit".$id;
    if(isset($_POST['submit'])){
        $name=$_POST["name"];
        $contact=$_POST["contact"];
        $sql="INSERT INTO $tablename (name,balance,contact)VALUES('$name',0,'$contact')";
        if($con->query($sql)){
            header("Location:allmember.php");
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
    <title>Member List</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="text-center mb-0">All Member List of Your Mess</h3>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Balance</th>
                        <th>Add Balance</th>
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
                            echo "<td>".$val['balance']."</td>";
                            echo "<td><a href='addbalance.php?addid=".$val['id']."' 
                                    class='btn btn-success btn-sm''>Add</a></td>";
                            echo "</tr>";
                        }
                    }else{
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
    
    
</div>
    <div class="text-center my-5">
        <a href="dashboard.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg">
            Go To Dashboard
        </a>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>