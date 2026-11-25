<?php
session_start();
require('../config/config.php');
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
};
if($_SESSION['role'] != 1){
  header ('location: login.php');
};
if($_POST){ 
    $name = $_POST['name'];
    $email =$_POST['email'];
    $password =$_POST['password'];
    
    $stmt =$pdo->prepare("INSERT INTO users(name,email,password) values(:name,:email,:password)");
    $result = $stmt->execute(
      array(':name' => $name , ':email' => $email , ':password' => $password )      
    );
    print_r($result);
    if($result){
      echo "<script>alert('your new user is added');window.location.href='userlist.php'</script>";
    }  
}

?>
<?php
include 'header.php';
?>
<div class="content mt-5">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
         <div class="card-body">
          <form class="" action="user-add.php" method="POST" >
          <div class="form-group">
            <label for="" class="mb-2">Name</label>
            <input type="text" class="form-control" name="name" value="" required><br>
          </div>
           <div class="form-group">
            <label for="" class="mb-2">Email</label>
            <input type="text" class="form-control" name="email" value="" required><br>
          </div>
           <div class="form-group">
            <label for="" class="mb-2">Password</label>
            <input type="text" class="form-control" name="password" value="" required><br>
          </div>
          
          <div class="form-group">
            <input type="submit" class="btn btn-warning" name="" value="submit">
            <a href="index.php" class="btn btn-info">back</a>
          </div>
         </form>
         </div>
        </div>
      </div>
    </div>
  </div>
</div>
     
     
<?php
include 'footer.php';
?>