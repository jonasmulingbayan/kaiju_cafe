<?php 
include ('../assets/database.php');
$datetoday = date("Y-m-d", strtotime($currentdate));
session_start();
$myId =  $_SESSION['adminuserId'];
$sqluser = "SELECT * FROM tbl_users WHERE user_ID = $myId";
$sql2 = mysqli_query($conn, $sqluser);
while($row = mysqli_fetch_assoc($sql2)){
    $uname = $row['username'];
    $lname = $row['lastName'];
    $fname = $row['firstName'];
    $fullnames = $fname.' '.$lname; // corrected variable names
}

if(isset($_POST['export'])){
    $from = $_POST['from'];
    $to = $_POST['to'];
    $file = $_POST['filetype'];
    $status = "FINISHED";

    if($file == 'pdf'){
        require_once('../tcpdf/tcpdf.php');  
    
        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
        $pdf->SetCreator(PDF_CREATOR);  
        $pdf->SetTitle('Report: '.$from.' - '.$to);  
        $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
        $pdf->SetDefaultMonospacedFont('helvetica');  
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
        $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
        $pdf->setPrintHeader(false);  
        $pdf->setPrintFooter(false);  
        $pdf->SetAutoPageBreak(TRUE, 10);  
        $pdf->SetFont('helvetica', '', 11);  
        $pdf->AddPage();

        $query = "SELECT * FROM tbl_reservation WHERE DATE(reservation_date) BETWEEN '$from' AND '$to' AND reservation_status = '$status'";
        $result = mysqli_query($conn, $query);

        $content = '<html>
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <style>
        .for-images{
            text-align:center;
            align-items:center;
            justify-content:center;
        }
        .for-header img{
            width:50px;
            height:px;
        }
        .for-header{
            line-height:10px;
            display:flex;
            text-align:center;
            align-items:center;
            justify-content:center;
        }
        th{
            text-align:center;border-bottom:1px solid black;
        }
        table{
            border:1px solid black;padding:3px;
        }
        td{
            text-align:center;
        }
        </style>';

        $content .= ' 
        </head>
        <body>
        
        <div class = "for-header">
        <img src = "https://media.discordapp.net/attachments/1019164491306504217/1043925358409424967/theparklogo.png">
        <h3>Kaiju Cafe</h3>
        <h4>La Finca Farm, San Pablo Road,
        Brgy. Dagatan, Lipa City, Batangas</h4>
        <br>
        <h4>RESERVATION REPORT</h4>
        </div>
        <p>FROM: '.$from.' TO: '.$to.'</p>
        <table class="table" id="tblcategory">                        
        <thead >
            <tr>
                <th scope="col">Customers Name</th>                                   
                <th scope="col">Contact No.</th>
                <th scope="col">Email</th>
                <th scope="col">Occasion</th>
                <th scope="col">Request</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">PAX</th>
                <th scope="col">Seating</th>
            </tr>
        </thead>
        <tbody>';
        while($row = mysqli_fetch_assoc($result)){
            $fullname = $row['reservation_firstName'].' '.$row['reservation_lastName'];
            // Convert date to "Month, day, year" format
            $formattedDate = date("F j, Y", strtotime($row['reservation_date']));
            // Convert time to "AM/PM" format
            $formattedTime = date("h:i A", strtotime($row['reservation_time']));
         
            $content .= '  <tr>
            <td>'.$fullname.'</td>                  
            <td>'.$row['reservation_mobileNumber'].'</td>
            <td>'.$row['reservation_email'].'</td> 
            <td>'.$row['reservation_occasion'].'</td> 
            <td>'.$row['reservation_request'].'</td>
            <td>'.$formattedDate.'</td>
            <td>'.$formattedTime.'</td>
            <td>'.$row['reservation_pax'].'</td>                                
            <td>'.$row['reservation_seating'].'</td> 
        
            </tr>';
        }

        $sql = "SELECT COUNT(*) AS total_finished_reservations FROM tbl_reservation WHERE reservation_status = 'FINISHED'";
        $resul2t = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($resul2t);
        $totalFinishedReservations = $row['total_finished_reservations'];

        $content .= '
        </tbody>
        </table>
        <div class = "for-footer">
        <h4 class = "date-exported">TOTAL RESERVATIONS: '.$totalFinishedReservations.' </h4>
        <h4 class = "date-exported">DATE EXPORTED: '.$datetoday.' </h4>
        <h4 class = "exported-by">EXPORTED BY: '.$fullnames.' </h4>
        </div>
        </body>
        </html>';
        $pdf->writeHTML($content); 
        $pdf->Output('report.pdf', 'I');
    } else {
        // CSV export logic
        $query = "SELECT * FROM tbl_reservation WHERE DATE(reservation_date) BETWEEN '$from' AND '$to' AND reservation_status = '$status'";
        $result5 = mysqli_query($conn, $query);

        $csv_header = 'Customers Name, Contact No., Email, Occasion, Request, Date, Time, PAX, Seating' . "\n";
        $csv_data = '';

        while($row = mysqli_fetch_assoc($result5)){
            $fullname = $row['reservation_firstName'].' '.$row['reservation_lastName'];
            // Convert date to "Month, day, year" format
            $formattedDate = date("F j, Y", strtotime($row['reservation_date']));
            // Convert time to "AM/PM" format
            $formattedTime = date("h:i A", strtotime($row['reservation_time']));
         
            $csv_data .= '"' . $fullname . '","' . $row['reservation_mobileNumber'] . '","' . $row['reservation_email'] . '","' . $row['reservation_occasion'] . '","' . $row['reservation_request'] . '","' . $formattedDate . '","' . $formattedTime . '","' . $row['reservation_pax'] . '","' . $row['reservation_seating'] . '"' . "\n";
        }

        $sql = "SELECT COUNT(*) AS total_finished_reservations FROM tbl_reservation WHERE reservation_status = 'FINISHED'";
        $result6 = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result6);
        $totalFinishedReservations = $row['total_finished_reservations'];

        $csv_data .= 'TOTAL RESERVATIONS:,' . $totalFinishedReservations . "\n";
        $csv_data .= 'DATE EXPORTED:,' . $datetoday . "\n";
        $csv_data .= 'EXPORTED BY:,' . $fullnames . "\n";

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=reports.csv');
        echo $csv_header . $csv_data;
        exit;
    }
}
?>
