<?php
  require('../connect.php');

  $sending_user_id = $_SESSION['user_id'];
  $sending_username = $_SESSION['username_free_blocks'];
  $receiving_user_id = $_POST['user_id'];

  $msg = $sending_username . ' would like to be your friend. <input type="hidden" name="sending_user_id" value="' . $sending_user_id . '" />';

  // echo $msg;
  $conn = db_connect();

  $notification_type = "friend_request";
  $time_recieved = date('Y-m-d H:i:s');


  /*
   * Insert notification
   */
  $data = $conn->prepare('INSERT INTO notifications (type,	user_id,	time_recieved,	message) VALUES (:type,	:user_id,	:time_recieved, :message)');
  $data->bindParam(':type', $notification_type);
  $data->bindParam(':user_id', $receiving_user_id);
  $data->bindParam(':time_recieved', $time_recieved);
  $data->bindParam(':message', $msg);

  if($data->execute())
  {
    echo "success";
  }

?>
