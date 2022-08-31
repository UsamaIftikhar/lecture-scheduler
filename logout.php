<?php
     session_start();
     $type = $_SESSION['userData'];
     include_once('./reset-filters.php');
     session_unset(); 
     session_destroy();  
     session_commit();
     if($type['type'] == 'student' || $type['type'] == 'teacher') {
          header('Location:index.html');
     }
     else {
          header('Location:index.html');
     }
 ?>