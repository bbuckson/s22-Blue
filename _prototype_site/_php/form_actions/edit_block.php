<?php
  require('../connect.php');
  $conn = db_connect();

  $block_id = $_POST['block_id'];
  $block_type = $_POST['block_type'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  $start_date = $_POST['start_date'];


  $data = $conn->prepare('UPDATE blocks SET block_type = :block_type, start_time = :start_time, end_time = :end_time, start_date = :start_date WHERE id = :block_id');

  $data->bindParam(':block_type', $block_type);
  $data->bindParam(':start_time', $start_time);
  $data->bindParam(':end_time', $end_time);
  $data->bindParam(':start_date', $start_date);
  $data->bindParam(':block_id', $block_id);

  if($data->execute())
  {
    $res = "nice";
  }
  else
  {
    $res = "not nice";
  }

  echo $res;
