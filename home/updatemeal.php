<?php
session_start();
include "../config/db.php";

$id = $_SESSION['id'];
$curval = $_SESSION['curval'];
$tablename = $curval.$id;

if(isset($_POST['date'])){
    $date = intval($_POST['date']); 
    $day = "d_" . $date;

    if(isset($_POST['update'])){
        foreach($_POST['meal'] as $user_id => $meal_amount){
            $meal_amount = intval($meal_amount); 
            $update_sql = "UPDATE $tablename SET $day = $meal_amount WHERE id = $user_id";
            $con->query($update_sql);
        }
        $success = "Meals updated successfully!";
    }

    $sql = "SELECT * FROM $tablename";
    $res = $con->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Meal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ffe2e2, #e2f0ff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }
        .card {
            background: #ffffffcc;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            margin-bottom: 30px;
        }
        table {
            background-color: #f8f9fa;
        }
        table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }
        table td {
            vertical-align: middle;
            text-align: center;
        }
        input[type=number] {
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .alert {
            margin-top: 20px;
        }
        .dash a {
            margin-right: 20px;
            font-weight: 600;
            color: #343a40;
            text-decoration: none;
            transition: 0.3s;
        }
        .dash a:hover {
            color: #007bff;
        }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <h2>Update Meal</h2>

        <?php if(isset($success)): ?>
            <div class="alert alert-success text-center"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="card">
            <form method="post">
                <div class="mb-3">
                    <label for="date" class="form-label">Which Date you want to update:</label>
                    <input type="number" name="date" id="date" class="form-control" min="1" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Show Users</button>
            </form>
        </div>

        <?php if(isset($res) && $res->num_rows > 0): ?>
            <div class="card">
                <form method="post">
                    <input type="hidden" name="date" value="<?php echo $date; ?>">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Meal Amount for Day <?php echo $date; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($val = $res->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $val['name']; ?></td>
                                    <td><?php echo $val['contact']; ?></td>
                                    <td>
                                        <input type="number" name="meal[<?php echo $val['id']; ?>]" 
                                               value="<?php echo $val[$day]; ?>" class="form-control" required>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="update" class="btn btn-success w-100">Update Meals</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="dash text-center mt-4">
            <a href="dashboard.php">Go To Dashboard</a>
            <a href="currentmonth.php">Show Current Month Meal</a>
        </div>
    </div>
</body>
</html>