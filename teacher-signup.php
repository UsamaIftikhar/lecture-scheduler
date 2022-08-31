<?php
include_once('./database/config.php');
opcache_reset();
?>
<?php
try {
    if (isset($_POST['submit'])) {
        foreach ($_POST['departmentValue'] as $select) {
            $department = $select;
        }
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $phoneno = $_POST['phoneno'];

        $sql = "INSERT INTO user(fname,lname,email,password,type,department,phoneno) VALUES(:fname,:lname,:email,:password,:type,:department,:phoneno)";
        $insert = $connection->prepare($sql);

        $data = [
            ':fname' => $fname,
            ':lname' => $lname,
            ':email' => $email,
            ':password' => crypt($_POST['password'], '$6$rounds=5000$anexamplestringforsalt$'),
            ':type' => 'teacher',
            ':department' => $department,
            ':phoneno' => $phoneno
        ];

        $result = $insert->execute($data);
        if ($result) {
?>
            <div class="alert alert-success fade show" role="alert">Teacher Account Created Successfully. <a href="/lecture-scheduler/sign-in.php">Login Now</a></div>
        <?PHP
        } else {
        ?>
            <div class="alert alert-danger fade show" role="alert">There were an error while submitting the form. Kindly try again</div>
        <?PHP
        }
    }
} catch (Exception $e) {
    $emailCheck = 'email';
    if (strpos($e, $emailCheck) !== false) {
        ?>
        <div class="alert alert-danger fade show" role="alert">Email already used. Kindly try another.</div>
    <?PHP
    } else {
    ?>
        <div class="alert alert-danger fade show" role="alert">There were an error while submitting the form. Kindly try again</div>
<?PHP
    }
}

?>
<?php
try {
    $fetchDepartments = $connection->prepare("Select * from departments");
    $fetchDepartments->execute();
    $departmentsData = $fetchDepartments->fetchall();
} catch (\Throwable $th) {
    throw $th;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Lecture Scheduler Teacher - Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Inline validation is very easy to implement using the Architect Framework.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
    <link href="./assets/registration.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/slicknav.min.css" />

    <link rel="stylesheet" href="css/style.css" />
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
            <li><a style="color: #fc0255;" href="http://localhost:8888/lecture-scheduler/teacher-signup.php">Teacher Signup</a>
            <li><a href="http://localhost:8888/lecture-scheduler/sign-in.php">Login</a>
        </ul>
    </header>

    <section class="bg-image" style="background-image: url('./assets/images/background.png');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="d-flex justify-content-center heading">
                            <h2>Teacher Signup</h2>
                        </div>
                        <div class="card" style="border-radius: 15px; margin-top: 10px; margin-bottom: 150px;">
                            <div class="card-body p-5 ">
                                <h2 class="text-uppercase text-center">Create an account</h2>
                                <div class="text-gray-400 fw-bold fs-4 mb-5 d-flex justify-content-center">Already have
                                    an account?&nbsp
                                    <a href="/lecture-scheduler/sign-in.php" class="link-primary fw-bolder">Sign in here</a>
                                </div>
                                <form class="needs-validation" novalidate action="teacher-signup.php" method="POST">

                                    <div class="mb-3">
                                        <label for="validationTooltip02">First name</label>
                                        <input type="text" class="form-control" name="fname" placeholder="First name" required autocomplete="nope" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="validationTooltip02">Last name</label>
                                        <input type="text" class="form-control" name="lname" placeholder="Last name" required autocomplete="nope" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="validationTooltip02">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email" required autocomplete="nope" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="validationTooltip02">Phone No</label>
                                        <input type="text" class="form-control" name="phoneno" placeholder="Phone No" required autocomplete="nope" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="validationTooltip02">Department</label>
                                        <select name="departmentValue[]" id="department-value" class="form-control form-select form-select-sm" onblur="checkDepartment()">
                                            <option selected disabled>Select</option>
                                            <?PHP
                                            foreach ($departmentsData as $row) {
                                                $dname = $row['dname'];
                                                echo $dname;
                                            ?>
                                                <option value=<?PHP echo "'$dname'" ?>><?PHP echo $dname ?></option>
                                            <?PHP
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group" id="password11">
                                        <div class="mb-3">
                                            <label for="validationTooltip02">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="nope" id="pass1" required minlength="6" onkeyup="checkPass(); return false;" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div id="error-nwl"></div>
                                        <div class="form-group" id="password22">
                                            <label for="validationTooltip02">Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password" placeholder="Re-enter Password" required autocomplete="nope" id="pass2" required minlength="6" onkeyup="checkPass(); return false;" />

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" name="submit" id="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
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


                                    function checkPass() {
                                        var pass1 = document.getElementById('pass1');

                                        var pass2 = document.getElementById('pass2');
                                        var message = document.getElementById('error-nwl');

                                        if (pass1.value.length > 5) {
                                            message.innerHTML = ""
                                        } else {
                                            message.style.color = "#ff6666";
                                            message.innerHTML = " Password length should be more than 6 digits!"
                                            return;
                                        }

                                        if (pass1.value == pass2.value) {
                                            document.getElementById('submit').disabled = false;
                                            message.innerHTML = ""
                                        } else {
                                            document.getElementById('submit').disabled = true;

                                            message.style.color = "#ff6666";
                                            message.innerHTML = " These passwords don't match!"
                                        }
                                    }
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