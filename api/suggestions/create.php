<?php
include '../db/connection.php';
session_start();

$db = db();
function addimage($rollno){
    date_default_timezone_set('Asia/Kolkata');
    $datetime = date('d-m-y-h-i-s');
    $dir = './../../Suggestions/'.$rollno.'/';
    if (isset($_FILES["file"])){
    $target_file = $dir.basename($_FILES["file"]["name"]);   //name is to get the file name of uploaded file
    $filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $newfilename = $dir.$rollno.'-'.$datetime.".".$filetype;

    if (!file_exists($dir)){
        if (mkdir($dir, 0777, true)){
            move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename);
        }
    }
    else{ 
        move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename);
    }
     return $newfilename;   
    }
    else
    return '';

}
if ($db) {
    try {
        if (1)
         {
            extract($_POST);
            $rollNo = $_SESSION['rollno'];
            $student_id = $_SESSION['user_id'];
            $hostel = $_SESSION['hostel'];
            $currentDate = date('Y-m-d');
            $temppath = addimage($rollNo);
            $stmt = $db->prepare("INSERT INTO suggestions (reported_by,hostel,date,for_place,suggestion_title,sg_descrip,sg_photo_link) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param('dssssss',$student_id, $hostel,$currentDate, $for,$title,$descrip,$temppath);
            $stmt->execute();
            if ($stmt->error) {
                $res['success'] = false;
                $res['message'] = 'Error: ' . $stmt->error;
            } else {
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