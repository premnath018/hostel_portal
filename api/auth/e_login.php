<?php
session_start();
include '../db/connection.php';

// Process the login request
$email = $_POST['username'];
$password = $_POST['password'];

$checkSql = "SELECT * FROM master_users WHERE email_id = ?";
$stmt = mysqli_prepare($db, $checkSql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$checkResult = mysqli_stmt_get_result($stmt);
if ($stmt->error) {
    $res['success'] = false;
    $res['message'] = 'Error: ' . $stmt->error;
}
if ($checkResult->num_rows >0) {
    $row = $checkResult->fetch_assoc();
    $_SESSION['email']=$row['email_id'];
    $_SESSION['role']=$row['role'];
    $_SESSION['auth-state']='auth';
    if($_SESSION['role']==0){
        $InfoSql = "SELECT * FROM students_info WHERE email = ?";
        $stmt = mysqli_prepare($db, $InfoSql); mysqli_stmt_bind_param($stmt, "s", $email); mysqli_stmt_execute($stmt); $InfoResult = mysqli_stmt_get_result($stmt);
        $info = $InfoResult->fetch_assoc();
        $_SESSION['user_id']=$info['id'];
        $_SESSION['name']=$info['name'];
        $_SESSION['rollno']=$info['rollno'];
        $_SESSION['year']=$info['year'];
        $_SESSION['hostel']=$info['hostel'];
        $_SESSION['floor']=$info['floor'];
        $_SESSION['room_no']=$info['room_no'];
    }
    else{
        $InfoSql = "SELECT * FROM staff_info WHERE email = ?";
        $stmt = mysqli_prepare($db, $InfoSql); mysqli_stmt_bind_param($stmt, "s", $email); mysqli_stmt_execute($stmt); $InfoResult = mysqli_stmt_get_result($stmt);
        $info = $InfoResult->fetch_assoc();
        $_SESSION['user_id']=$info['s_id'];
        $_SESSION['name']=$info['name'];
        $_SESSION['rollno']=$info['s_rollno'];
        // $_SESSION['year']="-";
        // $_SESSION['hostel']=$info['hostel'];
        // $_SESSION['floor']=$info['floor'];
        // $_SESSION['room_no']=$info['room_no'];
        $_SESSION['category']=$info['category'];
        $_SESSION['role']=$info['role'];
        $_SESSION['role2']=$info['role'];
        if ($_SESSION['role2']==2){
            $InfoSql = "SELECT * FROM informations WHERE staff_id = ?";
            $stmt = mysqli_prepare($db, $InfoSql); mysqli_stmt_bind_param($stmt, "s", $_SESSION['rollno']); mysqli_stmt_execute($stmt); $InfoResult = mysqli_stmt_get_result($stmt);
            $info = $InfoResult->fetch_assoc();
            $_SESSION['year']="";
             $_SESSION['hostel']=$info['hostel'];
            $_SESSION['floor']=$info['floor'];
            $_SESSION['room_no']=$info['room_no'];
        }
    }
    $res['success'] = true;
    $res['message'] = 'Submitted successfully';
} else {
    $res['success'] = false;
    $res['message'] = 'Invalid User';
}
echo json_encode($res);