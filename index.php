<?php
session_start();
    $page = "dashboard";
    if (isset($_SESSION['role'])) 
   { $page = ($_SESSION['role'] == '0') ? "dashboard" : (($_SESSION['role'] == '2') ? "roomquery" :"tasks");}
    echo  "<meta http-equiv='refresh' content='0; url=pages/$page'>";
?>