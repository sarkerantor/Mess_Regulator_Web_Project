<?php 
    session_start();
    include "../config/db.php";
    if(!isset($_SESSION['id'])){
        die("Unauthorized access");
    }
    $id = $_SESSION['id'];
    $ruleTable = "rule".$id;
    /* Insert Rule */
    if(isset($_POST['submit'])){
        $desc = $_POST["rule"];
        $sql="INSERT INTO $ruleTable(descr)VALUES('$desc')";
        if($con->query($sql)){
            header("Location: rule.php");
            exit();
        }else{
            echo "Insert Error!";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rule Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Rule of Your Mess</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Rule Description</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM $ruleTable";
                $res = $con->query($sql);
                if($res && $res->num_rows > 0){
                    while($val = $res->fetch_assoc()){
                ?>
                    <tr>
                        <td><?php echo $val['descr']; ?></td>
                        <td class="text-center">
                            <a class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this rule?')"
                               href="ruledelete.php?ruledelid=<?php echo $val['id']; ?>">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php
                    }
                }else{
                ?>
                    <tr>
                        <td colspan="3" class="text-center text-danger">
                            No rule found
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>

            </table>
        </div>
    </div>
    <!-- Add Rule -->
    <div class="card shadow-lg mt-4">
        <div class="card-header bg-success text-white">
            <h5>Add New Rule</h5>
        </div>

        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Write Rule</label>
                    <textarea name="rule" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-success w-100">
                    Submit Rule
                </button>
            </form>
        </div>
    </div>

</div>
    <div class="text-center my-5">
        <a href="dashboard.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg">
            Go To Dashboard
        </a>
    </div>
</body>
</html>