<?php
session_start();
require('config/config.php');
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
};
$stmt =$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();

 $blogid = $_GET['id'];
 
$stmtcmt =$pdo->prepare("SELECT * FROM comments  WHERE post_id=$blogid");
$stmtcmt->execute();
$cmtresult = $stmtcmt->fetchAll();

$auresult=[];
if($cmtresult){  
  foreach ($cmtresult as $key => $value) {
     $authorid = $cmtresult[$key]['author_id'];
     $stmtau =$pdo->prepare("SELECT * FROM users  WHERE id=$authorid");
     $stmtau->execute();
     $auresult[] = $stmtau->fetchAll();
  } 
}
if(isset($_POST['comment'])){
  $comment = $_POST['comment']; 
  $stmt = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
  $result = $stmt->execute(
    array(
      ':content'=>$comment,
      ':author_id'=>$_SESSION['user_id'],
      ':post_id'=>$blogid
    )
  );
  if($result){
    header('location: blogdetail.php?id='.$blogid);
  }
}
?>

<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>AdminLTE 4 | Widgets - Social &amp; Post</title>

  <!--begin::Theme Init (prevents flash of incorrect theme on load, #6043)-->
  <script>
    (() => {
      'use strict';
      const root = document.documentElement;

      // Applications with their own theming opt out of AdminLTE's color mode
      // entirely, here as well as in the bundle.
      if (root.getAttribute('data-lte-color-mode') === 'off') {
        return;
      }

      const STORAGE_KEY = 'lte-theme';
      let stored = null;
      try {
        stored = localStorage.getItem(STORAGE_KEY);
      } catch {
        // localStorage may be unavailable (private mode, sandboxed iframe).
      }
      // Mirror the precedence in color-mode.ts: the visitor's stored choice
      // wins, then a theme this page declared itself, then the OS preference.
      const authored = root.getAttribute('data-bs-theme');
      let resolved = 'light';
      if (stored === 'dark' || stored === 'light') {
        resolved = stored;
      } else if (authored === 'dark' || authored === 'light') {
        resolved = authored;
      } else if (globalThis.matchMedia('(prefers-color-scheme: dark)').matches) {
        resolved = 'dark';
      }
      root.setAttribute('data-bs-theme', resolved);
      root.style.colorScheme = resolved;
      // Flag values computed here, so the bundle does not mistake them for a
      // theme the page declared and stop following the OS preference.
      if (resolved !== authored) {
        root.setAttribute('data-lte-theme-resolved', '');
      }
    })();
  </script>
  <!--end::Theme Init-->

  <!--begin::Accessibility Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <meta name="color-scheme" content="light dark" />
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
  <!--end::Accessibility Meta Tags-->

  <!--begin::Primary Meta Tags-->
  <meta name="title" content="AdminLTE 4 | Widgets - Social &amp; Post" />
  <meta name="author" content="ColorlibHQ" />
  <meta name="description"
    content="AdminLTE is a free Bootstrap 5 admin dashboard template with almost 50 example pages, built with vanilla JS and designed with accessibility in mind." />
  <meta name="keywords"
    content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel" />
  <!--end::Primary Meta Tags-->

  <!--begin::Accessibility Features-->
  <!-- Skip links will be dynamically added by accessibility.js -->
  <meta name="supported-color-schemes" content="light dark" />
  <link rel="preload" href="css/adminlte.css" as="style" />
  <!--end::Accessibility Features-->

  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
    onload="this.media = 'all'" />
  <!--end::Fonts-->

  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
    crossorigin="anonymous" />
  <!--end::Third Party Plugin(OverlayScrollbars)-->

  <!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    crossorigin="anonymous" />
  <!--end::Third Party Plugin(Bootstrap Icons)-->

  <!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href="./css/adminlte.css" />
  <!--end::Required Plugin(AdminLTE)-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="" >
    <div class="row g-4" style="margin-right:0px !important;">
      <!--begin::Col-->
      <div class="">
        <!--begin::Social Widget-->
        <div class="card mb-0">
          <!--begin::Card Header-->
          <div class="card-header">
            <div class="user-block">
              <!-- <img class="rounded-circle" src="./assets/img/user1-128x128.jpg" alt="" /> -->
               <img class="img-fluid rounded mb-3" src="admin/images/<?php echo $result[0]['image'];?>">
              <span class="username">
                <a href="#"><?php echo $result[0]['title'];?></a>
              </span>
              <span class="description">Shared publicly &middot; 7:30 PM today</span>
            </div>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" aria-label="Collapse card">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
              </button>
            </div>
          </div>
          <!--end::Card Header-->
          <!--begin::Card Body-->
          <div class="card-body">
             <img class="img-fluid rounded mb-3 d-block mx-auto" src="admin/images/<?php echo $result[0]['image'];?>" style ="width:50%; height:500px;"/>
             <p><?php echo $result[0]['content'];?></p>
             <button type="button" class="btn btn-sm btn-outline-secondary me-1">
              <i class="bi bi-share me-1" aria-hidden="true"></i> Share
             </button>
             <button type="button" class="btn btn-sm btn-outline-secondary">
              <i class="bi bi-hand-thumbs-up me-1" aria-hidden="true"></i> Like
             </button>
             <span class="float-end text-secondary">45 likes &middot; 2 comments</span>
          </div>
            <hr>
          <h3 style="margin-left:30px;">Comment</h3>
          <hr>
          <!--end::Card Body-->
          <!--begin::Card Footer-->

          <div class="card-footer">
            <?php if($cmtresult){
              ?>
              <div class="user-block user-block-sm mb-3">
              <img class="rounded-circle" src="./assets/img/user4-128x128.jpg" alt="" />
              <?php foreach ($cmtresult as $key => $value){ ?>
                  <span class="username"><a href="#"><?php echo $auresult[$key][0]['name'];?></a></span>
                  <span class="description"><?php echo $cmtresult[$key]['created_at'];?></span>
                  <span class="comment">
                  <?php echo $cmtresult[$key]['content'];?>
                  </span>

                <?php                
              }
              ?>
            </div>
              <?php
            }
            ?>
          
            <!--begin::Comment Form-->
            
            <form class="mt-3" action="" method="POST">
              <label for="social-comment" class="visually-hidden"> Write a comment </label>
              <input type="text"  name="comment" class="form-control form-control-sm"
                placeholder="Type a comment" />
            </form>
            <!--end::Comment Form-->
          </div>
          <!--end::Card Footer-->
        </div>
        <!--end::Social Widget-->
      </div>
      <!--end::Col-->
      <!--begin::Col-->
     </div>
  </div>

          <!--begin::Footer-->
          <div>
         <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">
        <a href="logout.php" type="button" class="btn btn-danger"> logout</a>
        </div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy;2026&nbsp;
          <a href="#" class="text-decoration-none">blog</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
          </div>


          <script
            src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
            crossorigin="anonymous"></script>
          <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
          <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            crossorigin="anonymous"></script>
          <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
            crossorigin="anonymous"></script>
          <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
          <script src="../js/adminlte.js"></script>
          <!--end::Required Plugin(AdminLTE)-->
          <!--begin::OverlayScrollbars Configure-->
          <script>
            const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
            const Default = {
              scrollbarTheme: 'os-theme-light',
              scrollbarAutoHide: 'leave',
              scrollbarClickScroll: true,
            };
            document.addEventListener('DOMContentLoaded', function () {
              const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

              // Disable OverlayScrollbars on mobile devices to prevent touch interference
              const isMobile = window.innerWidth <= 992;

              if (
                sidebarWrapper &&
                OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
                !isMobile
              ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                  scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                  },
                });
              }
            });
          </script>
          <!--end::OverlayScrollbars Configure-->

          <!--begin::Color Mode Toggle-->
          <!-- The light/dark/auto switcher ships in adminlte.js as the ColorMode
     module (since 4.1) — no page script needed. Only the no-flash snippet
     in <head> stays inline, because it must run before first paint. -->
          <!--end::Color Mode Toggle-->

          <!--end::Script-->
</body>
<!--end::Body-->

</html>