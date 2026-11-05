<?php 
include 'connect.php';
session_start();
if(!isset($_SESSION['user_array'])){
    header('location:login.php');
}else {
    if($_SESSION['user_array']['role'] !== 'user'){
    header('location:admin-dashboard.php');
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
            padding: 50px;
        }

        a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php
     // logout
        if(isset($_POST['logoutButton'])){
        session_destroy();
        header('location:login.php');
        }
    //authenticated info show
    $auth_user_id =$_SESSION['user_array']['id'];
    $auth_user_result = mysqli_query($dbconnection, "SELECT * FROM users WHERE id=$auth_user_id");
    if($auth_user_result){
        $auth_user_array = mysqli_fetch_array($auth_user_result);
    }else {
        die('Error '. mysqli_error($dbconnection));
    }
    
        //edit info
        $user_info_edit_file ='false';
        if(isset($_REQUEST['user_info_edit'])){
            $user_info_edit_file ='true';
            $user_info_edit = $_REQUEST['user_info_edit'];
            $query = "SELECT * FROM users WHERE id=$user_info_edit" ;
            $result =mysqli_query($dbconnection,$query);
            if($result){
            $user = mysqli_fetch_assoc($result);
            }else{
            die('Error '.mysqli_error($dbconnection));
        }            
        }
        //update info
        if(isset($_REQUEST['user_info_update'])){
            $user_id=$_REQUEST['user_id'];
            $name=$_REQUEST['name'];
            $email=$_REQUEST['email'];
            $address=$_REQUEST['address'];
            $input_password=$_REQUEST['password'];
            $user_result =mysqli_query($dbconnection, "SELECT * FROM users WHERE id=$user_id");
            $user_array =mysqli_fetch_assoc($user_result);
            $old_password =$user_array['password'];
            $new_password = $old_password != $input_password? md5($input_password) : $input_password ;
            $query = "UPDATE users SET name='$name', email='$email', address='$address', password='$new_password' WHERE id=$user_id ";
            $result =mysqli_query($dbconnection, $query);
            if($result){
                echo "<script>
                alert('your update is succefful');
                window.location.href = 'user-dashboard.php';
                </script>";
                
            }else{
                die('Error '.mysqli_error($dbconnection));
            }
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">
                                    <a href="">
                                        <h5 class="">user Dashboard</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form action="user-dashboard.php" method="POST">
                                    <button type="submit" name="logoutButton" class="btn btn-danger btn-sm float-end"
                                        onclick=" return confirm ('Are you sure you want to logout')">
                                        log out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5> user info </h5>
                                        <div>
                                             Name :                                             
                                               <?php  echo $auth_user_array['name'];?>                                            
                                        </div>
                                         <div>role:
                                             <span class="badge bg-info rounded-pill">
                                                <?php echo $auth_user_array['role'];?>
                                             </span>
                                        </div>
                                        <div> Email :
                                            <?php  echo $auth_user_array['email'];?>
                                        </div>
                                        <div> Address :
                                            <?php  echo $auth_user_array['address'];?>
                                        </div>
                                        <div> Password :
                                            <?php  echo $auth_user_array['password'];?>
                                        </div>
                                         <div>
                                            <a href="user-dashboard.php?user_info_edit=<?php echo $auth_user_array['id']?>" class="btn btn-success btn-sm rounded-3">edit your info</a>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php
                                   if($user_info_edit_file == 'true'){
                                ?>
                                <div class="card">
                                    <form action='user-dashboard.php' method='POST' class="form-control">
                                        <div class="card-header bg-success opacity-75">
                                            <h4>edit user info</h4>
                                        </div>
                                        <div class="card-body">
                                             <div class="form-group mb-3">
                                                <input type="hidden" name="user_id" class="form-control" 
                                                value="<?php  echo $user['id'];?>"/>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" 
                                                value="<?php  echo $user['name']??'';?>"/>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" 
                                                value="<?php  echo $user['email']??'';?>">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Address</label>
                                                <textarea type="text" name="address" class="form-control" 
                                                rows="3"><?php echo $user['address']??'';?></textarea>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Password</label>
                                                <input type="text" name="password" class="form-control" 
                                                value="<?php  echo $user['password']??'';?>">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="user_info_update" class="btn btn-danger btn-sm">update</button>
                                        </div>
                                    </form>
                                </div>
                                    <?php
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></>
</body>

</html>