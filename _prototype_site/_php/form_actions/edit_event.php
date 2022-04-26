<?php

  require('../functions.php');
  $conn = db_connect();

  $event_id = $_POST['event_id'];

  $title = $_POST['event_title'];
  $description = $_POST['event_description'];

  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  $start_date = $_POST['start_date'];

  if(isset($_POST['attendees']))
  {
    $attendees = $_POST['attendees'];
  }
  else
  {
    $attendees = array();
  }

  $user_id = $_SESSION['user_id'];




  /*
   * Update event
   */
  $data2 = $conn->prepare('UPDATE events SET title = :title, description = :description, start_time = :start_time, end_time = :end_time, start_date = :start_date, user_id = :user_id WHERE id = :eid');

  $data2->bindParam(':title', $title);
  $data2->bindParam(':description', $description);
  $data2->bindParam(':start_time', $start_time);
  $data2->bindParam(':end_time', $end_time);
  $data2->bindParam(':start_date', $start_date);
  $data2->bindParam(':user_id', $user_id);
  $data2->bindParam(':eid', $event_id);


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
   * Get block id associated with this event
   */

   $data3 = $conn->prepare('SELECT * FROM blocks WHERE event_id = :eid AND user_id = :uid');
   $data3->bindParam(':eid', $event_id);
   $data3->bindParam(':uid', $user_id);

   if($data3->execute())
   {
     $arr = $data3->fetch(PDO::FETCH_ASSOC);
     $block_id = $arr['id'];
   }
   else
   {
     print_r($data3->errorInfo());
     $res = "not nice";
   }



   /*
    * Update block for this user
    */

   $data = $conn->prepare('UPDATE blocks SET start_time = :start_time, end_time = :end_time, start_date = :start_date WHERE id = :bid');
   $data->bindParam(':start_time', $start_time);
   $data->bindParam(':end_time', $end_time);
   $data->bindParam(':start_date', $start_date);
   $data->bindParam(':bid', $block_id);
   // $data->bindParam(':uid', $user_id);

   if($data->execute())
   {

   }
   else
   {
     print_r($data->errorInfo());
     echo "not nice";
   }


   /*
    * Insert users_in_event for this user
    *
    * This table is to keep track of who's invited to an event and if they have accepted
    */

   // $accepted = 1;
   // $data = $conn->prepare('INSERT INTO users_in_event (receiving_user_id, sending_user_id, event_id, accepted)
   //                         VALUES (:receiving_user_id, :sending_user_id, :event_id, :accepted)');
   // $data->bindParam(':receiving_user_id', $_SESSION['user_id']);
   // $data->bindParam(':sending_user_id', $_SESSION['user_id']);
   // $data->bindParam(':event_id', $event_id);
   // $data->bindParam(':accepted', $accepted);
   //
   //
   // if($data->execute())
   // {
   //
   // }
   // else
   // {
   //   print_r($data->errorInfo());
   //   echo "not nice";
   // }







  /*
   * Insert Notification and Block for each person invited
   */
   foreach ($attendees as $receiving_user_id) {

     $sending_user_id = $_SESSION['user_id'];
     $sending_username = $_SESSION['username_free_blocks'];


     // echo $msg;
     $conn = db_connect();


     /*
      * Insert block for each new attendee
      */
      if( !get_users_in_event($event_id, $receiving_user_id) )
      {

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
          print_r($data->errorInfo());
          echo "not nice";
        }
      }
      /*
       * Update block for old attendees
       */
      else
      {
        $data3 = $conn->prepare('SELECT * FROM blocks WHERE event_id = :eid AND user_id = :uid');
        $data3->bindParam(':eid', $event_id);
        $data3->bindParam(':uid', $receiving_user_id);

        if($data3->execute())
        {
          $arr = $data3->fetch(PDO::FETCH_ASSOC);
          $block_id = $arr['id'];
        }
        else
        {
          print_r($data3->errorInfo());
          $res = "not nice";
        }



        /*
         * Update block for this user
         */

        $data = $conn->prepare('UPDATE blocks SET start_time = :start_time, end_time = :end_time, start_date = :start_date WHERE id = :bid');
        $data->bindParam(':start_time', $start_time);
        $data->bindParam(':end_time', $end_time);
        $data->bindParam(':start_date', $start_date);
        $data->bindParam(':bid', $block_id);
        // $data->bindParam(':uid', $user_id);

        if($data->execute())
        {

        }
        else
        {
          print_r($data->errorInfo());
          echo "not nice";
        }
      }


     /*
      * Insert users_in_event for each attendee if they weren't already there
      *
      * This table is to keep track of who's invited to an event and if they have accepted
      */


    if( !get_users_in_event($event_id, $receiving_user_id) ) {

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

       $msg = $sending_username . ' invited you to ' . $title . '. <input type="hidden" name="sending_user_id" value="' . $sending_user_id . '" /><input type="hidden" name="event_id" value="' . $event_id . '" />';
       $notification_type = "event_request";
     }
     else
     {
       $msg = $sending_username . ' has updated ' . $title . '. <input type="hidden" name="sending_user_id" value="' . $sending_user_id . '" /><input type="hidden" name="event_id" value="' . $event_id . '" />';
      $notification_type = "event_updated";
     }


     /*
      * Get id of users in event
      */
     $users_in_event_id = $conn->lastInsertId();


     /*
      * Insert notification
      */


      $time_recieved = date('Y-m-d H:i:s');

      $data = $conn->prepare('INSERT INTO notifications (type,	user_id,	time_recieved,	message, sender_user_id, event_id, users_in_event_id) VALUES (:type,	:user_id,	:time_recieved, :message, :sender_user_id, :event_id, :users_in_event_id)');
      $data->bindParam(':type', $notification_type);
      $data->bindParam(':user_id', $receiving_user_id);
      $data->bindParam(':time_recieved', $time_recieved);
      $data->bindParam(':message', $msg);
      $data->bindParam(':sender_user_id', $sending_user_id);
      $data->bindParam(':event_id', $event_id);
      $data->bindParam(':users_in_event_id', $users_in_event_id);

      if($data->execute())
      {
      }
      else
      {
       echo "nope";
      }













   }




  /*
   * Remove blocks and users_in_event for all users that were removed
   */

   // Get array of users_in_event item associated with this event
   $users_in_event_rows = get_all_users_in_event($event_id);

   foreach ($users_in_event_rows as $prev_attendee) {

     if( !in_array($prev_attendee['receiving_user_id'], $attendees) )
     {
       echo $prev_attendee['receiving_user_id'] . 'Not thhere';

       // Get id of block to delete
       $data3 = $conn->prepare('SELECT * FROM blocks WHERE event_id = :eid AND user_id = :uid');
       $data3->bindParam(':eid', $event_id);
       $data3->bindParam(':uid', $prev_attendee['receiving_user_id']);

       if($data3->execute())
       {
         $arr = $data3->fetch(PDO::FETCH_ASSOC);
         $block_id = $arr['id'];
       }
       else
       {
         print_r($data3->errorInfo());
         $res = "not nice";
       }


       // Remove block
       $data = $conn->prepare('DELETE FROM blocks WHERE id = :bid');
       $data->bindParam(':bid', $block_id);
       if($data->execute())
       {
       }
       else
       {
         print_r($data->errorInfo());
       }



       // Remove users_in_event
       $user_in_event = get_users_in_event( $event_id, $prev_attendee['receiving_user_id'] );
       $data = $conn->prepare('DELETE FROM users_in_event WHERE id = :eit');
       $data->bindParam(':eit', $user_in_event[0]['id']);
       if($data->execute())
       {
         echo "id => " . $user_in_event[0]['id'];
       }
       else
       {
         print_r($data->errorInfo());
       }



     }
   }

  echo $res;
