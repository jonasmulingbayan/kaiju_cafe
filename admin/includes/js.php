   <!-- JavaScript Libraries -->
   <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Template Javascript -->
    <script src="../assets/js/main.js"></script>

    <script>      
    var todayDate = new Date();
    var month = todayDate.getMonth() +1;//Current Month
    var year = todayDate.getUTCFullYear(); //Current Year
    var tdate = todayDate.getDate(); //current Date
    if(month < 10){
        month = "0" + month //'0' + 4 = 04
      }
      if(tdate < 10){
        tdate = "0" + tdate;
      }
    var maxDate = year + "-" + month + "-" + tdate;
    document.getElementById("start_date").setAttribute("max", maxDate);
    console.log(maxDate);
    </script>