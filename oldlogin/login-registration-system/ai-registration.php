<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <?php
// database connection file ကို include လုပ်ပါ
// include('config.php'); 

if (isset($_POST['register_user'])) {
    // Input မားကို လုံခြုံအောင် လက်ခံမယ်
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $address = trim($_POST['address']);
    $input_password = $_POST['password'];

    // ဖြည့်ရမယ့်ကွက်လပ် ရှိ/မရှိ အခြေခံစစ်ဆေးခြင်း
    if (empty($name) || empty($email) || empty($input_password)) {
        echo "<script>alert('ကျေးဇူးပြု၍ လိုအပ်သော အချက်အလက်များ အကုန်ဖြည့်ပါ');</script>";
    } else {
        
        // ၁။ Email တူတာ ရှိ၊ မရှိ အရင်စစ်မယ် (ထပ်နေရင် ပေးမသွင်းဘူး)
        $check_email = mysqli_prepare($dbconnection, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($check_email, "s", $email);
        mysqli_stmt_execute($check_email);
        mysqli_stmt_store_result($check_email);
        
        if (mysqli_stmt_num_rows($check_email) > 0) {
            echo "<script>alert('ဒီ Email နဲ့ အကောင့်ဖွင့်ထားပြီးသား ဖြစ်နေပါတယ်');</script>";
        } else {
            // ၂။ Password ကို md5 မသုံးဘဲ လုံခြုံရေးအကောင်းဆုံးစနစ်နဲ့ Hash လုပ်မယ်
            $secure_password = password_hash($input_password, PASSWORD_BCRYPT);

            // ၃။ Database ထဲသို့ Prepared Statement သုံးပြီး လုံခြုံစွာ ထည့်သွင်းမယ်
            $insert_query = "INSERT INTO users (name, email, address, password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($dbconnection, $insert_query);
            
            // "ssss" ဆိုတာ သွင်းမယ့် data ၄ ခုလုံးက string ဖြစ်လို့ပါ
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $address, $secure_password);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo "<script>
                    alert('အကောင့်ဖွင့်ခြင်း အောင်မြင်ပါသည်။ Login ဝင်နိုင်ပါပြီ။');
                    window.location.href = 'login.php';
                </script>";
                exit();
            } else {
                die('Error: ' . mysqli_error($dbconnection));
            }
        }
    }
}
?>

    <!-- HTML Registration Form ဥပမာ -->
     <div class='card'>
        <div class='card-header'>
             <h2>အကောင့်သစ်ဖွင့်ရန်</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="" method="POST" class='form-control'>           
                        <input type="text" name="name" class="form-control" placeholder="နာမည်" required><br><br>
                        <input type="email" name="email"  class="form-control" placeholder="အီးမေးလ်" required><br><br>
                        <input type="text" name="address" class="form-control" placeholder="နေရပ်လိပ်စာ"><br><br>
                        <input type="password" name="password" class="form-control" placeholder="စကားဝှက် (Password)" required><br><br>
                        <button type="submit" name="register_user">Register လုပ်ရန်</button>
                    </form>
                </div>
                <div class="col-md-3"></div>                
            </div>

        </div>
        
    </div>
    <!-- <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">login page</div>
                            </div>
                            <div class="col-md-6">
                                <a href="www.google.com" class="float-end ms-2">back to home</a>
                            </div>
                        </div>
                    </div>
                    <form>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="">Password</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div>
                                <button class="btn btn-danger">login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>