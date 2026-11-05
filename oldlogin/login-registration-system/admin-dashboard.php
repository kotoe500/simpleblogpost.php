<?php 
include 'connect.php';
session_start();
if(!isset($_SESSION['user_array'])){
    header('location:login.php');
}else {
    if($_SESSION['user_array']['role'] !== 'admin'){
    header('location:user-dashboard.php');
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
            padding: 10px;
        }

        a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php
    //authenticated user info show 
    $auth_user_id = $_SESSION['user_array']['id'];
    $auth_user_result=mysqli_query($dbconnection, "SELECT * FROM users WHERE id=$auth_user_id");
    if($auth_user_result){
        $auth_user_array = mysqli_fetch_assoc($auth_user_result);

    }else{
        die('Error '.mysqli_error($dbconnection));
    }
    //user edit
    $user_edit_form = false;
    if(isset($_GET['user_id_to_update'])){
        $user_edit_form =true;
        $user_id_to_update=$_GET['user_id_to_update'];
        $query ="SELECT * FROM users WHERE id=$user_id_to_update";
        $result =mysqli_query($dbconnection,$query);
        if($result){
            $user = mysqli_fetch_assoc($result);
        }else{
            die('Error '.mysqli_error($dbconnection));
        }
    }
    // user update session
    if(isset($_POST['user_update_button'])){
        $user_id =$_POST['user_id'];
        $name = $_POST['name'] ;
        $email = $_POST['email'] ;
        $address = $_POST['address'] ;
        $role = $_POST['role'] ;
        $user_result =mysqli_query($dbconnection,"SELECT * FROM users WHERE id=$user_id");
        $user_array =mysqli_fetch_assoc($user_result);
        $old_password = $user_array['password'];
        $input_password = $_POST['password'];
        $new_password =$old_password != $input_password ? md5($input_password) : $input_password ;
        $query = "UPDATE users SET name='$name', email='$email', address='$address', role='$role', password='$new_password'
         WHERE id=$user_id ";
         $result =mysqli_query($dbconnection, $query);
         if($result){
            $_SESSION['status'] = 'your update is successful';
            header('location:admin-dashboard.php');
            exit();

         }else{
            die('ERROR:'. mysqli_error($dbconnection));
         }    
    } 
   
     //user delete button
         if(isset($_REQUEST['user_id_delete'])){
            $user_id_delete =$_REQUEST['user_id_delete'];
            $result =mysqli_query($dbconnection, "DELETE FROM users WHERE id=$user_id_delete");
            if($result){
                echo "<script>alert('your deleted successful')</script>" ;
                header('location:admin-dashboard.php');
            }else{
                die('Error:' . mysqli_error($dbconnection));
            }
         }   
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success bg-opacity-50">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">
                                    <a href="">
                                        <h5 class="">Admin Dashboard</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form action="logout.php" method="POST">
                                    <button class="btn btn-danger btn-sm float-end"
                                        onclick=" return confirm ('Are you sure you want to logout')">
                                        log out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-info-subtle">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h5> Admin info </h5>
                                        <div> Name :
                                            <?php  echo $auth_user_array['name'];?>
                                        </div>
                                        <div>role:
                                            <span class="badge bg-success rounded-pill">
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
                                    </div>
                                </div>
                                <?php
                                    if($user_edit_form == true){
                                ?>
                                <div class="card">
                                    <div class="card-header bg-success bg-opacity-50">
                                        <h4 class="text-danger">edit your info</h4>
                                    </div>                                   
                                    <form action=<?php echo $_SERVER['PHP_SELF'];?> method="POST">                                        
                                        <div class="card-body bg-secondary-subtle">
                                            <div class="form-group">
                                                <input type="hidden" name="user_id" class="form-control" value="<?php echo $user['id'] ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="<?php echo $user['name'] ?>" />

                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control"
                                                    value="<?php echo $user['email'] ?>" />

                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea type="text" name="address" class="form-control"
                                                    rows="3"><?php echo $user['address']?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>role</label>
                                                <select name='role' class="form-select">
                                                    <option value="">select role</option>
                                                    <option value="admin" 
                                                    <?php if($user['role']=='admin' ){ ?>selected
                                                        <?php }?>
                                                        >admin
                                                    </option>
                                                    <option value="user"
                                                    <?php if($user['role']=='user' ){ ?>selected
                                                        <?php }?>
                                                        >user </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="text" name="password" class="form-control"
                                                    value="<?php echo $user['password'] ?>" />
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="user_update_button" class="btn btn-danger">update</button>
                                        </div>
                                    </form>                                   
                                </div>
                                    <?php
                                        }
                                    ?>
                            </div>
                            <div class="col-md-8">
                                <h5>User List</h5>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>role</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                         // select all user RECORD
                                             $query ="SELECT * From users";
                                             $result = mysqli_query($dbconnection ,$query);
                                             foreach($result as $users){
                                                ?>
                                        <tr>
                                            <td>
                                                <?php echo $users['id'];?>
                                            </td>
                                            <td>
                                                <?php echo $users['name'];?>
                                            </td>
                                            <td>
                                                <?php echo $users['email'];?>
                                            </td>
                                            <td>
                                                <?php echo $users['address'];?>
                                            </td>
                                            <td>
                                                <?php echo $users['role'];?>
                                            </td>
                                            <td>                                                
                                                <a href="admin-dashboard.php?user_id_to_update=<?php echo $users['id'];?>"
                                                    class="btn btn-sm btn-primary rounded-3">edit</a>
                                                <a href="admin-dashboard.php?user_id_delete=<?php echo $users['id'];?>"
                                                    class="btn btn-danger btn-sm rounded-3"
                                                     onclick=" return confirm ('Are you sure want to delete')"
                                                     >delete</a>                                               
                                            </td>
                                        </tr>
                                        <?php
                                             }      
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>   
        <?php
             //alert show status
            if(isset($_SESSION['status'])){
        ?>
            <script>
                alert("<?php echo $_SESSION['status'];?>");
            </script>
        <?php
            unset($_SESSION['status']);
             }
        ?>
</body>

</html>