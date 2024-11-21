<?php
session_start();
include 'koneksi.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = $koneksi->query("SELECT * FROM pelanggan WHERE reset_token='$token'");
    
    if ($result->num_rows > 0) {
        if (isset($_POST['submit'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            if ($new_password == $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $koneksi->query("UPDATE pelanggan SET password_pelanggan='$hashed_password', reset_token=NULL WHERE reset_token='$token'");
                
                echo "<script>alert('Password has been reset successfully');</script>";
                echo "<script>location='login.php';</script>";
            } else {
                echo "<script>alert('Passwords do not match');</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid token');</script>";
        echo "<script>location='forgot_password.php';</script>";
    }
} else {
    echo "<script>location='forgot_password.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <link href="admin/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="admin/assets/css/custom.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/style.css">
    <title>Online Shop || Reset Password</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <br /><br />
                <h2 class="text-primary"><strong>Ubah Password Menjadi Baru</strong></h2>
                <br />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <strong> Ubah Password </strong>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <br />
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="new_password" required />
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="confirm_password" required />
                            </div>
                            <button class="btn btn-primary" name="submit">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>