<?php
include_once('./database/config.php');
?>
<?PHP
try {
    $featchTeacher = $connection->prepare("Select * from user where type = 'teacher'");
    $featchTeacher->execute();
    $teacherData = $featchTeacher->fetchall();
} catch (\Throwable $th) {
    throw $th;
}
?>
<?php
try {
    if (isset($_POST['submit'])) {
        if (isset($_COOKIE['deleteTeacher'])) {
            $id = $_COOKIE['deleteTeacher'];
            if ($id) {
                $deleteUser = $connection->prepare("DELETE FROM user WHERE id=$id");
                $deleteUser->execute();
                header("Refresh:0");
            }
        }
    }
} catch (\Throwable $th) {
    throw $th;
}
?>
<?php
try {
    if (isset($_POST['search'])) {
        $name = $_POST['searchData'];
        $featchTeacher = $connection->prepare("Select * from user where type = 'teacher' and fname= '" . $name . "'");
        $featchTeacher->execute();
        $teacherData = $featchTeacher->fetchall();
    }
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
    <title>Admin-Students</title>
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
                                <div>Teachers
                                    <div class="page-title-subheading">You can manage all teachers from below.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- <form> -->
                    <div class="pb-4 d-flex justify-content-between">
                        <h6 style="padding-top: 10px;">Following Teachers has been registered</h6>

                        <div class="search-wrapper">
                            <form action="teachers.php" method="POST">
                                <div class="d-flex flex-row nput-holder">
                                    <input type="text" name="searchData" class="form-control" style="margin-right:10px ;" placeholder="Search by Name">
                                    <button type="search" id="search" name="search" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                            <button class="close"></button>
                        </div>

                    </div>
                    <!-- </form> -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-4 card" style="padding-bottom:10px;">
                                <div class="card-header">Students
                                    <div class="btn-actions-pane-right">
                                        <div role="group" class="btn-group-sm btn-group">

                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive pb-2">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-left pl-4">Id</th>
                                                <th>Name</th>
                                                <th class="text-center">Department</th>
                                                <th class="text-center">Actions</th>

                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?PHP
                                            foreach ($teacherData as $row) {
                                                $firstName = $row['fname'];
                                                $lastName = $row['lname'];
                                                $id = $row['id'];
                                                $department = $row['department'];
                                            ?>
                                                <tr id="tablerow">
                                                    <td class="text-left pl-4 text-muted" id="rollNo">#<?PHP echo $id ?></td>
                                                    <td>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">

                                                                <div class="widget-content-left flex2">
                                                                    <div class="widget-heading"><?PHP echo $firstName;
                                                                                                echo ' ';
                                                                                                echo $lastName ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="widget-content-right flex2">
                                                            <div class="text-center"><?PHP echo $department ?></div>
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
                                noResult($teacherData);
                                ?>

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
            <!-- <div>Are you sure to delete this student?</div> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="teachers.php" method="POST">
                    <button type="submit" id="submit" name="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function editButton(e) {
        document.cookie = "editTeacher = " + e;
        location.replace("/lecture-scheduler/edit-teacher.php");
    }

    function deleteButton(rollNo) {
        document.cookie = "deleteTeacher = " + rollNo;
    }
</script>
<script>
    var modal = document.getElementById('id01');

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<script type="text/javascript" src="./assets/scripts/main.js"></script>
<html>