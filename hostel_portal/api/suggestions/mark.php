<?php
include '../db/connection.php';
session_start();

$db = db();


if ($db) {
    try {
        if (1)
         {
            extract($_POST);
            $status = '0';
            $currentDate = date('Y-m-d');
            $stmt = $db->prepare("INSERT INTO suggestions_tasks (sg_id,hostel,date,for_place,suggestion_title,task_date,task_title,task_descrip,status,category) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('dsssssssss',$sg_id,$hostel,$date,$for_place,$suggestion_title,$currentDate,$task_title,$task_descrip,$status,$category);
            $stmt->execute();
            if ($stmt->error) {
                $res['success'] = false;
                $res['message'] = 'Error: ' . $stmt->error;
            } else {
                    $status = '1';
                    $stmt = $db->prepare("UPDATE suggestions SET status=? WHERE  sg_id=? ;");
                    $stmt->bind_param('sd',$status,$sg_id);
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