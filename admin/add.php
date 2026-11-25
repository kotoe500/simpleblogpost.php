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
  $file ='images/'.($_FILES['image']['name']);
  $imagetype = pathinfo($file,PATHINFO_EXTENSION);

  if($imagetype != 'png' && $imagetype != 'jpg' && $imagetype != 'jpeg'){
    echo "<script>alert('image must be png,jpg,jpeg')</script>";
  }else{
    $title = $_POST['title'];
    $content =$_POST['content'];
    $image =$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],$file);
    $stmt =$pdo->prepare("INSERT INTO posts (title,content,image,author_id) values(:title,:content,:image,:author_id)");
    $result = $stmt->execute(
      array(':title' => $title , ':content' => $content , ':image' => $image, ':author_id' => $_SESSION['user_id'])      
    );
    if($result){
      echo "<script>alert('your file is uploaded');window.location.href='index.php'</script>";
    }
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
          <form class="" action="add.php" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="" class="mb-2">Title</label>
            <input type="text" class="form-control" name="title" value="" required><br>
          </div>
            <div class="form-group">
            <label for="" class="mb-2">Content</label>
            <textarea  class="form-control" name="content" rows='8' cols='80' ></textarea><br>
          </div>
            <div class="form-group">
            <label for="" class="mb-2">Image</label><br>
            <input type="file" name="image" value="" required>
          </div><br>
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