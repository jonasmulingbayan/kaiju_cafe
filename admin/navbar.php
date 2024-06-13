<?php 
    include ('assets/database.php');
    session_start();
    $myId =  $_SESSION['adminuserId'];
    $sql1 = "SELECT * FROM tbl_users WHERE user_ID = $myId";
    $sql2 = mysqli_query($conn, $sql1);
    while($row = mysqli_fetch_assoc($sql2)){
    $uname = $row['username'];
    $lname = $row['latName'];
    $fname = $row['firstName'];
    }

    $profilename = $fname.' '.$lname;
    $image = "../../admin/assets/img/profile.png";
?>
<html>
<head>
<title></title>
<link rel = "icon" href ="assets/img/kaijulogo.jpg" type = "image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar">
        <a href="../dashboard" class="navbar-brand mx-5 mb-3">
            <img src="../assets/img/kaijulogo.jpg" alt="Kaiju Cafe" class="mt-2" style="width:100%; height: 60px;">
        </a>
        <div class="navbar-nav w-100">
            <a href="../dashboard" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="../reservations" class="nav-item nav-link"><i class="fa fa-laptop me-2"></i>Reservations</a>
            <a href="../users" class="nav-item nav-link"><i class="fa fa-user me-2"></i>Users</a>               
        </div>
    </nav>
</div>
<!-- Sidebar End -->

<!-- Content Start -->
<div class="content">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand sticky-top px-4 py-0" style = "background:#770c23;">
        <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
            <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
        </a>
        <a href="#" class="sidebar-toggler flex-shrink-0" style="color:#770c23;">
            <i class="fa fa-bars"></i>
        </a>
        <form class="d-none d-md-flex ms-4">
        <?php
            date_default_timezone_set('Asia/Manila');
            $date = date('m/d/Y h:i a', time());
        ?>
        <span class="text-white">Welcome to Admin Portal!</span>
        </form>
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link text-white dropdown-toggle" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-2" src="<?php echo $image ?>" alt="" style="width: 40px; height: 40px;">
                    <span class="d-none d-lg-inline-flex"><?php echo $profilename ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end border-0 rounded-0 rounded-bottom m-0" style="background: #770c23;">
                    <a href="../profile" class="dropdown-item">My Profile</a>
                    <a href="../assets/_logout.php" class="dropdown-item">Log Out</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
</html>
