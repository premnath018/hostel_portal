<?php
include '../db/connection.php';
session_start();
$db = db();
if ($db) {
    try {
        if (1)
         {
            $status = '2';
            extract($_POST);
            $stmt = $db->prepare("UPDATE room_query SET status=? WHERE  query_id=? ;");
            $stmt->bind_param('sd',$status,$q_id);
            $stmt->execute();
            if ($stmt->error) {
                $res['success'] = false;
                $res['message'] = 'Error: ' . $stmt->error;
            } else {
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