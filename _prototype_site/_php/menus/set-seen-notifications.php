<?php
  if(!isset($_SESSION)) {
     session_start();
  }
  require('../connect.php');

  $conn = db_connect();

  $seen = 1;
  $uid = $_SESSION['user_id'];

  $data = $conn->prepare('UPDATE notifications SET seen = :seen WHERE user_id = :uid');

  $data->bindParam(':seen', $seen);
  $data->bindParam(':uid', $uid);

  $data->execute();

?>
