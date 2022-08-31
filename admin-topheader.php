<?php
session_start();
$userData = $_SESSION['userData'];
if (!$userData) {
    header("location:sign-in.php");
} else  if ($userData['type'] != 'admin') {
    header("location:sign-in.php");
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
</head>

<body>
    <div class="app-header header-shadow">
        <div class="app-header__logo">
            <div>Lecture Scheduler</div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
            <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>
        <div class="app-header__content">
            <div class="app-header-left">

                <ul class="header-menu nav pl-2">
                    <li class="nav-item">
                        <a href="./admin-dashboard.php" class="nav-link">
                            <i class="nav-link-icon fa fa-database"> </i>
                            Dashboard
                        </a>
                    </li>

                    <li class="dropdown nav-item">
                        <a href="./admin-profile-setting.php" class="nav-link">
                            <i class="nav-link-icon fa fa-cog"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
            <div class="app-header-right">
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                        <img width="42" height="42" class="rounded-circle" src="<?PHP
                                                                                                if ($userData['image']) {
                                                                                                    echo $userData['image'];
                                                                                                } else {
                                                                                                ?> assets/images/avatars/profile-pic.jpg <?PHP } ?>" alt="">
                                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                    </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item"><a href="./admin-dashboard.php">User Account</a></div>
                                        <div class="dropdown-item"><a href="./admin-profile-setting.php">Settings</a></div>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <div class="dropdown-item"><a href="./logout.php">Logout</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-left  ml-3 header-user-info pr-5">
                                <div class="widget-heading">
                                    <?PHP echo ucfirst($userData['fname']);
                                    echo ' ';
                                    echo ucfirst($userData['lname']); ?>
                                </div>
                                <div class="widget-subheading">
                                    <?PHP echo ucfirst($userData['type']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<html>