<?php
  if(!isset($_SESSION)) {
     session_start();
  }
  require('../connect.php');

  $sender_id = $_POST['sender_id'];
  $user_id = $_SESSION['user_id'];
  $notification_id = $_POST['notification_id'];

  $conn = db_connect();

  // Remove notification
  $data = $conn->prepare('DELETE FROM notifications WHERE id = :nid');
  $data->bindParam(':nid', $notification_id);
  $data->execute();

  if($_POST['value'] == "accept")
  {
    // Add friend to friends table
    $data = $conn->prepare('INSERT INTO friends (user_id_1, user_id_2) VALUES (:user_id_1, :user_id_2)');
    $data->bindParam(':user_id_1', $user_id);
    $data->bindParam(':user_id_2', $sender_id);
    $data->execute();

    // Add again only with sender's id in first user_id column (just to make things easier)
    $data = $conn->prepare('INSERT INTO friends (user_id_1, user_id_2) VALUES (:user_id_1, :user_id_2)');
    $data->bindParam(':user_id_1', $sender_id);
    $data->bindParam(':user_id_2', $user_id);
    $data->execute();

    $return_msg = "User has been added to your friends list!";
  }
  else
  {
    $return_msg = "Friend Request Removed";
  }

  echo $return_msg;





?>
