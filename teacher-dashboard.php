<?php
include_once('./database/config.php');
session_start();
$userData = $_SESSION['userData'];
?>
<?PHP
if (isset($_COOKIE['dep'])) {
    echo  $dep = $_COOKIE['dep'];
}
if (isset($_COOKIE['sem'])) {
    echo  $sem = $_COOKIE['sem'];
}
if (isset($_COOKIE['date'])) {
    echo  $selectedDate = $_COOKIE['date'];
}
if (isset($_COOKIE['course'])) {
    echo  $selectedCourse = $_COOKIE['course'];
}
if (isset($_COOKIE['teacher'])) {
    echo  $selectedTeacher = $_COOKIE['teacher'];
}
?>
<?php
try {
    $fetchTeachers = $connection->prepare("Select * from user where department='" . $dep . "' and type ='teacher'");
    $fetchTeachers->execute();
    $teachersData = $fetchTeachers->fetchall();
} catch (\Throwable $th) {
    throw $th;
}
?>
<?PHP
try {
    $fetchCourse = $connection->prepare("Select * from courses where department='" . $dep . "' and semester='" . $sem . "'");
    $fetchCourse->execute();
    $courseData = $fetchCourse->fetchall();
    // echo '<pre>'; print_r($courseData); echo '</pre>';
} catch (\Throwable $th) {
    throw $th;
}
?>
<?PHP
try {
    $fetchDepartments = $connection->prepare("Select * from departments");
    $fetchDepartments->execute();
    $departmentData = $fetchDepartments->fetchall();
    // echo '<pre>'; print_r($departmentData); echo '</pre>';
} catch (\Throwable $th) {
    throw $th;
}
?>
<?php
try {
    if (isset($_POST['search'])) {
        foreach ($_POST['departmentValue'] as $select) {
            $course = $select;
        }

        $date = $_POST['date'];
        $course = $_POST['course'];
        $teacher = $_POST['teacher'];
        $query = "SELECT * FROM lectures";
        $conditions = array();
        // echo $teacher;
        if (!empty($course)) {
            $conditions[] = "course='$course'";
        }
        if (!empty($date)) {
            $conditions[] = "date='$date'";
        }
        if (!empty($teacher)) {
            $conditions[] = "teacher='$teacher'";
        }
        $conditions[] = "semester='$sem'";
        $conditions[] = "department='$dep'";
        // $conditions[] = "date='$date'";
        $sql = $query;
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }


        $fetchLecture = $connection->prepare($sql);
        $fetchLecture->execute();
        $lectureData = $fetchLecture->fetchall();
    }
} catch (\Throwable $th) {
    // echo $th;
    throw $th;
}
?>
<?php
try {
    if (isset($_POST['reset'])) {
        echo "Reset called";
    }
} catch (\Throwable $th) {
    echo $th;
    throw $th;
}
?>
<?php
try {
    if (isset($_POST['submit'])) {
        if (isset($_COOKIE['deleteLecture'])) {
            $lectureId = $_COOKIE['deleteLecture'];
            if ($lectureId) {
                $deleteLecture = $connection->prepare("DELETE FROM lectures WHERE id=$lectureId");
                $deleteLecture->execute();
                // header("Refresh:0");
            }
        }
    }
} catch (\Throwable $th) {
    // echo $th;
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
    <title>Teacher-Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
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
                                    <i class="pe-7s-car icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <div>Hi Professor, <?PHP echo ucfirst($userData['fname'])  ?>
                                    <div class="page-title-subheading">This is the Teacher's panel dashboard you can view and manage anything from here.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="row col-lg-6">
                            <div class="form-group col-lg-6" style="padding-left: 0px;">
                                <label for="input_from">Select Department</label>
                                <form class="needs-validation" novalidate action="teacher-dashboard.php" method="POST">
                                    <select name="department" id="department" class="form-control form-select form-select-sm" onchange="update()">
                                        <option selected disabled>Select</option>
                                        <?PHP
                                        foreach ($departmentData as $row) {
                                            $dname = $row['dname'];
                                            echo $dname;
                                            if ($dname == $dep) {
                                                echo ('<option selected="selected" value=' . "'$dname'" . '>' . $dname . '</option>');
                                            } else {
                                                echo ('<option value=' . "'$dname'" . '>' . $dname . '</option>');
                                            }
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                        <div class="row col-lg-6">
                            <div class="form-group col-lg-6" style="padding-left: 0px;">
                                <label for="input_from">Select Semester</label>
                                <select name="semester" id="semester" class="form-control form-select form-select-sm" required onchange="update()">
                                    <option selected disabled>Select</option>
                                    <?PHP
                                    foreach ($semesterData as $row) {
                                        if ($row == $sem) {
                                            echo ('<option selected="selected" value=' . "'$row'" . '>' . $row . '</option>');
                                        } else {
                                            echo ('<option value=' . "'$row'" . '>' . $row . '</option>');
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex">
                    <div class="row col-lg-6">
                        <div class="form-group col-lg-6" style="padding-left: 0px;">
                            <label for="input_from">Select Course (Optional)</label>
                            <form class="needs-validation" novalidate action="teacher-dashboard.php" method="POST">
                                <select name="course" id="course" class="form-control form-select form-select-sm" onchange="courseUpdate()">
                                    <option selected disabled>Select</option>
                                    <?PHP
                                    foreach ($courseData as $row) {
                                        $dname = $row['course_name'];
                                        echo $dname;
                                        if ($dname == $selectedCourse) {
                                            echo ('<option selected="selected" value=' . "'$dname'" . '>' . $dname . '</option>');
                                        } else {
                                            echo ('<option value=' . "'$dname'" . '>' . $dname . '</option>');
                                        }
                                    }
                                    ?>
                                </select>

                        </div>
                    </div>
                    <div class="row col-lg-6">
                        <div class="form-group col-lg-6" style="padding-left: 0px;">
                            <label for="input_from">Select Teacher (Optional)</label>
                            <select name="teacher" id="teacher" class="form-control form-select form-select-sm" onchange="teacherUpdate()">
                                <option selected disabled>Select</option>
                                <?PHP
                                
                                foreach ($teachersData as $row) {
                                    $fname = $row['fname'];
                                    $lname = $row['lname'];
                                    $teacherName = $fname.' '.$lname;
                                ?>
                                
                                    <!-- <option value=<?PHP echo "'$fname $lname'" ?>><?PHP echo $fname . ' ' . $lname ?></option> -->
                                <?PHP
                                 if ($teacherName == $selectedTeacher) {
                                    echo ('<option selected="selected" value=' .$selectedTeacher. '>'  .$selectedTeacher. '</option>');
                                } else {
                                    echo ('<option value=' ."'$teacherName'". '>' . $teacherName . '</option>');
                                    // echo ('<option value=' ."'$fname $lname'". '>' . $fname . ' ' . $lname . '</option>');
                                }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="input_from">Select Date (Optional)</label>
                        <input type="date" id="date" name="date" class="form-control" id="date" value="<?PHP echo $selectedDate ?>" onchange="dateUpdate()">
                    </div>
                    <div class="d-flex flex-row-reverse mb-3">
                        <button class="btn btn-primary" type="search" id="search" name="search">Search</button>
                        <button class="btn btn-secondary mr-2" type="reset" id="reset" name="reset" onclick="clearFilters()">Reset</button>
                    </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-header">Lectures according to applied Filters
                                    <div class="btn-actions-pane-right">
                                        <div role="group" class="btn-group-sm btn-group">
                                            <button onclick="location.href='teacher-lecture.php'" class="mr-2 btn-icon btn-icon-only btn btn-outline-primary ">
                                                <i class="fa fa-fw" aria-hidden="true" title="Copy to use plus"></i>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-left pl-4">Id</th>
                                                <th>Course</th>
                                                <th class="text-center">Lecture Number</th>
                                                <th class="text-center">Room No</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Time</th>
                                                <th class="text-center">Teacher</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?PHP
                                            foreach ($lectureData as $row) {
                                                $number = $row['number'];
                                                $department = $row['department'];
                                                $date = $row['date'];
                                                $course = $row['course'];
                                                $id = $row['id'];
                                            ?>
                                                <tr>
                                                    <td class="text-left pl-4 text-muted"># <?PHP echo $id ?></td>
                                                    <td>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">

                                                                <div class="widget-content-left flex2">
                                                                    <div class="widget-heading"><?PHP echo $course ?></div>

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
                                                            <?PHP echo  $row['date'] ?>
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
                                noResult($lectureData);
                                ?>
                                <div class="d-block d-flex justify-content-end card-footer">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            <div class="app-footer-left">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="javascript:void(0);" class="nav-link">
                                            Footer Link 1
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void(0);" class="nav-link">
                                            Footer Link 2
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="app-footer-right">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="javascript:void(0);" class="nav-link">
                                            Footer Link 3
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void(0);" class="nav-link">
                                            <div class="badge badge-success mr-1 ml-0">
                                                <small>NEW</small>
                                            </div>
                                            Footer Link 4
                                        </a>
                                    </li>
                                </ul>
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
            <!-- <div>Are you sure to delete this student?</div> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="teacher-dashboard.php" method="POST">
                    <button type="submit" id="submit" name="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function editButton(e) {
        console.log("Edit button clicked", e);
        document.cookie = "editLecture = " + e;
        location.replace("/lecture-scheduler/edit-lecture.php");
    }

    function deleteButton(id) {
        console.log("Delete button clicked", id);
        document.cookie = "deleteLecture = " + id;
    }
</script>
<script type="text/javascript">
    function update() {
        console.log("Function called")
        var selectedDepartment = document.getElementById('department');
        var selectedSemester = document.getElementById('semester');
        var option = selectedDepartment.options[selectedDepartment.selectedIndex];
        var option1 = selectedSemester.options[selectedSemester.selectedIndex];

        console.log(option.value);
        document.cookie = "dep = " + option.value;
        document.cookie = "sem = " + option1.value;
        location.reload();
    }

    function dateUpdate() {
        var selectedDate = document.getElementById('date').value;
        document.cookie = "date = " + selectedDate;
    }

    function courseUpdate() {
        var selectedCourse = document.getElementById('course');
        var option = selectedCourse.options[selectedCourse.selectedIndex];

        document.cookie = "course = " + option.value;
    }

    function teacherUpdate() {
        var selectedTeacher = document.getElementById('teacher');
        var option = selectedTeacher.options[selectedTeacher.selectedIndex];

        document.cookie = "teacher = " + option.value;
    }
    function clearFilters() {
        document.cookie = "dep = " + '';
        document.cookie = "sem = " + '';
        document.cookie = "course = " + '';
        document.cookie = "date = " + '';
        document.cookie = "teacher = " + '';
        location.reload();
    }
</script>
<script type="text/javascript" src="./assets/scripts/main.js"></script>
<html>