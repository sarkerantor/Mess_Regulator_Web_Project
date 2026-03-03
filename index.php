<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mess Regulator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 25px;
            border: none;
            margin-top: 80px; 
        }
        
        .logo-container {
            width: 180px; 
            height: 180px;
            background: white;
            border-radius: 50%;
            margin: -100px auto 25px auto; 
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 5px;
            border: 6px solid #fff; 
            overflow: hidden;
        }
        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
        }

        .btn {
            border-radius: 12px;
            padding: 14px;
            font-weight: bold;
            transition: 0.3s;
            font-size: 1.1rem;
        }
        .btn-primary { background-color: #4e73df; border: none; }
        .btn-success { background-color: #1cc88a; border: none; }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        
        h2 { color: #333; letter-spacing: -0.5px; }
        .team-footer { color: #555; font-size: 0.9rem; letter-spacing: 1px; }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-9 col-md-7 col-lg-6 col-xl-5">
                
                <div class="card shadow-lg p-4 p-md-5 text-center">
                    
                    <div class="logo-container">
                        <img src="logo.png" alt="MESS REGULATOR"> 
                    </div>
                    
                    <h2 class="mb-4 fw-bold">
                        Welcome to <br> 
                        <span style="color: #4e73df;">Mess Regulator</span>
                    </h2>

                    <p class="text-muted mb-4 px-3">
                        Login to your existing mess directory and manage with ease.
                    </p>

                    <div class="d-grid gap-3">
                        <a href="login.php" class="btn btn-primary shadow-sm">
                            <i class="fa-solid fa-right-to-bracket me-2"></i> Login
                        </a>

                        <div class="d-flex align-items-center my-2">
                            <hr class="flex-grow-1">
                            <span class="mx-3 text-muted small">OR</span>
                            <hr class="flex-grow-1">
                        </div>

                        <a href="signup.php" class="btn btn-success shadow-sm">
                            <i class="fa-solid fa-user-plus me-2"></i> SignUp
                        </a>
                    </div>

                    <div class="mt-5 pt-3 border-top">
                        <p class="team-footer mb-0">
                            developed by <br>
                            <span class="fw-bold text-dark">team returnZero</span>
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>

</body>
</html>