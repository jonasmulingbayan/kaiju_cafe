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
    <link rel="stylesheet" href="css/reminders_page.css">
</head>
<body>
  <div class="background"></div>
  <div class="content-container">
      <div class="left-content">
      <a href = "book_page.php"><img src="images/KAIJU-Logo-Full_Lockup-White.png" alt="Kaiju Logo"></a>
          <h1>Hey there, Kawaii Friends!</h1>
          <div class="p-wrapper">
              <p>A reminder to book your table at Kaiju Cafe to ensure you get the best spot for all your delicious food and drink cravings!</p>
          </div>
      </div>
      <div class="right-content">
          <h2>Here's how to make your visit extra awesome:</h2>
          <ul>
              <li><span class="custom-icon"><span class="custom-check">&#10003;</span></span> <b>Reserve Early</b><br> <p class="reminder-text">Our cozy spots fill up fast, so book ahead to secure your table.</p></li>
              <li><span class="custom-icon"><span class="custom-check">&#10003;</span></span> <b>Be on Time</b><br> <p class="reminder-text">Arriving on time helps us serve you better and keeps the good vibes flowing.</p></li>
              <li><span class="custom-icon"><span class="custom-check">&#10003;</span></span> <b>Cancellation</b><br> <p class="reminder-text">If plans change, please let us know at least 24 hours in advance.</p></li>
          </ul>
          <p class="last-text">We can't wait to welcome you for a chill and delightful time! See you soon!</p>
          <button id="reservation-button">PROCEED TO RESERVATIONS</button>
      </div>
  </div>

  <script>
    document.getElementById('reservation-button').addEventListener('click', function() {
        window.location.href = 'table_page.php'; 
    });
  </script>

</body>
</html>
