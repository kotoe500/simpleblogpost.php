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
            padding: 5px;
        }

        a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
 <?php
include "connect.php";
$nameError = "";
$emailError = "";
$addressError = "";
$passwordError = "";
$confirn_passwordError = "";

$name ="";
$email ="";
$address ="";
$password ="";
$confirn_password="";
if(isset($_POST['register_button'])){
   $name = $_POST['name'];
   $email = $_POST['email'];
   $address = $_POST['address'];
   $password = $_POST['password'];
   $confirn_password = $_POST['confirn_password'];
if(empty($name)){
    $nameError = "The name field is required";
}
if(empty($email)){
    $emailError = "The email field is required";
}
if(empty($address)){
    $addressError = "The address field is required";
}
if(empty($password)){
    $passwordError = "The password field is required";
}
if(empty($confirn_password)){
    $confirn_passwordError = "The confirn_password field is required";
}
if($confirn_password != $password){
    $confirn_passwordError = "The confirn_password is do not match";
}
if(!empty($name) && !empty($email) && !empty($address) && !empty($password) && !empty($confirn_password) && $confirn_password == $password){
    $hidepassword = md5($password);
    $query = "INSERT INTO users(name , email , address ,password) VALUES('$name','$email','$address','$hidepassword')";        
   $result = mysqli_query($dbconnection,$query);
   if($result == true){
    echo "<script>
    alert ('Registration is successfull')
    </script>";
    header('location: login.php');
   }else{
    die('Error: '. mysqli_error($dbconnection));
   }
}   
}
?> 

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">
                                    <a href="">
                                        <h5 class="">Registration Page</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php" class="float-end ms-3">Back To Home</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <div class="card-title">Register</div>
                                    </div>
                                    <form action="register.php" method="POST">
                                        <div class="card-body">

                                            <div class="mb-3">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control <?php if($nameError != ""){ ?> is-invalid <?php } ?>" value = "<?php echo($name) ?>"/>
                                                <i class="text-danger"><?php  echo $nameError; ?></i>
                                            </div>
                                            <div class="mb-3">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control <?php echo($emailError != "") ? 'is-invalid' : '' ; ?>" value = "<?php echo($email) ?>"/>
                                                <i class="text-danger"><?php  echo $emailError; ?></i>
                                            </div>
                                            <div class="mb-3">
                                                <label>Address</label>
                                                <textarea name="address" class="form-control <?php if($addressError != ""){ ?> is-invalid <?php } ?>" rows="3"><?php echo($address) ?></textarea>
                                                <i class="text-danger"><?php  echo $addressError; ?></i>
                                            </div>
                                            <div class="mb-3">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control <?php echo($passwordError != "") ? 'is-invalid' : '' ?>" value = "<?php echo($password) ?>" />
                                                <i class="text-danger"><?php  echo $passwordError; ?></i>
                                            </div>
                                            <div class="mb-3">
                                                <label>Confirn Password</label>
                                                <input type="password" name="confirn_password" class="form-control <?php if($confirn_passwordError != ""){ ?> is-invalid <?php } ?>"  value = "<?php echo($confirn_password) ?>"/>
                                                <i class="text-danger"><?php  echo $confirn_passwordError; ?></i>
                                            </div>

                                        </div>
                                        <div class="card-footer bg-info">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="submit" name="register_button" class="btn btn-danger">Register</button>
                                                </div>
                                                <div class="col-md-8">
                                                    <span>If You account already have ,
                                                        <a href="login.php">Login Here</a></span>
                                                </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>