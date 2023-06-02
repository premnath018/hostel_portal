<?php
include '../db/connection.php';
session_start();
$db = db();
if ($db) {
    try {
        if (1)
         {
            extract($_POST);
            $stmt = $db->prepare("INSERT INTO students_info (rollno,name,email,year,hostel,room_no,floor) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param('sssssds',$rollno,$name,$email,$year,$hostel,$room_no,$floor);
            $stmt->execute();
            if ($stmt->error) {
                $res['success'] = false;
                $res['message'] = 'Error: ' . $stmt->error;
            } else {
                $role = '0';
                $stmt = $db->prepare("INSERT INTO login_users (email_id,role) VALUES (?,?)");
                $stmt->bind_param('ss',$email,$role);
                $stmt->execute();
                $res['success'] = true;
                $res['message'] = 'Submitted successfully';
            }
            $stmt->close();
        }else{
            $res['success']=false;
            $res['message']="Missing Values";
        }

    } catch (Exception $ex) {
        $res['success'] = false;
        $res['message'] = $ex->__toString();
    }
} else {
    die('Database error');
}
echo json_encode($res);