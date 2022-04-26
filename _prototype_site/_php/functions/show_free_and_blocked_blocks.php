<?php
  /*
   * NOTE: Showing blocks was originally handled by get_calendar_blocks.php
   * It sent a json file to a ajax call which handled placing all the blocks
   * That's annoying to use so I'mm making this to show the blocks on the home page
   */

  require('../functions.php');
  $conn = db_connect();

  $user_id = $_POST['user_id'];

  $data = $conn->prepare('SELECT * FROM blocks WHERE user_id = :user_id');

  $data->bindParam(':user_id', $user_id);
  $data->execute();

  $arr = $data->fetchAll(PDO::FETCH_ASSOC);

  foreach($arr as $block):
    $block_title = ($block['block_type'] == "free" ) ? "Free" : "Blocked";
    if($block['block_type'] == "event") { $block_title = "Event";}
    $start_time_string = date("g:i", strtotime($block['start_time']));
    $end_time_string = date("g:i", strtotime($block['end_time']));
?>

<?php
  /*
   * Show free or blocked blocks
   */
   if($block_title == "Free" || $block_title == "Blocked") :
 ?>
<div
  class="block <?php echo $block['block_type']; ?>"
  data-id="<?php echo $block['id']; ?>"
  data-edit="false"
  data-start_date="<?php echo $block['start_date']; ?>"
  data-start_time="<?php echo $block['start_time']; ?>"
  data-end_time="<?php echo $block['end_time']; ?>"
  data-block_type="<?php echo $block['block_type']; ?>">

  <div class="title"><?php echo $block_title; ?></div>

  <div class="times"><?php echo $start_time_string; ?> - <?php echo $end_time_string; ?></div>

</div>
<?php
  // For event blocks
  else :

    /*
     * Get attendees
     */
    $data = $conn->prepare('SELECT * FROM users_in_event WHERE event_id = :eid');
    $data->bindParam(':eid', $block['event_id']);

    if($data->execute())
    {
      $attendees_arr = $data->fetchAll(PDO::FETCH_ASSOC);
      foreach ($attendees_arr as $attendee) {
        $attendees[] = get_user($attendee['receiving_user_id']);
      }
    }

?>
  <div
    class="block <?php echo $block['block_type']; ?>"
    data-id="<?php echo $block['id']; ?>"
    data-edit="false"
    data-start_date="<?php echo $block['start_date']; ?>"
    data-start_time="<?php echo $block['start_time']; ?>"
    data-end_time="<?php echo $block['end_time']; ?>"
    data-block_type="<?php echo $block['block_type']; ?>">

    <div class="title"><?php echo $block_title; ?></div>

    <div class="times"><?php echo $start_time_string; ?> - <?php echo $end_time_string; ?></div>

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

<?php
  endforeach;
?>
