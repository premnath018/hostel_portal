<?php 
  include './glogin.php';
  $auth_url = $client->createAuthUrl();
  header("Location:$auth_url");
?>