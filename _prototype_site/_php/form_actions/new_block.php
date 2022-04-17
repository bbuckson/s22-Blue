<?php
  require('../connect.php');
  $conn = db_connect();

  $block_type = $_POST['block_type'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  $start_date = $_POST['start_date'];
  $user_id = $_SESSION['user_id'];

  $data = $conn->prepare('INSERT INTO blocks (block_type, start_time, end_time, start_date, user_id)
                          VALUES (:block_type, :start_time, :end_time, :start_date, :user_id)');

  $data->bindParam(':block_type', $block_type);
  $data->bindParam(':start_time', $start_time);
  $data->bindParam(':end_time', $end_time);
  $data->bindParam(':start_date', $start_date);
  $data->bindParam(':user_id', $user_id);

  if($data->execute())
  {
    return "nice";
  }
  else
  {
    return "not nice";
  }
