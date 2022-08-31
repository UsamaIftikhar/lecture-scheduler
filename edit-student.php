<?php
include_once('./database/config.php');
?>
<?php
try {
    if (isset($_COOKIE['editStudent'])) {
        $rollno = $_COOKIE['editStudent'];
        $fetchUser = $connection->prepare("Select * from user where rollno='" . $rollno . "'");
        $fetchUser->execute();
        $userValues = $fetchUser->fetch();
    }
} catch (\Throwable $th) {
    throw $th;
}
?>
<?PHP
try {
    if (isset($_POST['submit'])) {
        $update = $connection->prepare("UPDATE user SET fname='" . $_POST['fname'] . "', lname='" . $_POST['lname'] . "', phoneno='" . $_POST['phoneno'] . "', email='" . $userValues['email'] . "', semester='" . $_POST['semester'] . "', password='" . crypt($_POST['password'], '$6$rounds=5000$anexamplestringforsalt$') . "' WHERE rollno='$rollno'");
        $update->execute();
        setcookie('toast', 'success', time() + 2);
        header("Refresh:0");
    }
} catch (\Throwable $th) {
    setcookie('toast', 'error');
    throw $th;
}
?>
<?PHP
$semesterData = ['semester 1', 'semester 2', 'semester 3', 'semester 4', 'semester 5', 'semester 6', 'semester 7', 'semester 8',];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin-Students</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Build whatever layout you need with our Architect framework.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php
        opcache_reset();
        require_once('./admin-topheader.php');
        ?>

        <div class="app-main">
            <?php
            $currentPage = basename($_SERVER['REQUEST_URI']);
            require_once('./admin-sidebar.php');
            Sidebar($currentPage);
            ?>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-graph text-success">
                                    </i>
                                </div>
                                <div>Edit Student
                                    <div class="page-title-subheading">Edit the details below
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="pb-4 d-flex justify-content-between">
                        <h6 style="padding-top: 10px;">You can edit the following details</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-4 card" style="padding-bottom:10px;">
                                <div class="card-header">Student Details
                                    <div class="btn-actions-pane-right">
                                        <div role="group" class="btn-group-sm btn-group">
                                        </div>
                                    </div>
                                </div>
                                <div style="padding: 30px">
                                    <?PHP
                                    try {
                                        if (isset($_COOKIE['toast'])) {
                                            $toast = $_COOKIE['toast'];
                                            if ($toast == 'success') {
                                    ?>
                                                <div class="alert alert-success fade show" role="alert">Record Updated Successfully</div>
                                            <?PHP
                                            }
                                            if ($toast == 'error') {
                                            ?>
                                                <div class="alert alert-danger fade show" role="alert">There were an error while submitting the form. Kindly try again</div>
                                    <?PHP
                                            }
                                        }
                                    } catch (\Throwable $th) {
                                        throw $th;
                                    }
                                    ?>
                                    <form class="needs-validation" novalidate action="edit-student.php" method="POST">
                                        <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">First Name</label>
                                            <div class="col-sm-10"><input name="fname" id="fname" value="<?PHP echo $userValues['fname'] ?>" type="text" class="form-control"></div>
                                        </div>
                                        <div class="position-relative row form-group"><label for="examplePassword" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10"><input name="lname" id="lname" placeholder="password placeholder" value="<?PHP echo $userValues['lname'] ?>" type="text" class="form-control"></div>
                                        </div>
                                        <div class="position-relative row form-group"><label for="examplePassword" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10"><input name="email" id="email" disabled placeholder="password placeholder" value="<?PHP echo $userValues['email'] ?>" type="text" class="form-control"></div>
                                        </div>
                                        <div class="position-relative row form-group"><label for="examplePassword" class="col-sm-2 col-form-label">Roll No</label>
                                            <div class="col-sm-10"><input name="phoneno" id="phoneno" disabled placeholder="Phone Number" value="<?PHP echo $userValues['rollno'] ?>" type="text" class="form-control"></div>
                                        </div>
                                        <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Semester</label>
                                            <div class="col-sm-10">
                                                <select name="semester" id="semester" class="form-control form-select form-select-sm" required>
                                                    <option selected disabled>Select</option>
                                                    <?PHP
                                                    foreach ($semesterData as $row) {
                                                        if ($row == $userValues['semester']) {
                                                            echo ('<option selected="selected" value=' . "'$row'" . '>' . $row . '</option>');
                                                        } else {
                                                            echo ('<option value=' . "'$row'" . '>' . $row . '</option>');
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="position-relative row form-group"><label for="validationTooltip02" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10"><input name="password" id="validationTooltip02" required autocomplete="nope" placeholder="Add new password and save" type="text" class="form-control"></div>
                                        </div>
                                        <div class="position-relative row form-check">
                                            <div class="d-flex justify-content-end" style="margin-right: 14px;">
                                                <button id="submit" type="submit" name="submit" class="btn btn-secondary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</body>
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
<script type="text/javascript" src="./assets/scripts/main.js"></script>
<html>