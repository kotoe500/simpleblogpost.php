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
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email =$_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    if(!empty($password)){ 
    $stmt = $pdo->prepare("UPDATE users SET name = :name , email = :email , password = :password WHERE id = :id " );
    $result = $stmt->execute(
      array(
        ':id' => $id ,
        ':name' => $name ,
        ':email' => $email ,
        ':password' => $password
         )
    );
  }else{
     $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id " );
    $result = $stmt->execute(
      array(
        ':id' => $id,
        ':name' => $name,
        ':email' => $email
         )
    );
  }  
   if($result){
      echo "<script>alert('your file is uploaded');window.location.href='userlist.php';</script>";
    }
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();


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
          <form class="" action="#" method="POST">
          <div class="form-group">
            <input type="hidden" class="form-control" name="id" value="<?php echo $result[0]['id'];?>"><br>
            <label for="" class="mb-2">Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo $result[0]['name'];?>">
          </div>
            <div class="form-group">
            <label for="" class="mb-2">Email</label>
            <input type="text" class="form-control" name="email" value="<?php echo $result[0]['email'];?>" required><br>
          </div>
           <div class="form-group">
            <label for="" class="mb-2">Password</label>
            <input type="text" class="form-control" name="password" value="<?php echo $result[0]['password'];?>"><br>
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