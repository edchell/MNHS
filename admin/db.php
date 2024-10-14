<?php
error_reporting(E_ALL ^ E_NOTICE);

// Initialize the page variable
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; // Default to 'dashboard'

// Define allowed pages
$pages = array('dashboard', 'users', 'student_list', 'student_profile', 'subject_list', 'academic_record', 'academic_view');

// Check if the requested page is in the allowed list
if (in_array($page, $pages)) {
    // Include the requested page
    include($page . '.php');
} else {
    // Page not found, show an error message
    echo 'Page not found. Return to 
    <a href="db.php?page=dashboard">dashboard</a>';
}
?>
