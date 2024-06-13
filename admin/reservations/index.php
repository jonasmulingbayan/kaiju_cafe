<?php 
include ('../assets/database.php');
session_start();
if (isset($_SESSION['adminuserId'])) {

if(isset($_POST['accept'])){
    $ID = $_POST['reservation_ID'];
    $status = "ACCEPTED";
    $sqlAccept = "UPDATE tbl_reservation SET reservation_status = '$status' WHERE reservation_ID='$ID'";
    $sqlres = mysqli_query($conn,$sqlAccept);
        if($sqlres){
            echo'<script>alert("Reservation Accepted");
            window.history.back(1);</script>';
        }
}

if(isset($_POST['cancel'])){
    $ID = $_POST['reservation_ID'];
    $status = "CANCELED";
    $sqlAccept = "UPDATE tbl_reservation SET reservation_status = '$status' WHERE reservation_ID='$ID'";
    $sqlres = mysqli_query($conn,$sqlAccept);
        if($sqlres){
            echo'<script>alert("Reservation Canceled");
            window.history.back(1);</script>';
        }
}

if(isset($_POST['finish'])){
    $ID = $_POST['reservation_ID'];
    $status = "FINISHED";
    $sqlAccept = "UPDATE tbl_reservation SET reservation_status = '$status' WHERE reservation_ID='$ID'";
    $sqlres = mysqli_query($conn,$sqlAccept);
        if($sqlres){
            echo'<script>alert("Reservation Finished");
            window.history.back(1);</script>';
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>KAIJU CAFE | RESERVATIONS</title>
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
            <div class="row g-4">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <form method="POST" action="functions.php" target="_blank">           
                                <div class="input-group input-daterange">
                                    <label for = "date" style = "padding-top:8px;">FROM:&nbsp; </label>
                                    <input type="date" class="form-control" name="from" required>
                                    <label for = "date" style = "padding-top:8px;">&nbsp;TO:&nbsp; </label>
                                    <input type="date" class="form-control" name="to" required>&nbsp;&nbsp;&nbsp;
                                    <select class="form-select" name="filetype" aria-label="Default select example" required>
                                        <option disabled selected>Select File</option>
                                        <option value="pdf">PDF</option>
                                        <option value="excel">EXCEL</option>  
                                    </select>
                                </div>
                                </div>
                                <div class="col-sm">
                                    <button type="submit" name="export" class="btn btn-primary">Export</button>
                                </div>
                            </form>
                        </div>
                    </div>           
            <div class="bg-light rounded h-100 p-4">
                <h3>List of Reservations</h3>
                <div class="table-responsive">
                    <table class="table" id="tblcategory">   
                        <thead>
                            <tr style="text-align:center;">
                                <th scope="col">Name</th>
                                <th scope="col">Contact #</th>
                                <th scope="col">Email</th>
                                <th scope="col">Occasion</th>
                                <th scope="col">Request</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">PAX</th>
                                <th scope="col">SEATING</th>
                                <th scope="col">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql1 = "SELECT * FROM tbl_reservation";
                            $sqlres = mysqli_query($conn, $sql1);  
                            while($row = mysqli_fetch_assoc($sqlres)){
                                $id = $row['reservation_ID']; 
                                $firstname = $row['reservation_firstName'];  
                                $lastname = $row['reservation_lastName'];
                                $mobilenumber = $row['reservation_mobileNumber'];
                                $email = $row['reservation_email'];
                                $occasion = $row['reservation_occasion'];
                                $request = $row['reservation_request'];
                                $date = $row['reservation_date'];
                                $time = $row['reservation_time'];
                                $pax = $row['reservation_pax'];
                                $seating = $row['reservation_seating'];
                                $status = $row['reservation_status'];
                                $fullname = $firstname.' '.$lastname;
                        ?>
                            <tr style="text-align:center;">
                                <td><?php echo $fullname ?></td>
                                <td><?php echo $mobilenumber ?></td>
                                <td><?php echo $email ?></td>
                                <td><?php echo $occasion ?></td>
                                <td><?php echo $request ?></td>
                                <td><?php echo $date ?></td>
                                <td><?php echo date("g:i A", strtotime($time)); ?></td>
                                <td><?php echo $pax ?></td>
                                <td><?php echo $seating ?></td>
                                <td>
                                <form method = "POST">
                                    <input type = "hidden" name = "reservation_ID" value = "<?php echo $id ?>"/>
                                    <?php if($status == "PENDING"){?>
                                    <button type="submit" name = "accept" class="btn btn-primary mb-2">ACCEPT</button>
                                    <button type="submit" name = "cancel" class="btn btn-danger mb-2">CANCEL</button>
                                    <?php }
                                    else if($status == "ACCEPTED"){?>
                                    <button type="submit" name = "finish" class="btn btn-success mb-2">FINISHED</button>
                                    <?php }
                                    else if($status == "CANCELED"){?>
                                        CANCELED
                                        <?php } 
                                    else{?>
                                        FINISHED
                                    <?php }?> 
                                </form>
                                </td>  
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