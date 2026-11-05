<?php
session_start();
require('../config/config.php');
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
};

?>
<?php
include 'header.php';
?>
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                
              </div>
              <div class="col-sm-6">
                
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <?php
        if (isset($_GET['pageno'])){
          $pageno = $_GET['pageno'];
        }else{
          $pageno = 1;
        }
        $numofres = 4;
        $offset = ($pageno -1) * $numofres;

        if(empty($_POST['search'])){
          $stmt =$pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
        $stmt->execute();
        $rawresult=$stmt->fetchAll();
        $total_pages = ceil(COUNT($rawresult)/$numofres);

        $stmt =$pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numofres ;");
        $stmt->execute();
        $result=$stmt->fetchAll(); 
        }else{
          $searchKey = $_POST['search'];
          $stmt =$pdo->prepare("SELECT * FROM posts WHERE title LIKE  '%$searchKey%' ORDER BY id DESC");
        $stmt->execute();
        $rawresult=$stmt->fetchAll();
        $total_pages = ceil(COUNT($rawresult)/$numofres);

        $stmt =$pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numofres ;");
        $stmt->execute();
        $result=$stmt->fetchAll(); 
        }      
        
        ?>
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-12">
                <div class="col-md-12">
                <div class="card mb-3">
                  <div class="card-header">
                    <h3 class="card-title">Post Table</h3>
                  </div>
                  <div>
                    <a href="add.php" type="button" class="btn btn-success btn-sm ms-3 mt-3">create new blog post</a>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10px">id</th>
                          <th>Title</th>
                          <th>Content</th>
                          <th style="width: 50px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if($result){
                          $i =1;
                          foreach ($result as $value) {
                            ?>
                            <tr class="align-middle">
                          <td><?php echo $i ;?></td>
                          <td><?php echo $value['title']?></td>
                          <td><?php echo substr($value['content'],0,36)?></td>
                          <td>          
                           <div class="btn-group"> 
                              <div class="container">
                                <a href="edit.php?id=<?php echo $value['id']?>" type="button" class="btn btn-warning btn-sm">edit</a>
                              </div>
                              <div class="container">
                                <a href="delete.php?id=<?php echo $value['id']?>" type="button" class="btn btn-danger btn-sm" onclick="return confirm('Are your sure delete this file')">delete</a>
                              </div>                               
                            </div>                         
                          </td>                          
                        </tr>
                           <?php 
                            $i++ ;
                          }                         
                        }
                        ?>                        
                      </tbody>
                    </table><br>
                    <nav aria-label="Page navigation example" class="float-end">
                         <ul class="pagination">
                           <li class="page-item"><a href="?pageno=1" class="page-link">first</a></li>
                           <li class="page-item <?php if($pageno <= 1){echo 'disabled';} ?>">
                            <a href="<?php if($pageno <= 1){echo '#';}else{echo '?pageno='.($pageno - 1);}?>" class="page-link">previous</a>
                          </li>
                           <li class="page-item"><a href="#" class="page-link"><?php echo $pageno; ?></a></li>
                           <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';}?>">
                            <a href="<?php if($pageno >= $total_pages){echo '#';}else{ echo '?pageno='.($pageno + 1);}?>" class="page-link">next</a>
                          </li>
                           <li class="page-item"><a href="?pageno=<?php echo $total_pages?>" class="page-link">end</a></li>
                         </ul>
                    </nav> 
                  </div>
                  <!-- /.card-body -->                    
                </div>               
              </div>              
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
<?php
include 'footer.php';
?>