<?php
function Sidebar($currentPage)
{
?>
    <div class="app-sidebar sidebar-shadow">
        <div class="app-header__logo">
            <div class="logo-src"></div>
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
        <?php
        ?>
        <div class="scrollbar-sidebar">
            <div class="app-sidebar__inner">
                <ul class="vertical-nav-menu">
                    <li class="app-sidebar__heading">Quick Links</li>
                    <li>
                        <a href=<?php
                                if ($currentPage === 'student-dashboard.php') {
                                ?> "student-dashboard.php" <?php
                                    } else if ($currentPage === 'teacher-dashboard.php') {
                                        ?> "teacher-dashboard.php" <?php
                                    } else if ($currentPage === 'student-profile-setting.php') {
                                        ?> "student-dashboard.php" <?php
                                        } else if ($currentPage === 'teacher-profile-setting.php') {
                                            ?> "teacher-dashboard.php" <?php
                                        } else if ($currentPage === 'teacher-lecture-step1.php') {
                                            ?> "teacher-dashboard.php" <?php
                                        } else if ($currentPage === 'teacher-lecture.php') {
                                            ?> "teacher-dashboard.php" <?php
                                        } else if ($currentPage === 'edit-lecture.php') {
                                            ?> "teacher-dashboard.php" <?php
                                        }
                                        if (($currentPage === 'student-dashboard.php') || ($currentPage === 'teacher-dashboard.php')) {
                                        ?> class="mm-active" <?php
                                        } ?>>
                            <i class="metismenu-icon pe-7s-rocket"></i>
                            Dashboard
                        </a>

                    </li>
                    <li class="app-sidebar__heading">Settings</li>
                    <li>
                        <a href=<?php
                                if ($currentPage === 'student-profile-setting.php') {
                                ?> "student-profile-setting.php" <?php
                                    } else if ($currentPage === 'teacher-profile-setting.php') {
                                        ?> "teacher-profile-setting.php" <?php
                                        } else if ($currentPage === 'teacher-dashboard.php') {
                                            ?> "teacher-profile-setting.php" <?php
                                        } else if ($currentPage === 'student-dashboard.php') {
                                            ?> "student-profile-setting.php" <?php
                                        } else if ($currentPage === 'teacher-lecture-step1.php') {
                                            ?> "teacher-profile-setting.php" <?php
                                        } else if ($currentPage === 'teacher-lecture.php') {
                                            ?> "teacher-profile-setting.php" <?php
                                        } else if ($currentPage === 'edit-lecture.php') {
                                            ?> "teacher-profile-setting.php" <?php
                                        }

                                        if (($currentPage === 'student-profile-setting.php') || ($currentPage === 'teacher-profile-setting.php')) {
                                            ?> class="mm-active" <?php
                                        } ?>>
                            <i class="metismenu-icon pe-7s-rocket"></i>
                            Profile Settings
                        </a>
                    </li>

                    <li>
                        <a href="./logout.php">
                            <i class="metismenu-icon pe-7s-graph2">
                            </i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php
}
?>