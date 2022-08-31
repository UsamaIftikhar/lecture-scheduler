<?php
include_once('./database/config.php');
if (isset($_COOKIE['lectureDate'])) {
    $date = $_COOKIE['lectureDate'];
}
?>
<?php
try {
    if (isset($_POST['search'])) {
        $date = $_POST['date'];
        setcookie('lectureDate', $date);
        $fetchLectures = $connection->prepare("Select * from lectures where date ='" . $date . "'");
        $fetchLectures->execute();
        $lecturesData = $fetchLectures->fetchall();
    }
} catch (\Throwable $th) {
    throw $th;
}
?>
<?php
try {
    if (isset($_POST['submit'])) {
        if (isset($_COOKIE['deleteLectureAdmin'])) {
            $lectureId = $_COOKIE['deleteLectureAdmin'];
            if ($lectureId) {
                $deleteLectureAdmin = $connection->prepare("DELETE FROM lectures WHERE id=$lectureId");
                $deleteLectureAdmin->execute();
                setcookie('deleted', 'success', time() + 2);
                header("Refresh:0");
            }
        }
    }
} catch (\Throwable $th) {
    setcookie('deleted', 'error', time() + 2);
    throw $th;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin-Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
</head>
<style>
    .tableWrapper {
        max-width: fit-content;
        width: 1080px;
    }

    .dtHorizontalExampleWrapper {
        max-width: 600px;
        margin: 0 auto;
    }

    #dtHorizontalExample th,
    td {
        white-space: nowrap;
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before {
        bottom: .5em;
    }
</style>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

        <?php
        opcache_reset();
        require_once('./admin-topheader.php');
        require_once('./database/count.php')
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
                                    <i class="pe-7s-car icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <div>Scheduler Dashboard
                                    <div class="page-title-subheading">This is the admin panel dashboard you can manage anything from here.
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
                                        <div class="widget-heading">Total Departments</div>
                                        <div class="widget-subheading">Registed Departments</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-success"><span><?PHP echo $totaldepartments; ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Total Courses</div>
                                        <div class="widget-subheading">Registered Courses</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-success"><span><?PHP echo $totalCourses ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Total Students</div>
                                        <div class="widget-subheading">Registered Students</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-warning"><span><?PHP echo $totalStudents ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <form action="admin-dashboard.php" method="POST">
                        <div class="form-group">
                            <label for="input_from">Select Date</label>
                            <input type="date" name="date" class="form-control" value="<?PHP echo $date ?>" id="date">
                        </div>
                        <div class="d-flex flex-row-reverse pb-3">
                            <button class="btn btn-success " type="search" name="search" id="search">Search</button>
                        </div>
                    </form>
                    <?PHP
                    try {
                        if (isset($_COOKIE['deleted'])) {
                            $toast = $_COOKIE['deleted'];
                            if ($toast == 'success') {
                    ?>
                                <div class="alert alert-danger fade show" role="alert">Record Deleted Successfully</div>
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-header">All Lectures of date <?PHP echo $date ?>
                                    <div class="btn-actions-pane-right">
                                        <div role="group" class="btn-group-sm btn-group">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive pb-2">
                                    <table id="dtHorizontalExample" class="align-middle mb-0 table table-striped table-borderless table-striped table-hover scroll" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-left pl-4">Course</th>
                                                <th>Department</th>
                                                <th>Semester</th>
                                                <th>Time</th>
                                                <th class="text-center">Room No</th>
                                                <th class="text-center">Lecture Number</th>
                                                <th class="text-center">Teacher</th>
                                                <th class="text-center">Actions</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?PHP
                                            foreach ($lecturesData as $row) {
                                                $course = $row['course'];
                                                $id = $row['id'];
                                                $lectureNo = $row['number'];
                                                $department = $row['department'];
                                                $semester = $row['semester'];
                                                $room = $row['room'];
                                                $startTime = $row['startTime'];
                                                $endTime = $row['endTime'];
                                                $teacher = $row['teacher'];
                                            ?>
                                                <tr id="tablerow">
                                                    <td class="text-left pl-4 text-muted" id="course">#<?PHP echo $course ?></td>
                                                    <td>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <?PHP echo $department ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <?PHP echo $semester ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <?PHP echo date("g:i a", strtotime($startTime));
                                                                echo " - ";
                                                                echo date("g:i a", strtotime($endTime)); ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-content-center d-flex justify-content-center">
                                                            <?PHP echo $room ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-content-center d-flex justify-content-center">
                                                            <?PHP echo $lectureNo ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-content-center d-flex justify-content-center">
                                                            <?PHP echo $teacher ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="mr-2 btn-icon btn-icon-only btn btn-outline-primary" data-toggle="modal" data-target=".editModel" id="editButton" onclick="editButton(<?PHP echo $id ?>)"><i class="pe-7s-pen btn-icon-wrapper"> </i></button>
                                                        <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"><i class="pe-7s-trash btn-icon-wrapper" data-toggle="modal" data-target=".deleteModel" onclick="deleteButton(<?PHP echo $id ?>)"> </i></button>
                                                    </td>
                                                </tr>
                                            <?PHP
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?PHP
                                include_once('./blank-result.php');
                                noResult($lecturesData);
                                ?>
                                <div class="d-block text-center card-footer">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
<div class="modal fade deleteModel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Are you sure to delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="admin-dashboard.php" style="margin-bottom: 0px;" method="POST">
                    <button type="submit" id="submit" name="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dtHorizontalExample').DataTable({
            "scrollX": true
        });
        $('.dataTables_length').addClass('bs-select');
    });

    function editButton(e) {
        document.cookie = "editLectureAdmin = " + e;
        location.replace("/lecture-scheduler/edit-lecture-admin.php");
    }

    function deleteButton(id) {
        document.cookie = "deleteLectureAdmin = " + id;
    }
</script>
<script type="text/javascript" src="./assets/scripts/main.js"></script>
<html>