<?php 
include ('../assets/database.php');
session_start();
if (isset($_SESSION['adminuserId'])) {
    $myId =  $_SESSION['adminuserId'];

$sqlprof = "SELECT * FROM tbl_users WHERE user_ID = '$myId'";
$sqlres = mysqli_query($conn,$sqlprof);
$row = mysqli_fetch_assoc($sqlres);

$user = $row['username'];
$fname = $row['firstName'];
$lnames = $row['lastName'];
$pass = $row['user_password'];

if(isset($_POST['change'])){
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $pass = md5($_POST['password']);

    $sqlup = mysqli_query($conn, "UPDATE tbl_users SET user_password='$pass', firstName = '$fname', lastName = '$lname' WHERE user_ID = '$myId'");
    echo'<script> 
    alert("Profile Updated Successfully");
    window.location=document.referrer;</script>";';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>KAIJU CAFE | USERS</title>
<link rel = "icon" href ="../assets/img/vetapp-logo.jpeg" type = "image/x-icon">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="" name="keywords">
<meta content="" name="description">
<?php include '../includes/link.php'?> 
</head>
<body>
<?php include '../spinner/spinner.php';?>
<?php require '../navbar.php'; ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4"></h6>
                <div class="container-xl px-4 mt-4">
                    <div class="row">
                        <!-- Profile picture card -->
                        <div class="col-xl-4">
                            <div class="card mb-4 mb-xl-0">
                                <div class="card-header">Profile Picture</div>
                                <div class="card-body text-center">
                                    <img class="img-account-profile rounded-circle mb-2" src="../../admin/assets/img/profile.png" style="width: 100%; height: 50%;" alt="">
                                    <div class="small font-italic text-muted mb-4">DEFAULT PROFILE ADMIN</div>
                                </div>
                            </div>
                        </div>
                        <!-- Account details card -->
                        <div class="col-xl-8">
                            <div class="card mb-4">
                                <div class="card-header">Account Details</div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputUsername">Username</label>
                                            <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Enter your username" value="<?php echo $user ?>" readonly>
                                        </div>
                                        <!-- Form Row -->
                                        <div class="row gx-3 mb-5">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputFirstName">First name</label>
                                                <input class="form-control" id="inputFirstName" name="fname" type="text" placeholder="Enter your first name" value="<?php echo $fname ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputLastName">Last name</label>
                                                <input class="form-control" id="inputLastName" name="lname" type="text" placeholder="Enter your last name" value="<?php echo $lnames ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Enter your password" value="<?php echo $pass ?>">
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit" name="change">Save changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/script.php'?>
</body>
</html>
<?php

}
else {
   header("location: ../login.php");
}
?>