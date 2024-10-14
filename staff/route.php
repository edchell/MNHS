<?php
error_reporting(E_ALL ^ E_NOTICE);

$page = $_GET['page'];
$pages = array('dashboard');
if (!empty($page)) {
    if(in_array($page,$pages)) {
        $page .= '.php';
        include($page);
    }
    else {
        echo 'Page not found. Return
        <a href="route.php?page=dashboard">dashboard</a>';
    }
}

?>