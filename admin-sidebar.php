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
        $page = basename($_SERVER['REQUEST_URI']);
        ?>
        <div class="scrollbar-sidebar">
            <div class="app-sidebar__inner">
                <ul class="vertical-nav-menu">
                    <li class="app-sidebar__heading">Quick Links</li>
                    <li>
                        <a href="admin-dashboard.php" <?php if ($currentPage === 'admin-dashboard.php') { ?> class="mm-active" <?php } ?>>

                            <i class="metismenu-icon pe-7s-rocket"></i>
                            Dashboard
                        </a>

                    </li>
                    <li>
                        <a href="department.php" <?php if ($currentPage === 'department.php') { ?> class="mm-active" <?php } ?>>
                            <i class="metismenu-icon pe-7s-note2"></i>
                            Departments
                        </a>

                    </li>
                    <li>
                        <a href="course.php" <?php if ($currentPage === 'course.php') { ?> class="mm-active" <?php } ?>>
                            <i class="metismenu-icon pe-7s-notebook"></i>
                            Courses
                        </a>

                    </li>
                    <li>
                        <a href="lecture.php" <?php if ($currentPage === 'lecture.php') { ?> class="mm-active" <?php } ?>>
                            <i class="metismenu-icon pe-7s-display2"></i>
                            Lectures
                        </a>
                    </li>
                    <li>
                        <a href="students.php" <?php if ($currentPage === 'students.php') { ?> class="mm-active" <?php } ?>>
                            <i class="metismenu-icon pe-7s-user"></i>
                            Students
                        </a>
                    </li>
                    <li>
                        <a href="teachers.php" <?php if ($currentPage === 'teachers.php') { ?> class="mm-active" <?php } ?>>
                            <i class="metismenu-icon pe-7s-users"></i>
                            Teachers
                        </a>
                    </li>
                    <li class="app-sidebar__heading">Settings</li>
                    <li>
                        <a href="admin-profile-setting.php" <?php if ($currentPage === 'admin-profile-setting.php') { ?> class="mm-active" <?php } ?>>
                            <i class="metismenu-icon pe-7s-config"></i>
                            Profile Settings
                        </a>
                    </li>
                    <li>
                        <a href="./logout.php">
                            <i class="metismenu-icon pe-7s-left-arrow">
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