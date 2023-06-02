<?php

$_home = '/hostel_portal';
$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
if ($_SERVER['HTTP_HOST'] == "localhost") {
    $_path = $http . $_SERVER['HTTP_HOST'] . $_home;
} else {
    $_path = $http . $_SERVER['HTTP_HOST'] . '/hostal_portal';
}

function checkSession()
{
    $path = $GLOBALS['_path'];
    session_start();

    if (!isset($_SESSION['auth-state'])) {
        session_name("HostelPortal");
        header("Location: $path/auth/login.html");
        exit();
    }

}

function navbar(){ require 'navbar.php'; }
function topbar(){ require 'topbar.php'; }
function tb_script(){ require 'tb_script.php'; }