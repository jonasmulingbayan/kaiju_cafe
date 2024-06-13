<?php 

 include ('../assets/database.php');
 session_start();
 if (isset($_SESSION['adminuserId'])) {
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>KAIJU CAFE | USERS</title>
<link rel = "icon" href ="../assets/img/kaijulogo.jpg" type = "image/x-icon">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="" name="keywords">
<meta content="" name="description">
<?php include '../includes/link.php'?> 
</head>
<body>
<?php include '../spinner/spinner.php';?>
<?php require '../navbar.php'; ?>
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h3>List of Users</h3>
                <div class="table-responsive">
                    <table class="table" id="tblcategory">   
                        <thead>
                            <tr style="text-align:center;">
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql1 = "SELECT * FROM tbl_users";
                            $sqlres = mysqli_query($conn, $sql1);  
                            while($row = mysqli_fetch_assoc($sqlres)){
                                $username = $row['username'];  
                                $firstname = $row['firstName'];  
                                $lastname = $row['lastName'];  
                                $email = $row['email'];  
                                $id = $row['user_ID']; 
                                $fullname = $firstname.' '.$lastname;
                        ?>
                            <tr style="text-align:center;">
                                <td><?php echo $username ?></td>
                                <td><?php echo $fullname ?></td>
                                <td><?php echo $email ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>     
                    </table>
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