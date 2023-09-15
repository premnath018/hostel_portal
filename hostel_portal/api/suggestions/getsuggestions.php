<?php

include '../db/connection.php';
session_start();
$db = db();
$res = array();
$data = array();
if ($db) {
    try {
        extract($_POST);
        $sql = "SELECT q.sg_id, s.rollno, q.hostel, q.for_place, q.suggestion_title, q.`date`,
               SUM(CASE WHEN l.`action` = '1' THEN 1 ELSE 0 END) AS num_likes,
               IF(SUM(CASE WHEN l.user_id = $_SESSION[user_id] AND l.`action` = '1' THEN 1 ELSE 0 END) > 0, 'liked', 'not_liked') AS user_like_status
        FROM suggestions q
        LEFT JOIN students_info s ON q.reported_by = s.id
        LEFT JOIN likes l ON q.sg_id = l.post_id";
        if ($forplace == 7) {
            $sql .= " WHERE q.`status`='1'
                    GROUP BY q.sg_id, s.rollno, q.hostel, q.for_place, q.suggestion_title, q.`date`
                    ORDER BY q.sg_id DESC;";
        } else {
            $sql .= " WHERE q.`status`='0'";
            if ($forplace) {
                $sql .= " AND q.for_place = '$forplace'";
            }
            $sql .= " GROUP BY q.sg_id, s.rollno, q.hostel, q.for_place, q.suggestion_title, q.`date`
                    ORDER BY q.sg_id DESC;";
        }
        $result = mysqli_query($db, $sql);
      //  echo($status);
        if (mysqli_num_rows($result) >= 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            $res['success'] = true;
            $res['data'] = $data;
            $res['role'] = $_SESSION['role'];
            $res['hostel'] = $_SESSION['hostel'];
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

