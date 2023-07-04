<?php

include '../db/connection.php';
session_start();
$db = db();
$res = array();
$data = array();
if ($db) {
    try {
        extract($_POST);
        if ($_SESSION['role'] == 0)
        $sql = "SELECT q.query_id, q.date, s.rollno, q.hostel, q.room_no, q.problem_category, q.problem_statement, q.status 
        FROM room_query q 
        LEFT JOIN students_info s ON q.reported_by = s.id 
        WHERE q.room_no = '$_SESSION[room_no]' AND q.hostel = '$_SESSION[hostel]' " . (($status == 9) ? "" : "AND q.status = '$status'") . " 
        ORDER BY q.query_id DESC;";
        
        if ($_SESSION['role'] == 2)
        $sql = "SELECT q.query_id, q.date, s.rollno, q.hostel, q.room_no, q.problem_category, q.problem_statement, q.status 
        FROM room_query q 
        LEFT JOIN students_info s ON q.reported_by = s.id 
        WHERE q.hostel = '$_SESSION[hostel]' " . (($status == 9) ? "" : "AND q.status = '$status'") . " 
        ORDER BY q.query_id DESC;";        
        
        $result = mysqli_query($db, $sql);
      //  echo($status);
        if (mysqli_num_rows($result) >= 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            $res['success'] = true;
            $res['data'] = $data;
            $res['check'] = $_SESSION['role'];
        }else{
            $res['success'] = false;
            $res['message'] = "No Records Found";
        }

        echo json_encode($res);
    } catch (Exception $ex) {
        die('Error: ' . $ex->__toString());
    }
} else {
    die('Database error');
}

