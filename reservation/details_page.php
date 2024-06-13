<?php
include('database.php');
session_start();

if (isset($_GET['pax']) && isset($_GET['date']) && isset($_GET['time']) && isset($_GET['seating'])) {
    $pax = $_GET['pax'];
    $date = date('Y-m-d', strtotime($_GET['date'])); // Format date as YYYY-MM-DD
    $time = date('H:i:s', strtotime($_GET['time'])); // Format time as HH:MM:SS
    $seating = $_GET['seating'];

    // Check if the form is submitted
    if (isset($_POST['submit'])) {

        // Set timezone
        date_default_timezone_set('Asia/Manila');

        // Get current date and time
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');

        // Combine date and time into DateTime objects for comparison
        $current_datetime = new DateTime("$current_date $current_time");
        $selected_datetime = new DateTime("$date $time");

        // Check if the selected date and time is in the past
        if ($selected_datetime < $current_datetime) {
            echo "<script>alert('The selected date and time is in the past. Please select a future date and time.');
            window.history.back(1);</script>";
            exit();
        }

        // Prepare SQL statement for checking existing reservations
        $check_sql = "SELECT * FROM tbl_reservation WHERE reservation_date = '$date' AND reservation_time = '$time'";
        $sqlres = mysqli_query($conn, $check_sql);

        if ($sqlres->num_rows > 0) {
            echo "<script>alert('There is already a reservation for this date and time.');
            window.history.back(1);</script>";
            exit();
        }

        // Prepare SQL statement for checking reservations within 1 hour of requested time
        $check_time_sql = "SELECT * FROM tbl_reservation WHERE reservation_date = '$date' AND ABS(TIMESTAMPDIFF(HOUR, reservation_time, '$time')) <= 1";
        $time_result = mysqli_query($conn, $check_time_sql);

        if ($time_result->num_rows > 0) {
            echo "<script>alert('There is already a reservation within 1 hour of the requested time.');window.history.back(1);</script>";
            exit();
        }

        // Retrieve reservation details from POST
        $first_name = $_POST['first-name'];
        $last_name = $_POST['last-name'];
        $mobile_number = $_POST['mobile-number'];
        $email = $_POST['email'];
        $occasion = $_POST['occasion'];
        $special_request = $_POST['special-request'];
        $status = "PENDING";

        // Insert reservation details into the database
        $sql = "INSERT INTO tbl_reservation (reservation_firstName, reservation_lastName, reservation_mobileNumber, reservation_email, reservation_occasion, reservation_request, reservation_date, reservation_time, reservation_pax, reservation_seating, reservation_status)
            VALUES ('$first_name', '$last_name', '$mobile_number', '$email', '$occasion', '$special_request', '$date', '$time', '$pax', '$seating', '$status')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to thankyou_page.php upon successful reservation
            header("Location: thanks_page.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    }
} else {
    echo "Required parameters are missing.";
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Page - Reservation Cafe</title>
    <link rel = "icon" href ="images/KAIJU-Logo-Full_Lockup-Color.jpg" type = "image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="css/details_page.css">
</head>
<body>
    <div class="background"></div>
    <center><form method="POST">
        <div class="detail-page-container">
            <!-- Numbering and Loading Line -->
            <div class="numbering-container">
                <div class="numbering">
                    <div class="number">1.</div>
                    <div class="number-label">FIND A TABLE</div>
                </div>
                <div class="numbering">
                    <div class="number second-number">2.</div>
                    <div class="number-label second-label">YOUR DETAILS</div>
                </div>
            </div>

            <div class="loading-line">
                 <div class="line1"></div>
                 <div class="line2"></div>
                 <div class="line3"></div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <!-- Left part: Form inputs -->
                <div class="form-left">
                    <input type="hidden" name="pax" value="<?php echo $_GET['pax']; ?>"/>
                    <input type="hidden" name="date" value="<?php echo $_GET['date']; ?>"/>
                    <input type="hidden" name="time" value="<?php echo $_GET['time']; ?>"/>
                    <input type="hidden" name="seating" value="<?php echo $_GET['seating']; ?>"/>
                    <div class="input-container">
                        <input type="text" id="first-name" name="first-name" required>
                        <label for="first-name">First Name</label>
                        <div id="first-name-error" class="error-message"></div>
                    </div>
                    <div class="input-container">
                        <input type="text" id="last-name" name="last-name" required>
                        <label for="last-name">Last Name</label>
                        <div id="last-name-error" class="error-message"></div>
                    </div>
                    <div class="input-container">
                        <label for="mobile-number">Mobile Number (Philippines)</label>
                        <input type="text" id="mobile-number" name="mobile-number" required>
                        <div id="mobile-number-error" class="error-message"></div>
                    </div>
                    <div class="input-container">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                        <div id="email-error" class="error-message"></div>
                    </div>
                    <div class="form-group occasion-container">
                        <label for="occasion"></label>
                        <select id="occasion" name="occasion">
                            <option value="none">Select an Occasion (Optional)</option>
                            <option value="birthday">Birthday</option>
                            <option value="anniversary">Anniversary</option>
                            <option value="business">Business</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group special-request-container">
                        <label for="special-request"></label>
                        <textarea id="special-request" name="special-request" placeholder="Add a special request (Optional)"></textarea></textarea>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="newsletter" name="newsletter">
                        <label for="newsletter">Yes, I want to get text updates and reminders about my reservation.*</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">Sign me up to receive dining offers and news from this restaurant by email.</label>
                    </div>
                </div>

                <!-- Right part: Reservation Details -->
                                 <div class="form-right">
                    <h2 style="text-align: left;">Reservation Details:</h2>
                    <div class="reservation-info">
                        <div class="info-item">
                            <i class="bi bi-calendar"></i>
                            <span id="selected-date"><?php echo date('F j, Y', strtotime($_GET['date'])); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-clock"></i>
                            <span id="selected-time"><?php echo date('g:i A', strtotime($_GET['time'])); ?></span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-person"></i>
                            <span id="selected-pax"><?php echo $_GET['pax']; ?></span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-geo-alt"></i>
                            <span id="selected-seating"><?php echo $_GET['seating']; ?></span>
                        </div>
                    </div>
                    <div class="line4"></div>
                 
                    <h2 style="text-align: left;">What to know before you go</h2>
                    <h3 style="text-align: left;">Important dining information</h3>
                    <div class="p-wrapper">
                        <p>We have a 15 minute grace period. Please call us if you are running later than 15 minutes after your reservation time.</p>
                    </div>
                    <div class="p-wrapper">
                        <p>We may contact you about this reservation, so please ensure your email and phone number are up to date.</p>
                    </div>
                </div>
            </div>
            
            <div class="button-container">
                <button type="submit" id="submit-button" name="submit">CONFIRM RESERVATION</button>
            </div>
        </div>
    </form></center>

    <script>
        document.querySelectorAll('.input-container input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('active');
            });
            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('active');
                }
            });
        });

        const mobileNumberInput = document.getElementById('mobile-number');
        const emailInput = document.getElementById('email');
        const submitButton = document.getElementById('submit-button');
        const mobileNumberError = document.getElementById('mobile-number-error');
        const emailError = document.getElementById('email-error');
        const firstNameInput = document.getElementById('first-name');
        const lastNameInput = document.getElementById('last-name');
        const firstNameError = document.getElementById('first-name-error');
        const lastNameError = document.getElementById('last-name-error');

        mobileNumberInput.addEventListener('focus', function() {
            if (!this.value.startsWith('+63 ')) {
                this.value = '+63 ';
            }
        });

        mobileNumberInput.addEventListener('input', function() {
            const numberOnly = this.value.replace(/\D/g, '').substring(2); // Remove all non-numeric characters and the '+63' part
            this.value = `+63 ${numberOnly}`;
        });

        mobileNumberInput.addEventListener('blur', function() {
            if (this.value === '+63 ') {
                this.value = '';
            }
        });

        submitButton.addEventListener('click', function(event) {
            const numberOnly = mobileNumberInput.value.replace(/\D/g, '').substring(2); // Get only the digits after '+63'
            if (numberOnly.length !== 10) {
                mobileNumberError.textContent = "Must consist of 10 digits ex. +63 XXXXXXXXXX";
                event.preventDefault();
            } else {
                mobileNumberError.textContent = "";
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailInput.value)) {
                emailError.textContent = "Please enter a valid email address.";
                event.preventDefault();
            } else {
                emailError.textContent = "";
            }

            if (firstNameInput.value.trim() === '') {
                firstNameError.textContent = "First name is required.";
                event.preventDefault();
            } else {
                firstNameError.textContent = "";
            }

            if (lastNameInput.value.trim() === '') {
                lastNameError.textContent = "Last name is required.";
                event.preventDefault();
            } else {
                lastNameError.textContent = "";
            }
        });
    </script>
</body>
</html>


