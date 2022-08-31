<?php
include_once('./database/config.php');
session_start();
$userData = $_SESSION['userData'];
?>
<?PHP
include_once('./reset-filters.php');
?>
<?PHP
try {
    if (isset($_POST['submit'])) {
        $update = $connection->prepare("UPDATE user SET fname='" . $_POST['fname'] . "', lname='" . $_POST['lname'] . "', phoneno='" . $_POST['phoneno'] . "', email='" . $userData['email'] . "', password='" . crypt($_POST['password'], '$6$rounds=5000$anexamplestringforsalt$') . "' WHERE email='" . $userData['email'] . "'");
        $update->execute();

        $fetchUser = $connection->prepare("Select * from user where email='" . $userData['email'] . "' and type='teacher' ");
        $fetchUser->execute();
        $data = $fetchUser->fetch();

        $_SESSION['userData'] = $data;
        setcookie('toast', 'success', time() + 2);

        header("Refresh:0");
?>

<?PHP

    }
} catch (\Throwable $th) {
    setcookie('toast', 'error');
    throw $th;
}
?>
<?php
if (isset($_POST['profile'])) {
    if (isset($_FILES['image'])) {
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size > 7097152) {
            $errors[] = 'File size must be less tha 5 MB';
        }

        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "images/" . $file_name);
            try {
                $update = $connection->prepare("UPDATE user SET image='" . "images/" . $file_name . "' WHERE email='" . $userData['email'] . "'");
                $update->execute();

                if ($update) {
                    $fetchUser = $connection->prepare("Select * from user WHERE email='" . $userData['email'] . "'");
                    $fetchUser->execute();
                    $data = $fetchUser->fetch();
                    $_SESSION['userData'] = $data;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            print_r($errors);
        }
    }
}

if (isset($_POST['remove-profile'])) {
    try {
        $update = $connection->prepare("UPDATE user SET image='' WHERE email='" . $userData['email'] . "'");
        $update->execute();

        if ($update) {
            $fetchUser = $connection->prepare("Select * from user WHERE email='" . $userData['email'] . "'");
            $fetchUser->execute();
            $data = $fetchUser->fetch();
            $_SESSION['userData'] = $data;
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Teacher-Profile Setting</title>
    <link href="assets1/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets1/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Build whatever layout you need with our Architect framework.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
    <link href="./new-style.css" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php
        opcache_reset();
        require_once('./teacher-topheader.php');
        ?>

        <div class="app-main">
            <?php
            $currentPage = basename($_SERVER['REQUEST_URI']);
            require_once('./student-sidebar.php');
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
                                <div>Profile Setting
                                    <div class="page-title-subheading">You can manage Your profile here.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Profile</h5>
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
                                    setcookie('toast', 'error');
                                    throw $th;
                                }
                                ?>
                                <div>
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-2 col-form-label fw-bold fs-6">Profile Picture</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/images/avatars/profile-pic.jpg')">
                                                <!--begin::Preview existing avatar-->
                                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?PHP
                                                                                                                                if ($userData['image']) {
                                                                                                                                    echo $userData['image'];
                                                                                                                                } else {
                                                                                                                                ?> assets/images/avatars/profile-pic.jpg <?PHP } ?>)"></div>
                                                <!--end::Preview existing avatar-->
                                                <!--begin::Label-->
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <!--begin::Inputs-->
                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        <input type="file" name="image" onchange="uploadPicture()" />
                                                        <input type="hidden" name="avatar_remove" />
                                                        <button hidden type="profile" name="profile" id="profile">Click Me</button>
                                                        <button hidden type="remove-profile" name="remove-profile" id="remove-profile">Click Me</button>
                                                    </form>
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Cancel-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Cancel-->
                                                <!--begin::Remove-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar" <?PHP if (!$userData['image']) { ?> hidden <?PHP } ?>>
                                                    <i class="bi bi-x fs-2" onclick="removePicture()"></i>
                                                </span>
                                                <!--end::Remove-->
                                            </div>
                                            <!--end::Image input-->
                                            <!--begin::Hint-->
                                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                            <!--end::Hint-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                </div>
                                <form class="needs-validation" novalidate action="teacher-profile-setting.php" method="POST">
                                    <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">First Name</label>
                                        <div class="col-sm-10"><input name="fname" id="fname" value="<?PHP echo $userData['fname'] ?>" type="text" class="form-control"></div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="examplePassword" class="col-sm-2 col-form-label">Last Name</label>
                                        <div class="col-sm-10"><input name="lname" id="lname" placeholder="password placeholder" value="<?PHP echo $userData['lname'] ?>" type="text" class="form-control"></div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="examplePassword" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10"><input disabled name="email" id="email" placeholder="password placeholder" value="<?PHP echo $userData['email'] ?>" type="text" class="form-control"></div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="examplePassword" class="col-sm-2 col-form-label">Phone number</label>
                                        <div class="col-sm-10"><input name="phoneno" id="phoneno" placeholder="Phone Number" value="<?PHP echo $userData['phoneno'] ?>" type="text" class="form-control"></div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="validationTooltip02" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10"><input name="password" id="validationTooltip02" required autocomplete="nope" placeholder="Add new password and save" type="text" class="form-control"></div>
                                    </div>


                                    <div class="position-relative row form-check mr-1">
                                        <div class="d-flex justify-content-end pointer">
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
<script>
    function uploadPicture() {
        console.log("upload button presses")
        var profileButton = document.getElementById('profile').click();
    }

    function removePicture() {
        console.log("Button pressed");
        var profileButton = document.getElementById('remove-profile').click();
    }
</script>
<script type="text/javascript" src="./assets/scripts/main.js"></script>
<script src="assets1/plugins/global/plugins.bundle.js"></script>
<script src="assets1/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="assets1/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="assets1/js/custom/account/settings/signin-methods.js"></script>
<script src="assets1/js/custom/account/settings/profile-details.js"></script>
<script src="assets1/js/custom/account/settings/deactivate-account.js"></script>
<script src="assets1/js/custom/widgets.js"></script>
<script src="assets1/js/custom/apps/chat/chat.js"></script>
<script src="assets1/js/custom/modals/upgrade-plan.js"></script>
<script src="assets1/js/custom/modals/create-campaign.js"></script>
<script src="assets1/js/custom/modals/create-app.js"></script>
<script src="assets1/js/custom/modals/offer-a-deal/type.js"></script>
<script src="assets1/js/custom/modals/offer-a-deal/details.js"></script>
<script src="assets1/js/custom/modals/offer-a-deal/finance.js"></script>
<script src="assets1/js/custom/modals/offer-a-deal/complete.js"></script>
<script src="assets1/js/custom/modals/offer-a-deal/main.js"></script>
<script src="assets1/js/custom/modals/two-factor-authentication.js"></script>
<script src="assets1/js/custom/modals/users-search.js"></script>
<html>