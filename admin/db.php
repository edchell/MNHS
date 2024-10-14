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

?>