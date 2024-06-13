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
    <link rel="stylesheet" href="css/table_page.css">
</head>
<body>
    <div class="background"></div>

    <!-- Logo -->
    <div class="logo-container">
    <a href = "book_page.php"><img src="images/KAIJU-Logo-Full_Lockup-White.png" alt="Logo"></a>
    </div>

    <div class="table-page-container">
        <form method="GET" action="details_page.php">
        <!-- Numbering and Loading Line -->
        <div class="numbering-container">
            <div class="numbering">
                <div class="number first-number">1.</div>
                <div class="number-label first-label">FIND A TABLE</div>
            </div>
            <div class="numbering">
                <div class="number">2.</div>
                <div class="number-label">YOUR DETAILS</div>
            </div>
        </div>

        <div class="loading-line">
             <div class="line1"></div>
             <div class="line2"></div>
        </div>

        <!-- Elements below numbering -->
        <div class="form-container">
            <!-- Dropboxes -->
            <div class="dropdown">
                <select id="pax-dropdown" name="pax"> </select>
            </div>
            <div class="dropdown">
                <input type="text" id="date-picker" name="date" placeholder="Select a date">
            </div>
            <div class="dropdown">
                <select id="time-dropdown" name="time"></select>
            </div>
            <div class="dropdown">
                <select id="seating-dropdown" name="seating"></select>
            </div>
            <!-- Button -->
            <button type="submit" id="find-table-button">FIND A TABLE</button>
        </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const paxDropdown = document.getElementById('pax-dropdown');
        for (let i = 1; i <= 20; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = `${i} pax`;
            paxDropdown.appendChild(option);
        }

        function isWeekend(date) {
            const day = date.getDay();
            return day === 0 || day === 6;
        }

        function updateAvailableTimes(selectedDate) {
            const timeDropdown = document.getElementById('time-dropdown');
            const weekdayTimes = [
                'Time', '9:00 AM', '10:00 AM', '11:00 AM',
                '12:00 PM', '1:00 PM', '2:00 PM',
                '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM' , '7:00 PM'
            ];
            const weekendTimes = [
                'Time', '8:00 AM', '9:00 AM', '10:00 AM',
                '11:00 AM', '12:00 PM', '1:00 PM',
                '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM'
            ];

            timeDropdown.innerHTML = '';
            const availableTimes = isWeekend(selectedDate) ? weekendTimes : weekdayTimes;
            availableTimes.forEach(time => {
                const option = document.createElement('option');
                option.value = time;
                option.textContent = time;
                timeDropdown.appendChild(option);
            });
        }

        const currentYear = new Date().getFullYear();
        flatpickr("#date-picker", {
            dateFormat: "F j",
            minDate: "today",
            maxDate: new Date(currentYear, 11, 31),
            altInput: true,
            altFormat: "F j",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    updateAvailableTimes(selectedDates[0]);
                }
            }
        });

        const seatingDropdown = document.getElementById('seating-dropdown');
        const seatingOptions = ['Indoor', 'Alfresco'];
        seatingOptions.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option;
            optionElement.textContent = option;
            seatingDropdown.appendChild(optionElement);
        });

        updateAvailableTimes(new Date());
    </script>
</body>
</html>
