<?php
  require('../functions.php');

  $conn = db_connect();

  $event = get_event($_POST['event_id']);
  $block = get_block($_POST['block_id']);

  $user_id = $_POST['user_id'];
  $my_id = $_SESSION['user_id'];

  // Check if we can edit block
  if($_SESSION['user_id'] == $block['user_id'])
  {
    $can_edit = "true";
  }
  else
  {
    $can_edit = "false";
  }

  $user_in_event = get_users_in_event($event['id'], $_POST['user_id']);

  /*
   * Get attendees
   */
  $data = $conn->prepare('SELECT * FROM users_in_event WHERE event_id = :eid');
  $data->bindParam(':eid', $_POST['event_id']);

  if($data->execute())
  {
    $attendees_arr = $data->fetchAll(PDO::FETCH_ASSOC);
    foreach ($attendees_arr as $attendee) {
      $attendees[] = get_user($attendee['receiving_user_id']);
    }
  }

  // Only show info on block if this user is us
  if($user_id == $my_id):
?>

  <div class="block event"
    data-id="<?php echo $_POST['block_id']; ?>"
    data-edit="<?php echo $can_edit; ?>"
    data-start_date="<?php echo $block['start_date'];?>"
    data-start_time="<?php echo $block['start_time'];?>"
    data-end_time="<?php echo $block['end_time'];?>"
    data-block_type="event"
    data-accepted="<?php echo $user_in_event['accepted'];?>"
    style="
      top: <?php echo $_POST['y_pos'];?>px;
      height: <?php echo $_POST['block_height'];?>px;
      max-height: <?php echo $_POST['block_height'];?>px;
    "
    >
    <div class="title"><?php echo $event['title']; ?></div>
    <div class="times"><?php echo $_POST['full_start_time'];?> - <?php echo $_POST['full_end_time'];?></div>
    <div class="attendee-images">

        <?php
          foreach ($attendees as $attendee) {
            echo '<div class="img-wrap">';
              echo '<img src="_pics/_users/' . $attendee['image'] . '" />';
            echo '</div>';
          }
        ?>

    </div>
    <div class="description"><?php echo $event['description']; ?></div>
  </div>
<?php
  // If we're viewing someone else's calendar
  else:
?>
  <div class="block event"
    data-id="<?php echo $_POST['block_id']; ?>"
    data-edit="false"
    data-start_date="<?php echo $block['start_date'];?>"
    data-start_time="<?php echo $block['start_time'];?>"
    data-end_time="<?php echo $block['end_time'];?>"
    data-block_type="event"
    data-accepted="<?php echo $user_in_event['accepted'];?>"
    style="
      top: <?php echo $_POST['y_pos'];?>px;
      height: <?php echo $_POST['block_height'];?>px;
      max-height: <?php echo $_POST['block_height'];?>px;
    "

    >

    <div class="title">Event</div>
    <div class="times"><?php echo $_POST['full_start_time'];?> - <?php echo $_POST['full_end_time'];?></div>
    <div class="attendee-images">
      <?php
        foreach ($attendees as $attendee) {
          echo '<div class="img-wrap">';
            echo '<img src="_pics/_users/' . $attendee['image'] . '" />';
          echo '</div>';
        }
      ?>

    </div>
  </div>

<?php endif; ?>
