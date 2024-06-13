<?php 
include ('../assets/database.php');
session_start();
if (isset($_SESSION['adminuserId'])) {

// Fetch schedules from the database
$schedules = $conn->query("SELECT * FROM `tbl_reservation`");
$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    // Combine reservation_date and reservation_time to form a complete datetime string
    $start_datetime = date('Y-m-d H:i:s', strtotime($row['reservation_date'] . ' ' . $row['reservation_time']));
    
    // Create an event object with required fields
    $event = [
        'id' => $row['reservation_ID'],
        'title' => $row['reservation_occasion'],
        'start_datetime' => $start_datetime,
        'pax' => $row['reservation_pax'], // Include reservation_pax
        'status' => $row['reservation_status'],
        'fname' => $row['reservation_firstName'],
        'lname' => $row['reservation_lastName'],
    ];

   
    // Assign a className based on status
    switch ($row['reservation_status']) {
        case 'CANCELED':
            $event['className'] = 'status-cancel';
            break;
        case 'ACCEPTED':
            $event['className'] = 'status-accepted';
            break;
        case 'FINISHED':
            $event['className'] = 'status-finished';
            break;
        case 'PENDING':
            $event['className'] = 'status-pending';
            break;
    }
    $sched_res[] = $event;
}

$sqlPending = mysqli_query($conn,"SELECT * FROM tbl_reservation WHERE reservation_status = 'PENDING'");
$totalpending = mysqli_num_rows($sqlPending); 

$sqlAccepted = mysqli_query($conn,"SELECT * FROM tbl_reservation WHERE reservation_status = 'ACCEPTED'");
$totalaccepted = mysqli_num_rows($sqlAccepted); 

$sqlCanceled = mysqli_query($conn,"SELECT * FROM tbl_reservation WHERE reservation_status = 'CANCELED'");
$totalcanceled = mysqli_num_rows($sqlCanceled); 

$sqlFinish = mysqli_query($conn,"SELECT * FROM tbl_reservation WHERE reservation_status = 'FINISHED'");
$totalfinished = mysqli_num_rows($sqlFinish); 

$sqlUsers = mysqli_query($conn,"SELECT * FROM tbl_users");
$totalUsers = mysqli_num_rows($sqlUsers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>KAIJU CAFE | ADMIN</title>
    <link rel = "icon" href ="../assets/img/kaijulogo.jpg" type = "image/x-icon">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="stylesheet" href="css/styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="fullcalendar/lib/main.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <?php include '../includes/link.php'?>

    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var dateData = google.visualization.arrayToDataTable([
            ['Date', 'Reservations'],
            <?php
            $sql1 = "SELECT DATE(reservation_date) as res_date, COUNT(*) as reservation_count FROM tbl_reservation WHERE reservation_status = 'FINISHED' GROUP BY reservation_date ORDER BY reservation_date";
            $sqlres1 = mysqli_query($conn, $sql1);
            while ($row = mysqli_fetch_assoc($sqlres1)) {
                $date = $row['res_date'];
                $count = $row['reservation_count'];
                echo "['".$date."', ".$count."],";
            }
            ?>
        ]);

        var dateOptions = {
            title: 'Reservations per Date',
            hAxis: {
                title: 'Date',
                titleTextStyle: { color: '#333' }
            },
            vAxis: {
                title: 'Number of Reservations',
                minValue: 0
            }
        };

        var timeData = google.visualization.arrayToDataTable([
            ['Time', 'Reservations'],
            <?php
            $sql2 = "SELECT TIME_FORMAT(reservation_time, '%h %p') as res_time, COUNT(*) as reservation_count FROM tbl_reservation WHERE reservation_status = 'FINISHED' GROUP BY reservation_time ORDER BY reservation_time";
            $sqlres2 = mysqli_query($conn, $sql2);
            while ($row = mysqli_fetch_assoc($sqlres2)) {
                $time = $row['res_time'];
                $count = $row['reservation_count'];
                echo "['".$time."', ".$count."],";
            }
            ?>
        ]);

        var timeOptions = {
            title: 'Reservations per Time',
            hAxis: {
                title: 'Time',
                titleTextStyle: { color: '#333' }
            },
            vAxis: {
                title: 'Number of Reservations',
                minValue: 0
            }
        };

        var dateChart = new google.visualization.BarChart(document.getElementById('reservationDateGraph'));
        var timeChart = new google.visualization.BarChart(document.getElementById('reservationTimeGraph'));

        dateChart.draw(dateData, dateOptions);
        timeChart.draw(timeData, timeOptions);
    }

    </script>
</head>
<body>
<?php include '../spinner/spinner.php';?>
<?php require '../navbar.php'; ?>

<div class="container-fluid pt-4 px-4 ">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <a href="../users/index.php">
                <div class="rounded d-flex align-items-center justify-content-between p-4" style="background: #770c23;">
                    <i class="fa fa-users fa-3x text-primary text-white"></i>
                    <div class="ms-3">
                        <p class="mb-2 text-white">Total Users</p>
                        <h6 class="mb-0 text-white"><?php echo $totalUsers ?></h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-6 col-xl-3">
            <a href="../reservations/index.php">
                <div class="rounded d-flex align-items-center justify-content-between p-4" style="background: #770c23;">
                    <i class="fa fa-receipt fa-3x text-primary text-white"></i>
                    <div class="ms-3">
                        <p class="mb-2 text-white">Pending Reservations</p>
                        <h6 class="mb-0 text-white"><?php echo $totalpending ?></h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-6 col-xl-3">
            <a href="../reservations/index.php">
                <div class="rounded d-flex align-items-center justify-content-between p-4" style="background: #770c23;">
                    <i class="fa fa-receipt fa-3x text-primary text-white"></i>
                    <div class="ms-3">
                        <p class="mb-2 text-white">Cancelled Reservations</p>
                        <h6 class="mb-0 text-white"><?php echo $totalcanceled ?></h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-6 col-xl-3">
            <a href="../reservations/index.php">
                <div class="rounded d-flex align-items-center justify-content-between p-4" style="background: #770c23;">
                    <i class="fa fa-receipt fa-3x text-primary text-white"></i>
                    <div class="ms-3">
                        <p class="mb-2 text-white">Finished Reservations</p>
                        <h6 class="mb-0 text-white"><?php echo $totalfinished ?></h6>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="for-graph">
    <div id="for-date" class="container-fluid pt-4 px-4">
        <div class="text-center rounded p-4" style="background: #770c23;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0 text-white">Reservations per Date</h6>
            </div>
            <div id="reservationDateGraph"></div>
        </div>
    </div>
    <div id="for-time" class="container-fluid pt-4 px-4">
        <div class="text-center rounded d-flex flex-column justify-content-center p-4" style="background: #770c23;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0 text-white">Reservations per Time</h6>
            </div>
            <div id="reservationTimeGraph"></div>
        </div>
    </div>
</div>

<!-- Calendar -->
<div class="container-fluid pt-4 px-4">
<div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="card rounded-0 shadow">
                    <div class="card-header text-light" style="background: #770c23;">
                        <h5 class="card-title text-white">Reservation Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <dl>
                                <dt class="text-muted">Reservation Occasion:</dt>
                                <dd id="modal-title" class="fw-bold fs-4">N/A</dd>
                                <dt class="text-muted">Reservation Date & Time:</dt>
                                <dd id="modal-start">N/A</dd>
                                <dt class="text-muted">PAX:</dt>
                                <dd id="modal-pax">N/A</dd>
                                <dt class="text-muted">Reserved By:</dt>
                                <dd id="modal-reserver">N/A</dd>
                                <dt class="text-muted">Status:</dt>
                                <dd id="modal-status">N/A</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="my-4">
                    <h5>Legend</h5>
                    <div class="d-flex justify-content-start align-items-center gap-2 mb-1">
                        <button style = "width:40px;height:20px;background:red;border:none"></button> <p class="m-0">- Canceled</p> 
                    </div>
                    <div class="d-flex justify-content-start align-items-center gap-2 mb-1">
                        <button style = "width:40px;height:20px;background:blue;border:none"></button> <p class="m-0">- Finished</p> 
                    </div>
                    <div class="d-flex justify-content-start align-items-center gap-2 mb-1">
                        <button style = "width:40px;height:20px;background:green;border:none"></button> <p class="m-0">- Accepted</p> 
                    </div>
                    <div class="d-flex justify-content-start align-items-center gap-2 mb-1">
                        <button style = "width:40px;height:20px;background:black;border:none"></button> <p class="m-0">- Pending</p> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="js/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Bundle -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- FullCalendar -->
<script src="fullcalendar/lib/main.min.js"></script>
<!-- Custom Script -->
<script>
    var scheds = <?= json_encode($sched_res) ?>;

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            themeSystem: 'bootstrap',
            events: scheds.map(function(event) {
                return {
                    id: event.id,
                    title: event.title,
                    start: new Date(event.start_datetime),
                    pax: event.pax,
                    status: event.status,
                    fname: event.fname, // Include fname from PHP
                    lname: event.lname, // Include lname from PHP
                    className: event.className // Include className from PHP
                };
            }),
            eventClick: function(info) {
                var event = info.event;

                // Format the date and time for display with AM/PM
                var formattedDate = new Date(event.start);
                var displayDate = formattedDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                var displayTime = formattedDate.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

                // Display full name
                var fullName = event.extendedProps.fname + ' ' + event.extendedProps.lname;
                var PAX = event.extendedProps.pax;

                // Display event details including status, pax, and full name
                $('#modal-title').text(event.title);
                $('#modal-start').text(displayDate + ' - ' + displayTime);
                $('#modal-pax').text(event.extendedProps.pax); // Display pax
                $('#modal-reserver').text(fullName);
                $('#modal-status').text(event.extendedProps.status); // Access status via extendedProps
                $('#event-details-modal').modal('show');
            },
            eventClassNames: function(arg) {
                // Add custom CSS class 'has-reservation' to dates with reservations
                return arg.event.extendedProps.className;
            }
        });
        calendar.render();
    });
</script>
<?php include '../includes/script.php'?>
</body>
</html>
<?php
} else {
    header("location: ../login.php");
}
?>
