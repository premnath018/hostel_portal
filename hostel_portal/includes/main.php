<?php
$_home = '/hostel_portal';
$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
if ($_SERVER['HTTP_HOST'] == "localhost") {
    $_path = $http . $_SERVER['HTTP_HOST'] . $_home;
} else {
    $_path = $http . $_SERVER['HTTP_HOST'] . '/hostel_portal';
}

function checkSession()
{
  session_name("HostelPortal");
  session_start();
    $path = $GLOBALS['_path'];
    if (!isset($_SESSION['auth-state'])) {
        header("Location: $path/auth/login.html");
        exit();
    }

}
function checkRole($allowedRolesStr, $userRole) {
    $path = $GLOBALS['_path'];
    $allowedRoles = array_map('intval', explode('-', $allowedRolesStr));
    if (in_array($userRole, $allowedRoles)) {
      // User has an allowed role, return true
      return true;
    } else {
      // User does not have an allowed role, redirect to error page
      http_response_code(404);
        header("Location: $path/pages/error-404.html");
      exit();
    }
  }
function navbar(){ require 'navbar.php'; }
function topbar(){ require 'topbar.php'; }
function tb_script(){ require 'tb_script.php'; }