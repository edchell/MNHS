<?php
error_reporting(E_ALL ^ E_NOTICE);

$page = $_GET['page'];
$pages = array('dashboard', 'users', 'student_list', 'student_profile', 'subject_list', 'academic_record', 'academic_view');
if (!empty($page)) {
    if(in_array($page,$pages)) {
        $page .= '.php';
        include($page);
    }
    else {
        echo 'Page not found. Return
        <a href="db.php?page=dashboard">dashboard</a>';
    }
}
// Check if the user is not logged in
if (!isset($_SESSION['USER'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    include("404.php"); // Include your 404 page
    exit();
}
?>