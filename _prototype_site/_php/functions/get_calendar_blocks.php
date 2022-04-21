<?php
  require('../connect.php');
  $conn = db_connect();

  $user_id = $_POST['user_id'];

  $data = $conn->prepare('SELECT * FROM blocks WHERE user_id = :user_id');

  $data->bindParam(':user_id', $user_id);
  $data->execute();

  $arr = $data->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($arr);
