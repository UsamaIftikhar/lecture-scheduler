<?PHP
session_start();
$userData = $_SESSION['userData'];
$department = $userData['department'];
$mysqli=new mysqli('localhost','root','root','lecture_scheduler' ) or die(mysql_error($mysqli));

// totaldepartments
$countquery = $mysqli->query("SELECT COUNT(3) FROM departments")or die($mysqli->error);
$countedrow=$countquery->Fetch_array();
$totaldepartments = $countedrow[0];

//totalcourses
$countquery = $mysqli->query("SELECT COUNT(3) FROM courses")or die($mysqli->error);
$countedrow=$countquery->Fetch_array();
$totalCourses = $countedrow[0];

//totalstudents
$countquery = $mysqli->query("SELECT COUNT(3) FROM user where type = 'student'")or die($mysqli->error);
$countedrow=$countquery->Fetch_array();
$totalStudents = $countedrow[0];

//student courses
//totalcourses
$countquery = $mysqli->query("SELECT COUNT(3) FROM courses where department='" . $department . "'")or die($mysqli->error);
$countedrow=$countquery->Fetch_array();
$studentCourses = $countedrow[0];
?>