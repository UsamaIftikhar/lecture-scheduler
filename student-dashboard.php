<?php
include_once('./database/config.php');
include_once('./database/count.php');
session_start();
$userData = $_SESSION['userData'];
?>
<?php
try {
    if (isset($_POST['search'])) {
        $date = $_POST['date'];
        $fetchLecture = $connection->prepare("Select * from lectures where date='" . $date . "' and department='" . $userData['department'] . "' and semester='" . $userData['semester'] . "'");
        $fetchLecture->execute();
        $lectureData = $fetchLecture->fetchall();
    }
} catch (\Throwable $th) {
    throw $th;
}
?>
<?PHP
$fetchCourse = $connection->prepare("Select count(3) from courses where department='" . $userData['department'] . "'");
$fetchCourse->execute();
$courseCount = $fetchCourse->fetch();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Student-Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

        <?php
        opcache_reset();
        require_once('./top-header.php');
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
                                    <i class="pe-7s-car icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <div>Hi, <?PHP echo ucfirst($userData['fname']) ?>
                                    <div class="page-title-subheading">This is the student panel dashboard you can view and manage anything from here.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Your Department</div>
                                        <div class="widget-subheading">You are currently enrolled in <?PHP echo $userData['department'] ?></div>
                                    </div>
                                    <div class="widget-content-right">
                                        <!-- <div class="widget-numbers text-success"><span>4</span></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Your Courses</div>
                                        <div class="widget-subheading">Your Registered Courses</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-success"><span><?PHP echo $studentCourses ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Your Semester</div>
                                        <div class="widget-subheading">You are currently enrolled in <?PHP echo $userData['semester'] ?></div>
                                    </div>
                                    <div class="widget-content-right">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="student-dashboard.php" method="POST">
                        <div class="form-group">
                            <label for="input_from">Select Date</label>
                            <input value="<?PHP echo $date ?>" type="date" name="date" class="form-control" id="date">
                        </div>
                        <div class="d-flex flex-row-reverse pb-3">
                            <button class="btn btn-success " type="search" id="search" name="search">Search</button>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-header">Lectures for <?PHP echo $date ?>
                                    <div class="btn-actions-pane-right">
                                        <div role="group" class="btn-group-sm btn-group">

                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover mb-2">
                                        <thead>
                                            <tr>
                                                <th class="text-left pl-4">Id</th>
                                                <th>Course</th>
                                                <th class="text-center">Lecture Number</th>
                                                <th class="text-center">Room No</th>
                                                <th class="text-center">Time</th>
                                                <th class="text-center">Teacher</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?PHP
                                            foreach ($lectureData as $row) {

                                            ?>
                                                <tr>
                                                    <td class="text-left pl-4 text-muted">#<?PHP echo $row['id'] ?></td>
                                                    <td>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">

                                                                <div class="widget-content-left flex2">
                                                                    <div class="widget-heading"><?PHP echo $row['course'] ?></div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div><?PHP echo $row['number'] ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-content-center d-flex justify-content-center">
                                                            <?PHP echo  $row['room'] ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-content-center d-flex justify-content-center">
                                                            <?PHP echo date("g:i a", strtotime($row['startTime']));
                                                            echo " - ";
                                                            echo date("g:i a", strtotime($row['endTime'])); ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-content-center d-flex justify-content-center">
                                                            <?PHP echo $row['teacher'] ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?PHP
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="./assets/scripts/main.js"></script>
<html>