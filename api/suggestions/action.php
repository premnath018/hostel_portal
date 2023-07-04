<?php
include '../db/connection.php';
session_start();
$db = db();
$res = array();
if ($db) {
    try {
        if (1)
         {
            extract($_POST);
            $uid = $_SESSION['user_id'];
            $checkstmt = $db->prepare("SELECT * From likes WHERE user_id =? AND post_id=?;");
            mysqli_stmt_bind_param($checkstmt, "dd",$uid, $post_id); mysqli_stmt_execute($checkstmt);
            $checkResult = mysqli_stmt_get_result($checkstmt);
            if ($checkResult->num_rows > 0) {
                $stmt = $db->prepare("UPDATE likes SET action=? WHERE user_id=? AND post_id=?;");
                $stmt->bind_param('sdd', $value, $uid, $post_id);
            } else {
                $stmt = $db->prepare("INSERT INTO likes (action, user_id, post_id) VALUES (?, ?, ?);");
                $stmt->bind_param('sdd', $value, $uid, $post_id);
            }
            $stmt->execute();
            if ($stmt->error) {
                $res['success'] = false;
                $res['message'] = 'Error: ' . $stmt->error;
            } else {
                $likecount = $db->prepare("SELECT COUNT(*) AS like_count From likes WHERE post_id=? AND action = '1';");
                mysqli_stmt_bind_param($likecount, "d",$post_id); mysqli_stmt_execute($likecount);
                $result = mysqli_stmt_get_result($likecount);  $like_info = mysqli_fetch_array($result);
                $res = array(
                    'success' => true,
                    'message' => 'Submitted successfully',
                    'count' => $like_info['like_count'],
                    'hostel' => $_SESSION['hostel']
                );
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