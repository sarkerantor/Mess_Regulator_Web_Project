<?php
session_start();
include "config/db.php";

if(isset($_POST['register'])){

    $mail = mysqli_real_escape_string($con, $_POST['mail']);
    $password = $_POST['password'];
    $mess_name = mysqli_real_escape_string($con, $_POST['mess_name']);

    $check = "SELECT id FROM admin WHERE mail='$mail' LIMIT 1";
    $check_result = mysqli_query($con, $check);

    if(mysqli_num_rows($check_result) > 0){
        $error = "Email already exists!";
    } else {

        // Password hash
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $default_contact = "+8801xxxxxxxxx";
        $default_details = "Manager Details will be uploaded!";

        $sql = "INSERT INTO admin (mail, password, mess_name, contact, details, curval)
                VALUES ('$mail', '$hashed_password', '$mess_name', '$default_contact', '$default_details', '')";

        if(mysqli_query($con, $sql)){

            $id = mysqli_insert_id($con);

            $_SESSION['id'] = $id;
            $_SESSION['mail'] = $mail;
            $_SESSION['mess_name'] = $mess_name;

            header("Location: congrats.php");
            exit();

        } else {
            $error = "Database Error!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Mess Regulator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #36b9cc, #1cc88a);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-9 col-md-7 col-lg-5">

            <div class="card shadow-lg p-5">
                <h3 class="text-center mb-4">Create Mess Directory</h3>

                <?php if(isset($error)){ ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="mail" class="form-control" placeholder="Enter email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Create Your Password" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Mess Name</label>
                        <input type="text" name="mess_name" class="form-control" placeholder="Enter Your Mess Name" required>
                    </div>

                    <button type="submit" name="register" class="btn btn-success w-100 mt-4">
                        SignUp
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php" class="text-decoration-none">
                       ← Back to Home
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>