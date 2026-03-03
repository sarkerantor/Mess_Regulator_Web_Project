<?php
session_start();
include "config/db.php";

if(isset($_POST['login'])){
    $mail = mysqli_real_escape_string($con, $_POST['mail']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE mail = '$mail'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        
        if(password_verify($password, $row['password'])){
            $_SESSION['mail'] = $row['mail'];
            $_SESSION['mess_name'] = $row['mess_name'];
            $_SESSION['curval'] = $row['curval'];
            $_SESSION['id']=$row['id'];
            header("Location: home/dashboard.php");
            exit();
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $error = "No account found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Mess Regulator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
        }
        .card {
            border-radius: 1rem;
            border: none;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
            
            <div class="card shadow-lg p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="text-primary fw-bold">Login</h2>
                    <p class="text-muted">Welcome back! <br> Please login to your Mess Directory.</p>
                </div>

                <?php if(isset($error)){ ?>
                    <div class="alert alert-danger py-2"><?php echo $error; ?></div>
                <?php } ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="mail" class="form-control" placeholder="name@example.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                        Login
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="small mb-0">Don't have an account?</p>
                    <a href="signup.php" class="text-success fw-bold text-decoration-none">Create a Mess Directory</a>
                </div>

                <div class="text-center mt-3">
                    <a href="index.php" class="text-muted small fw-bold text-decoration-none">← Back to Home</a>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>