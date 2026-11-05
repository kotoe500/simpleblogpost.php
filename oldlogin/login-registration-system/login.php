<?php
session_start();
include "connect.php";
 
$error ="";
    if(isset($_POST['loginButton'])){
            $email =trim($_POST['email']);
            $password =md5(trim($_POST['password']));
            $query ="SELECT * FROM users WHERE email='$email' AND password='$password'";
            $user_result = mysqli_query($dbconnection , $query);
            $user_count =mysqli_num_rows($user_result);
            if($user_count === 1){
                $user_array =mysqli_fetch_assoc($user_result);
                $_SESSION['user_array'] = $user_array;
                if($user_array['role'] == 'admin'){
                      header('location:admin-dashboard.php');
                }else{
                    header('location:user-dashboard.php');
                }                                  
            }else{
                $error = "invalid email or password";
            }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style type="text/css">
        body {
            padding: 70px;
        }

        a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>     
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card-title">
                                    <a href="">
                                        <h5 class="">Login Page</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php" class="float-end ms-3">Back To Home</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-5 mb-5">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <div class="card-title">Register</div>
                                    </div>
                                    <form action="login.php" method="POST">
                                        <div class="card-body">
                                            <?php if($error !== ""): ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong><?php echo $error; ?></strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                             <?php endif ?>
                                            <div class="mb-3">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control" />
                                            </div>
                                            <div class="mb-3">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" />
                                            </div>

                                        </div>
                                        <div class="card-footer bg-info">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="submit" name="loginButton" class="btn btn-danger">Login</button>
                                                </div>
                                                <div class="col-md-8">
                                                    <span>If You Have No Account Yet ,
                                                        <a href="register.php">Register Here</a></span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-3"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>      
</body>

</html>