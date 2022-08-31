<?php
include_once('./database/config.php');
?>
<?PHP
$department = $_GET['department-value'];
$semesterData = $_GET['semester'];
setcookie('semester', $semesterData);
$fetchCourse = $connection->prepare("Select * from courses where department='" . $department . "' and semester='" . $semesterData . "'");
$fetchCourse->execute();
$courseData = $fetchCourse->fetchall();
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
<?php
try {
    $fetchTeachers = $connection->prepare("Select * from user where department='" . $department . "' and type ='teacher'");
    $fetchTeachers->execute();
    $teachersData = $fetchTeachers->fetchall();
} catch (\Throwable $th) {
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
    <title>Teacher- Add Lecture</title>
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
            Sidebar(explode("?", $currentPage)[0]);
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
                                <div>Lectures
                                    <div class="page-title-subheading">You can manage all Lectures from below.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Create Lecture</h5>
                                <?PHP
                                try {
                                    if (isset($_COOKIE['semester'])) {
                                        $semester = $_COOKIE['semester'];
                                    }
                                    if (isset($_POST['submit'])) {
                                        $course = $_POST['course'];
                                        $number = $_POST['number'];
                                        $department = $_POST['department'];
                                        $description = $_POST['description'];
                                        $date = $_POST['date'];
                                        $startTime = $_POST['startTime'];
                                        $endTime = $_POST['endTime'];
                                        $room = $_POST['room'];
                                        $teacher = $_POST['teacher'];
                                        $sql = "INSERT INTO lectures(number, course, department, semester, teacher, description, date, startTime, endTime, room) VALUES(:number, :course, :department, :semester, :teacher, :description, :date, :startTime, :endTime, :room)";
                                        $insert = $connection->prepare($sql);
                                        $data = [
                                            ':number' => $number,
                                            ':course' => $course,
                                            ':department' => $department,
                                            ':semester' => $semester,
                                            ':teacher' => $teacher,
                                            ':description' => $description,
                                            ':date' => $date,
                                            ':startTime' => $startTime,
                                            ':endTime' => $endTime,
                                            ':room' => $room
                                        ];

                                        $result = $insert->execute($data);
                                        if ($result) {
                                            include_once('./reset-filters.php');
                                ?>
                                            <div class="alert alert-success fade show" role="alert">Record Saved Successfully</div>
                                        <?PHP

                                        } else {
                                        ?>
                                            <div class="alert alert-danger fade show" role="alert">There were an error while submitting the form. Kindly try again</div>

                                    <?PHP
                                        }
                                    }
                                } catch (Exception $e) {
                                    include_once('./reset-filters.php');
                                    ?>
                                    <div class="alert alert-danger fade show" role="alert">There were an error while submitting the form. Kindly try again</div>

                                <?PHP
                                }
                                ?>
                                <form class="needs-validation" novalidate action="teacher-lecture-step1.php" method="POST">
                                    <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">Lecture number</label>
                                        <div class="col-sm-10"><input name="number" id="number" placeholder="Lecture Number" type="text" class="form-control"></div>
                                    </div>

                                    <div class="col-sm-10"><input name="department" id="department" placeholder="Department" hidden value="<?PHP echo $department ?>" type="text" class="form-control"></div>

                                    <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Course</label>
                                        <div class="col-sm-10">
                                            <select name="course" id="course" class="form-control form-select form-select-sm">
                                                <option selected disabled>Select</option>
                                                <?PHP

                                                foreach ($courseData as $row) {
                                                    $cname = $row['course_name'];
                                                ?>
                                                    <option value=<?PHP echo "'$cname'" ?>><?PHP echo $cname ?></option>
                                                <?PHP
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleText" class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10"><textarea name="description" id="description" class="form-control"></textarea></div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="input_from" class="col-sm-2 col-form-label">Select Date</label>
                                        <div class="col-sm-10"> <input name="date" type="date" class="form-control" id="date"></div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="input_from" class="col-sm-2 col-form-label">Start Time</label>
                                        <div class="col-sm-10"> <input name="startTime" type="time" class="form-control" id="startTime"></div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="input_from" class="col-sm-2 col-form-label">End Time</label>
                                        <div class="col-sm-10"> <input name="endTime" type="time" class="form-control" id="endTime"></div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleText" class="col-sm-2 col-form-label">Room No</label>
                                        <div class="col-sm-10"><input name="room" id="room" class="form-control"></textarea></div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Assign Teacher</label>
                                        <div class="col-sm-10">
                                            <select name="teacher" id="teacher" class="form-control form-select form-select-sm">
                                                <option selected disabled>Select</option>
                                                <?PHP
                                                foreach ($teachersData as $row) {
                                                    $fname = $row['fname'];
                                                    $lname = $row['lname'];
                                                ?>
                                                    <option value=<?PHP echo "'$fname $lname'" ?>><?PHP echo $fname . ' ' . $lname ?></option>
                                                <?PHP
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="position-relative row form-check mr-1">
                                        <div class="d-flex justify-content-end pointer">
                                            <button id="submit" name="submit" type="submit" class="btn btn-secondary">Submit</button>
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