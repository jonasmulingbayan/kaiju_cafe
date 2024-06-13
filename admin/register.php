<?php
include 'assets/database.php';
//if user signup button
if(isset($_POST['signup'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = "ADMIN";

    // Check if username or email already exists
    $check_query = "SELECT * FROM tbl_users WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result);
        if ($row['userName'] === $username) {
            $errors['username'] = "Username is already existed!";
        }
        if ($row['email'] === $email) {
            $errors['email'] = "Entered email is already existed!";
        }
    } else {
        // If no errors, proceed with insertion
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $insert_data = "INSERT INTO tbl_users (`username`, `user_password`, `firstName`, `lastName`, `email`, `role`)
                        VALUES ('$username','$encpass','$firstName','$lastName', '$email','$role')";
        $query = mysqli_query($conn, $insert_data);
        if($query){
            echo "<script>alert('Registration Successful!')</script>";
            echo "<script>window.location.href = 'login.php'</script>";
            exit();
        } else {
            echo "<script>alert('Registration Failed!')</script>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <title>KAIJU CAFE | REGISTER</title>
    <link rel = "icon" href ="assets/img/kaijulogo.jpg" type = "image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<main id="main" class=" bg-dark">
    <div id="login-left">
        <div class="logo">
            <img src="assets/img/kaijulogo.jpg" alt="">
        </div>
    </div>
    <div id="login-right">
        <div class="card col-md-8">
            <div class="card-body">
                <form method="POST">
                    <center><h4>REGISTER</h4></center>
                    <center><label class="control-label"><b>ADMINISTRATOR</b></label></center><br>
                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="form-group" style="display:flex;">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" onkeypress="if(event.keyCode==32)event.returnValue=false;">
                        <button type="button" id="show" onclick="showpassword();"><i id="for-show" class="fas fa-eye"></i></button>
                        <button type="button" id="hide" onclick="hidepassword();" hidden><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                    <div>
                        <p class="text-dark">Already have account? <a href="login.php" class="fw-700" style="color:#770c23;font-weight:700;">Login here</a></p>
                    </div>
                    <center><button id="btnSubmit" name="signup" type="submit" class="btn-sm btn-block btn-wave col-md-4" style="background-color:#770c23;color:whitesmoke;font-size:19px;">Register</button></center>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>

<script type = "text/javascript">
   (function(){
    document.querySelector("#btnSubmit").style.opacity = "0.4";
    $('form > div > input').keyup(function(){
        var empty = false;
        document.querySelector("#btnSubmit").style.opacity = "1";
        $('form > div > input').each(function(){
            if($(this).val()== ''){
                empty = true;
                document.querySelector("#btnSubmit").style.opacity = "0.4";
            }
        });
        if(empty){
            $('#btnSubmit').attr ('disabled','disabled');  
        }
        else{
            $('#btnSubmit').removeAttr ('disabled');  
        }
    });

    var h = document.getElementById("password");
    document.getElementById("show").setAttribute("hidden","hidden");
        $('#password').keyup(function(){
    if (h.type === "password") {
     
       
        var empty = false;
        document.getElementById("show").removeAttribute("hidden");
        $('#password').each(function(){
            if($(this).val()== ''){
                empty = true;
                document.getElementById("show").setAttribute("hidden","hidden");
            }
        });
        if(empty){
            document.getElementById("show").setAttribute("hidden","hidden");
        }
        else{
            document.getElementById("show").removeAttribute("hidden");
        }
    } 
    else{
        var empty = false;
        document.getElementById("hide").removeAttribute("hidden");
        $('#password').each(function(){
            if($(this).val()== ''){
                empty = true;
                document.getElementById("hide").setAttribute("hidden","hidden");
            }
        });
        if(empty){
            document.getElementById("hide").setAttribute("hidden","hidden");
        }
        else{
            document.getElementById("hide").removeAttribute("hidden");
        }
    }
});
})()
</script>

<script>
    function showpassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
        
    } else {
        x.type = "password";
    }
    document.getElementById("show").setAttribute("hidden","hidden");
    document.getElementById("hide").removeAttribute("hidden");
    }
    function hidepassword() {
    var y = document.getElementById("password");
    if (y.type === "password") {
        y.type = "text";
    } else {
        y.type = "password";
    }
    document.getElementById("show").removeAttribute("hidden");
    document.getElementById("hide").setAttribute("hidden","hidden");
    }
</script>
</body>
</html>
