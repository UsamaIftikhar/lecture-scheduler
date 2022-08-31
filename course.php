<?php
include_once('./database/config.php');
?>
<?php
try {
    if (isset($_POST['submit'])) {
        $ccode = $_POST['courseCode'];
        $cname = $_POST['courseName'];
        $department = $_POST['department'];
        $semester = $_POST['semester'];
        $description = $_POST['description'];
        $sql = "INSERT INTO courses(course_code, course_name, department, semester, description) VALUES(:ccode, :cname, :department, :semester, :description)";
        $insert = $connection->prepare($sql);

        $data = [
            ':ccode' => $ccode,
            ':cname' => $cname,
            ':department' => $department,
            ':semester' => $semester,
            ':description' => $description
        ];

        $result = $insert->execute($data);
        if ($result) {
            setcookie('courseSaved', 'success', time() + 2);
            header("Refresh:0");
        } else {
            setcookie('courseSaved', 'error', time() + 2);
        }
    }
} catch (Exception $e) {
    throw $e;
    setcookie('courseSaved', 'error', time() + 2);
}
try {
    $fetchDepartments = $connection->prepare("Select * from departments");
    $fetchDepartments->execute();
    $departmentsData = $fetchDepartments->fetchall();
    $departmentname = $departmentsData['dname'];
} catch (\Throwable $th) {
    throw $th;
}
$semesterData = ['semester 1', 'semester 2', 'semester 3', 'semester 4', 'semester 5', 'semester 6', 'semester 7', 'semester 8',];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin-Courses</title>
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
                                <div>Courses
                                    <div class="page-title-subheading">You can manage all courses from below.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Create Course</h5>
                                <?PHP
                                try {
                                    if (isset($_COOKIE['courseSaved'])) {
                                        $toast = $_COOKIE['courseSaved'];
                                        if ($toast == 'success') {
                                ?>
                                            <div class="alert alert-success fade show" role="alert">Record saved Successfully</div>
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
                                <form class="needs-validation" novalidate action="course.php" method="POST">
                                    <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">Course Code</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="courseCode" placeholder="Course Code" required autocomplete="nope" />
                                        </div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="examplePassword" class="col-sm-2 col-form-label">Course Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="courseName" placeholder="Course Name" required autocomplete="nope" />
                                        </div>
                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Department</label>
                                        <div class="col-sm-10">
                                            <select name="department" id="department" class="form-control form-select form-select-sm" required>
                                                <option selected disabled>Select</option>
                                                <?PHP
                                                foreach ($departmentsData as $row) {
                                                    $dname = $row['dname'];
                                                ?>
                                                    <option value=<?PHP echo "'$dname'" ?>><?PHP echo $dname ?></option>
                                                <?PHP
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Semester</label>
                                        <div class="col-sm-10">
                                            <select name="semester" id="semester" class="form-control form-select form-select-sm" required>
                                                <option selected disabled>Select</option>
                                                <?PHP
                                                foreach ($semesterData as $row) {
                                                ?>
                                                    <option value=<?PHP echo "'$row'" ?>><?PHP echo $row ?></option>
                                                <?PHP
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="position-relative row form-group"><label for="exampleText" class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10">
                                            <textarea name="description" id="description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="position-relative row form-check">
                                        <div class="d-flex justify-content-end" style="margin-right: 14px;">
                                            <button type="submit" name="submit" id="submit" class="btn btn-secondary">Submit</button>
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
<script type="text/javascript" src="./assets/scripts/main.js"></script>
<html>