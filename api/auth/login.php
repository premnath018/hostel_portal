<?php
session_start();
header("Access-Control-Allow-Origin: *");
include '../db/connection.php';
include './glogin.php';
use Google\Service\Oauth2;
// authenticate code from Google OAuth Flow
$email = "";
var_dump($_GET['code']);
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  // get profile info
  $google_oauth = new Google\Service\Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $GLOBALS['email'] =  $google_account_info->email;
  $name =  $google_account_info->name;
  
}
$checkSql = "SELECT * FROM login_users WHERE email_id = '$email'";
$checkResult = mysqli_query($db, $checkSql);
$response = array('success' => true, 'message' => 'hello');
  if ($checkResult->num_rows > 0) {
      $row = $checkResult->fetch_assoc();
        header("Location: ../../pages/dashboard/index.php");
        exit();
  }
     else {
    header("Location: ../../pages/samples/login.php?error=Invalid User");
    exit();
}

echo json_encode($response);


// var_dump($row);
// $_SESSION['username'] = $row['name'];
// $_SESSION['userId'] = $row['roll_no'];
// $_SESSION['email'] = $row['email_id'];
// $_SESSION['auth-state']='auth';
// $_SESSION['userRole'] = $row['fid'];
// if ($row['status'] == 1)
// $_SESSION['userRole'] = "Faculty";
// $_SESSION['resource'] = $row['f_id'];
// $_SESSION['auth-state']='auth';
// $_SESSION['username'] = "Rishvanth";
// $_SESSION['email'] = "admin@rish.com";
// $_SESSION['userId'] = "AD123";
// $_SESSION['userRole'] = "Super Admin";
