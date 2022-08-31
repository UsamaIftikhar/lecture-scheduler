<?php
include_once('./database/config.php');
?>
<?PHP
try {
    if (isset($_POST['input'])) {
        $fetchCourse = $connection->prepare("Select * from courses where department='" . $department . "' and semester='" . $semester . "'");
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
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin-Lecture</title>
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
                                <h6>Select department first</h6>
                                <form class="needs-validation" novalidate action="lecture-step1.php?" method="GET">
                                    <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Department</label>
                                        <div class="col-sm-10">
                                            <select name="department-value" id="department-value" class="form-control form-select form-select-sm" onblur="checkDepartment()">
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
                                    <div class="d-flex flex-row-reverse">
                                        <button class="btn btn-primary" type="input" name="input" id="input">Next</button>
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

    <script type="text/javascript">
        function checkDepartment() {
            var res = document.getElementById("department").value;
        }
    </script>
</body>
<script type="text/javascript" src="./assets/scripts/main.js"></script>

<html>