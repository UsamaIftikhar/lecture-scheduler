<?php
include_once('./database/config.php');
session_start();
?>
<?php
try {
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $pass = crypt($_POST['password'], '$6$rounds=5000$anexamplestringforsalt$');

        $fetchUser = $connection->prepare("Select *from user where email='$email' and password='$pass' and type='admin' ");
        $fetchUser->execute();
        $data = $fetchUser->fetch();

        if ($data['email'] != $email and $data['password'] != $pass) {
?>
            <div class="alert alert-danger fade show" role="alert">Email or password incorrect. Kindly try again</div>
    <?PHP
        } else {
            $_SESSION['userData'] = $data;
            header("location:admin-dashboard.php");
        }
    }
} catch (Exception $e) {
    ?>
    <div class="alert alert-danger fade show" role="alert">Something went wrong. Kindly try again</div>
<?PHP
}
?>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Lecture Scheduler -Admin Signin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Inline validation is very easy to implement using the Architect Framework.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/slicknav.min.css" />

    <link href="./main.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />

    <link href="./assets/registration.css" rel="stylesheet">

</head>
</head>

<body>
    <header class="header-section clearfix">
        <div class="site-logo">
            <h4 style="color:azure;">Lecture </h4>
            <h4 style="color:firebrick"> Scheduler</h4>
        </div>
        <div class="header-right">
            <a href="#work" class="hr-btn">Help</a>
            <span>|</span>
            <div class="user-panel">
                <a href="http://localhost:8888/lecture-scheduler/admin-signin.php" class="register">Admin Login</a>
            </div>
        </div>
        <ul class="main-menu">
            <li><a href="index.html">Home</a></li>
            <li><a href="http://localhost:8888/lecture-scheduler/student-signup.php">Student Signup</a></li>
            <li><a href="http://localhost:8888/lecture-scheduler/teacher-signup.php">Teacher Signup</a>
            <li><a href="http://localhost:8888/lecture-scheduler/sign-in.php">Login</a>
        </ul>
    </header>
    <section class="bg-image" style="background-image: url('./assets/images/background.png');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px; margin-top: 150px; margin-bottom: 150px;">
                            <div class="card-body p-5 ">
                                <h2 class="text-uppercase text-center">Admin Sign In to Scheduler</h2>
                                <form method="POST" class="needs-validation" novalidate action="/lecture-scheduler/admin-signin.php">
                                    <div class="mb-3">
                                        <label for="validationTooltip02">Email</label>
                                        <input type="email" name="email" class="form-control" id="validationTooltip02" placeholder="Email" required autocomplete="nope" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="validationTooltip02">Password</label>
                                        <input type="password" name="password" class="form-control" id="validationTooltip02" placeholder="Password" required autocomplete="nope" />
                                    </div>


                                    <div class="d-flex justify-content-center">
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body">Signin</button>
                                    </div>
                                </form>
                                <script>
                                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                                    (function() {
                                        'use strict';
                                        window.addEventListener('load', function() {
                                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                            var forms = document.getElementsByClassName('needs-validation');
                                            // Loop over them and prevent submission
                                            var validation = Array.prototype.filter.call(forms, function(form) {
                                                form.addEventListener('submit', function(event) {
                                                    if (form.checkValidity() === false) {
                                                        event.preventDefault();
                                                        event.stopPropagation();
                                                    }
                                                    form.classList.add('was-validated');
                                                }, false);
                                            });
                                        }, false);
                                    })();
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>