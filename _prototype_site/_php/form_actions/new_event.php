<?php
  require('../connect.php');
  $conn = db_connect();

  $title = $_POST['event_title'];
  $description = $_POST['event_description'];

  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  $start_date = $_POST['start_date'];
  $attendees = $_POST['attendees'];
  $user_id = $_SESSION['user_id'];




  /*
   * Insert event
   */
  $data2 = $conn->prepare('INSERT INTO events (title, description, start_time, end_time, start_date, user_id)
                          VALUES (:title, :description, :start_time, :end_time, :start_date, :user_id)');

  $data2->bindParam(':title', $title);
  $data2->bindParam(':description', $description);
  $data2->bindParam(':start_time', $start_time);
  $data2->bindParam(':end_time', $end_time);
  $data2->bindParam(':start_date', $start_date);
  $data2->bindParam(':user_id', $user_id);


  if($data2->execute())
  {
    $res = "nice";
  }
  else
  {
    print_r($data2->errorInfo());
    $res = "not nice";
  }




  /*
   * Get id of event
   */

   $data3 = $conn->prepare('SELECT * FROM events WHERE title = :title AND description = :description');
   $data3->bindParam(':title', $title);
   $data3->bindParam(':description', $description);

   if($data3->execute())
   {
     $arr = $data3->fetch(PDO::FETCH_ASSOC);
     $event_id = $arr['id'];
   }
   else
   {
     print_r($data3->errorInfo());
     $res = "not nice";
   }



   /*
    * Insert block for this user
    */
   $block_type = "event";


   $data = $conn->prepare('INSERT INTO blocks (block_type, start_time, end_time, start_date, user_id, event_id)
                           VALUES (:block_type, :start_time, :end_time, :start_date, :user_id, :event_id)');
   $data->bindParam(':block_type', $block_type);
   $data->bindParam(':start_time', $start_time);
   $data->bindParam(':end_time', $end_time);
   $data->bindParam(':start_date', $start_date);
   $data->bindParam(':user_id', $user_id);
   $data->bindParam(':event_id', $event_id);

   if($data->execute())
   {

   }
   else
   {
     echo "not nice";
   }


   /*
    * Insert users_in_event for this user
    *
    * This table is to keep track of who's invited to an event and if they have accepted
    */

   $accepted = 1;
   $data = $conn->prepare('INSERT INTO users_in_event (receiving_user_id, sending_user_id, event_id, accepted)
                           VALUES (:receiving_user_id, :sending_user_id, :event_id, :accepted)');
   $data->bindParam(':receiving_user_id', $_SESSION['user_id']);
   $data->bindParam(':sending_user_id', $_SESSION['user_id']);
   $data->bindParam(':event_id', $event_id);
   $data->bindParam(':accepted', $accepted);


   if($data->execute())
   {

   }
   else
   {
     print_r($data->errorInfo());
     echo "not nice";
   }


  /*
   * Insert Notification and Block for each person invited
   */
   foreach ($attendees as $receiving_user_id) {

     $sending_user_id = $_SESSION['user_id'];
     $sending_username = $_SESSION['username_free_blocks'];

     $msg = $sending_username . ' invited you to ' . $title . '. <input type="hidden" name="sending_user_id" value="' . $sending_user_id . '" /><input type="hidden" name="event_id" value="' . $event_id . '" />';

     // echo $msg;
     $conn = db_connect();

     $notification_type = "event_request";
     $time_recieved = date('Y-m-d H:i:s');


     /*
      * Insert notification
      */
     $data = $conn->prepare('INSERT INTO notifications (type,	user_id,	time_recieved,	message, sender_user_id) VALUES (:type,	:user_id,	:time_recieved, :message, :sender_user_id)');
     $data->bindParam(':type', $notification_type);
     $data->bindParam(':user_id', $receiving_user_id);
     $data->bindParam(':time_recieved', $time_recieved);
     $data->bindParam(':message', $msg);
     $data->bindParam(':sender_user_id', $sending_user_id);

     if($data->execute())
     {
     }
     else
     {
       echo "nope";
     }



     /*
      * Insert block for each attendee
      */
     $block_type = "event";


     $data = $conn->prepare('INSERT INTO blocks (block_type, start_time, end_time, start_date, user_id, event_id)
                             VALUES (:block_type, :start_time, :end_time, :start_date, :user_id, :event_id)');
     $data->bindParam(':block_type', $block_type);
     $data->bindParam(':start_time', $start_time);
     $data->bindParam(':end_time', $end_time);
     $data->bindParam(':start_date', $start_date);
     $data->bindParam(':user_id', $receiving_user_id);
     $data->bindParam(':event_id', $event_id);

     if($data->execute())
     {

     }
     else
     {
       echo "not nice";
     }



     /*
      * Insert users_in_event for each attendee
      *
      * This table is to keep track of who's invited to an event and if they have accepted
      */

     $data = $conn->prepare('INSERT INTO users_in_event (receiving_user_id, sending_user_id, event_id)
                             VALUES (:receiving_user_id, :sending_user_id, :event_id)');
     $data->bindParam(':receiving_user_id', $receiving_user_id);
     $data->bindParam(':sending_user_id', $sending_user_id);
     $data->bindParam(':event_id', $event_id);


     if($data->execute())
     {

     }
     else
     {
       echo "not nice";
     }


   }

  echo $res;
