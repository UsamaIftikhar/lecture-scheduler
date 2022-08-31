<?php
$db_name = "lecture_scheduler";
$db_user = "root";
$db_pass = "root";
try {
   $connection = new PDO('mysql:host=localhost;dbname=lecture_scheduler',$db_user,$db_pass);
   $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "There was an error connecting to the database";
    echo $e;
}

// $db = new PDO('mysql:host=localhost;dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>