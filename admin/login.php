<?php
include 'assets/database.php';
session_start();
// Login logic
if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM tbl_users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Verifying password hash
        if (password_verify($password, $row['user_password'])) {
            $userId = $row['user_ID'];
            session_start();
            $_SESSION['adminloggedin'] = true;
            $_SESSION['adminusername'] = $username;
            $_SESSION['adminuserId'] = $userId;

            header("Location: dashboard/index.php?loginsuccess=true");
            exit();
        }
    }
    echo "<script>alert('Wrong Username or Password');
    window.location=document.referrer;
    </script>";
    exit();
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
    <title>KAIJU CAFE | LOGIN</title>
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
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                    <center><h4>LOGIN</h4>
                    <label class="control-label"><b>ADMINISTRATOR</b></label></center><br>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group" style = "display:flex;">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" onkeypress="if(event.keyCode==32)event.returnValue=false;">
                        <button type = "button" id = "show" onclick = "showpassword();"><i id = "for-show" class = "fas fa-eye"></i></button>
                        <button type = "button" id = "hide" onclick = "hidepassword();"hidden><i class="fa-solid fa-eye-slash" ></i></button>
                    </div>
                    <div>
                        <p class="text-dark">Don't have an account yet? <a href = "register.php" style="color:#770c23;font-weight:700;">Register here</a></p>
                    </div>
                    <center><button id = "btnSubmit" name = "login" type="submit" class="btn-sm btn-block btn-wave col-md-4" style="background-color:#770c23;color:whitesmoke;font-size:19px;">Login</button></center>
                </form>
                </div>
            </div>
        </div>
    </main>  

    <?php
    if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="false"){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Warning!</strong> Invalid Credentials
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
            </div>';
    }
?>
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
