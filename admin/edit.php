<?php
session_start();
require('../config/config.php');
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');  
};
if($_POST){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content =$_POST['content'];    
    if($_FILES['image']['name'] != null){
        $file= 'images/'.($_FILES['image']['name']); 
        $imagetype = pathinfo($file,PATHINFO_EXTENSION);
        if($imagetype != 'png' && $imagetype != 'jpg' && $imagetype != 'jpeg'){
            echo "<script>alert('image must be png ,jpg ,jpeg')</script>";
        }else{        
         $image =$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);
    $stmt = $pdo->prepare("UPDATE posts SET title = '$title' , content = '$content' , image = '$image' WHERE id = '$id' " );
    $result = $stmt->execute();
    if($result){
      echo "<script>alert('your file is uploaded');window.location.href='index.php';</script>";
    }
  }
    }else{
           $stmt = $pdo->prepare("UPDATE posts SET title = '$title' , content = '$content' WHERE id = '$id' " );
    $result = $stmt->execute();
    if($result){
      echo "<script>alert('your file is uploaded')</script>";
    }
    }
}
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
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
          <form class="" action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <input type="hidden" class="form-control" name="id" value="<?php echo $result[0]['id'];?>"><br>
            <label for="" class="mb-2">Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $result[0]['title'];?>">
          </div>
            <div class="form-group">
            <label for="" class="mb-2">Content</label>
            <textarea  class="form-control" name="content" rows='8' cols='80' ><?php echo $result[0]['content'];?></textarea><br>
          </div>
            <div class="form-group">
            <label for="" class="mb-2">Image</label><br>
            <img src="images/<?php echo $result[0]['image'];?>" width="150" height="150"><br><br>
            <input type="file" name="image" value="">
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