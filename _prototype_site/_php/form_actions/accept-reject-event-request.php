<?php
  if(!isset($_SESSION)) {
     session_start();
  }
  require('../connect.php');

  // $sender_id = $_POST['sender_id'];
  // $user_id = $_SESSION['user_id'];
  $notification_id = $_POST['notification_id'];
  $users_in_event_id = $_POST['users_in_event_id'];
  $event_id = $_POST['event_id'];

  $conn = db_connect();



  // Accept Event Request
  if($_POST['value'] == "accept")
  {
    $accepted = 1;
    // Set users_in_event to accepted
    $data = $conn->prepare('UPDATE users_in_event SET accepted = :accepted WHERE id = :uieid');
    $data->bindParam(':accepted', $accepted);
    $data->bindParam(':uieid', $users_in_event_id);
    if($data->execute())
    {

    }
    else
    {
      echo 'Something went wrong';
    }

    // Remove notification
    $data = $conn->prepare('DELETE FROM notifications WHERE id = :nid');
    $data->bindParam(':nid', $notification_id);
    $data->execute();


    $return_msg = "Event has been added to your calendar!";
  }
  else
  {
    // Gotta Remove the notification and block and users_in_event

    // Remove notification
    $data = $conn->prepare('DELETE FROM notifications WHERE id = :nid');
    $data->bindParam(':nid', $notification_id);
    $data->execute();

    // Remove Block
    $data = $conn->prepare('DELETE FROM blocks WHERE event_id = :eid');
    $data->bindParam(':eid', $event_id);
    $data->execute();


    // Remove users_in_event
    $data = $conn->prepare('DELETE FROM users_in_event WHERE event_id = :eid');
    $data->bindParam(':eid', $event_id);
    $data->execute();

    $return_msg = "Event request removed..";
  }

  echo $return_msg;





?>
