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
    <link rel="stylesheet" href="css/thanks_page.css">
</head>
<body>
    <div class="background"></div>

    <!-- Logo -->
    <div class="logo-container">
        <img src="images/KAIJU-Logo-Full_Lockup-White.png" alt="Logo">
    </div>

    <!-- Message Container -->
    <div class="message">
        <h1>Thanks for booking your table at Kaiju Cafe!</h1>
        <p>We can't wait to see you and share the fun! </p>
    </div>

    <script>
        function redirectAfterDelay() {
            setTimeout(function() {
                window.location.href = "book_page.php";
            }, 5000); // 5000 milliseconds = 5 seconds
        }

        // Call the function to initiate the redirect
        redirectAfterDelay();
    </script>
</body>
</html>
