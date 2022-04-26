<?php
  if(!isset($_SESSION)) {
     session_start();
  }
  require('../functions.php');

  $conn = db_connect();

  /*
   * Show Notifications
   */

  $user_id = $_SESSION['user_id'];

  $data = $conn->prepare('SELECT * FROM notifications WHERE user_id = :user_id');
  $data->bindParam(':user_id', $user_id );

  if($data->execute())
  {
    $arr = $data->fetchAll(PDO::FETCH_ASSOC);

    // If there are any results
    if($data->rowCount() > 0)
    {
      //echo json_encode($arr);
      foreach ($arr as $item) :
        $sender_user = get_user($item['sender_user_id']);

        // Set attributes to be included in each item
        $attributes = 'data-type="' . $item['type'] . '" data-notification-id="' . $item['id'] . '"';
        if($item['type'] = "friend_request")
        {
          $attributes .= ' data-sender="' . $item['sender_user_id'] . '"';
        }
        if($item['type'] = "event_request")
        {
          $attributes .= ' data-users-in-event-id="' . $item['users_in_event_id'] . '" data-event-id="' . $item['event_id'] . '"';
        }
?>



        <div class="item" data-seen="<?php echo $item['seen']; ?>" <?php echo $attributes; ?>>
          <div class="content-wrap">
            <img src="_pics/_users/<?php echo $sender_user['image'];?>" class="icon" />
            <div class="msg-wrap">
              <?php echo $item['message'];?>
            </div>
          </div>

          <?php if($item['type'] != "event_updated") : ?>
            <div class="accept-reject-row">
              <div class="button accept" data-value="accept">
                Accept
              </div>
              <div class="button reject" data-value="reject">
                Remove
              </div>
            </div>
          <?php endif; ?>
        </div>

<?php
      endforeach;
    }
    else
    {
      echo
      '<div class="item">
          <div class="content-wrap">
            No new notifcations.
          </div>
      </div>';
    }
  }

?>
