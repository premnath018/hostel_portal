<?php
// include '../display_error.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function db()
{
    $ssl_ca = ' cacert-2023-01-10.pem';
    $db = mysqli_init();
    $db->ssl_set($ssl_ca, '', '', null, null);
    $host="";
    $username="";
    $password="";
    $database="hostel_portal";
    $port = 3306;
    try {
        $db->real_connect($host, $username, $password, $database, $port);
        
        if ($db) {
            return $db;
        } else {
            return null;
        }
    } catch (Exception $ex) {
        die($ex);
    }
}
$db = db();
