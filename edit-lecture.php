<?php
include_once('./database/config.php');
session_start();
?>
<?PHP
if (isset($_COOKIE['editLecture'])) {
    $lectureId = $_COOKIE['editLecture'];
}
?>
<?PHP
$fetchLecture = $connection->prepare("Select * from lectures where id='" . $lectureId . "'");
$fetchLecture->execute();
$lectureData = $fetchLecture->fetch();
?>
<?PHP
try {
    if (isset($_POST['input'])) {
        $department = $_POST['department-value'];
        $fetchCourse = $connection->prepare("Select * from courses where department='" . $department . "'");
        $fetchCourse->execute();
        $courseData = $fetchCourse->fetchall();
    }
} catch (\Throwable $th) {
    throw $th;
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
<?PHP
$semesterData = ['semester 1', 'semester 2', 'semester 3', 'semester 4', 'semester 5', 'semester 6', 'semester 7', 'semester 8',];
?>
<?php
try {
    $fetchTeachers = $connection->prepare("Select * from user where department='" . $lectureData['department'] . "' and type ='teacher'");
    $fetchTeachers->execute();
    $teachersData = $fetchTeachers->fetchall();
} catch (\Throwable $th) {
    throw $th;
}
?>
<?PHP
try {
    if (isset($_POST['submit'])) {
        $update = $connection->prepare("UPDATE lectures SET number='" . $_POST['number'] . "', course='" . $_POST['course'] . "', description='" . $_POST['description'] . "', date='" . $_POST['date'] . "', startTime='" . $_POST['startTime'] . "', endTime='" . $_POST['endTime'] . "', semester='" . $_POST['semester'] . "', room='" . $_POST['room'] . "', teacher='" . $_POST['teacher'] . "' WHERE id='$lectureId'");
        $update->execute();
        setcookie('toast', 'success', time() + 2);
        header("Refresh:0");
    }
} catch (Exception $e) {
    setcookie('toast', 'error', time() + 2);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Teacher-Edit Lecture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Build whatever layout you need with our Architect framework.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
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
                                <div>Edit Lecture
                                    <div class="page-title-subheading">You can edit anything below.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Edit your lecture</h5>
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
                                <form class="needs-validation" novalidate action="edit-lecture.php" method="POST">
                                    <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">Lecture number</label>
                                        <div class="col-sm-10"><input name="number" id="number" type="text" class="form-control" value="<?PHP echo $lectureData['number'] ?>"></div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Course</label>
                                        <div class="col-sm-10"><input name="course" id="course" type="text" class="form-control" value="<?PHP echo $lectureData['course'] ?>"></div>

                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Semester</label>
                                        <div class="col-sm-10">
                                            <select name="semester" id="semester" class="form-control form-select form-select-sm" required>
                                                <option selected disabled>Select</option>
                                                <?PHP
                                                foreach ($semesterData as $row) {
                                                    if ($row == $lectureData['semester']) {
                                                        echo ('<option selected="selected" value=' . "'$row'" . '>' . $row . '</option>');
                                                    } else {
                                                        echo ('<option value=' . "'$row'" . '>' . $row . '</option>');
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleText" class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10"><textarea name="description" id="description" class="form-control" value=""><?PHP echo htmlspecialchars($lectureData['description']) ?></textarea></div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="input_from" class="col-sm-2 col-form-label">Select Date</label>
                                        <div class="col-sm-10"> <input name="date" type="date" class="form-control" id="date" value="<?PHP echo $lectureData['date'] ?>"></div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="input_from" class="col-sm-2 col-form-label">Start Time</label>
                                        <div class="col-sm-10"> <input name="startTime" type="time" class="form-control" value="<?PHP echo date("H:i", strtotime($lectureData['startTime'])); ?>" id="startTime"></div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="input_from" class="col-sm-2 col-form-label">End Time</label>
                                        <div class="col-sm-10"> <input name="endTime" type="time" class="form-control" value="<?PHP echo date("H:i", strtotime($lectureData['endTime'])); ?>" id="endTime"></div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleText" class="col-sm-2 col-form-label">Room No</label>
                                        <div class="col-sm-10"><input name="room" id="room" value="<?PHP echo $lectureData['room'] ?>" class="form-control"></input></div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Assign Teacher</label>
                                        <div class="col-sm-10">
                                            <select name="teacher" id="teacher" class="form-control form-select form-select-sm">
                                                <option selected disabled>Select</option>
                                                <?PHP
                                                foreach ($teachersData as $row) {
                                                    $fname = $row['fname'];
                                                    $lname = $row['lname'];
                                                    $teacherName = $fname . ' ' . $lname;
                                                    if ($teacherName == $lectureData['teacher']) {
                                                        echo ('<option selected="selected" value=' . "'$teacherName'" . '>' . $teacherName . '</option>');
                                                    } else {
                                                        echo ('<option value=' . "'$teacherName'" . '>' . $teacherName . '</option>');
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="position-relative row form-check">
                                        <div class="d-flex justify-content-end">
                                            <button id="submit" name="submit" type="submit" class="btn btn-secondary">save</button>
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
</body>
<script type="text/javascript" src="./assets/scripts/main.js"></script>

<html>