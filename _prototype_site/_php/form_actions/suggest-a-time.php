<?php
  require('../functions.php');
  $conn = db_connect();
  $attendees = $_POST['attendees'];

  // Add ourself to list
  array_unshift($attendees, $_SESSION['user_id']);

  // Gather rest of data
  if(isset($_POST['start_date']) && $_POST['start_date'] != "")
    $start_date = $_POST['start_date'];
  else
    $start_date = date("Y-m-d", strtotime('today midnight'));

  if(isset($_POST['start_time']) && $_POST['start_time'] != "")
  {
    $start_time = strtotime($_POST['start_time']);
  }
  else
  {
    $start_time = strtotime('today 01:00am');
    $start_time_string = date("H:i", strtotime('today 01:00am'));
  }

  if(isset($_POST['end_time']) && $_POST['end_time'] != "")
  {
    $end_time = strtotime($_POST['end_time']);
  }
  else
  {
    $end_time_string = date("H:i", strtotime('today 11:59pm'));
    $end_time = strtotime('today 11:59pm');
  }


  // Go list of times every 15 minutes between start and end time
  $range=range($start_time,$end_time,15*60);

  // Go through each user and add an array of their blocks to an array and an array of their available times to an array
  foreach($attendees as $attendee)
  {
    $attendees_blocks[$attendee] = get_users_blocks_time_desc($attendee);
    $attendee_times[$attendee] = block_time_within_range($attendees_blocks[$attendee], $range);
  }

  // Go through each time in range. If none of the attendee_times arrays has that time blocked, add it to available times
  for($i = 0; $i < sizeof($range); $i++)
  {
    // Go through each of attendee list and check if time is available
    foreach ($attendee_times as $user_id => $times_list) {
      if($times_list[$i] == "blocked")
      {
        $available_times[$i] = "blocked";
        break;
      }
      else
      {
        $available_times[$i] = $range[$i];
      }
    }
  }


  // print_r($attendee_times);
  //
  // print_r($available_times);

  //print_r($attendees_blocks);

  // $test['start_date'] = $start_date;
  // $test['start_time'] = $start_time;
  // $test['start_time_string'] = $start_time_string;
  // $test['end_time'] = $end_time;
  // $test['end_time_string'] = $end_time_string;
  //
  // print_r($test);



   /*
    * Go through each time and see if it falls in between a block
    */
  function block_time_within_range($block_list, $range_of_times)
  {
    $times = $range_of_times;

    // Go through each time
    for($i = 0; $i < sizeof($times); $i++)
    {
      $time_to_check = $times[$i];

      // Go throu each block and see if time falls in it
      foreach ($block_list as $block) {
        $start_time = strtotime($block['start_time']);;
        $end_time = strtotime($block['end_time']);
        $block_type = $block['block_type'];

        // Check if in range and not blocked or event
        if($time_to_check >= $start_time && $time_to_check <= $end_time) {

          if($block_type != "free")
          {
            $times[$i] = "blocked";
          }
          else
          {
            $times[$i] = "free";
          }

        }

      }
    }


    return $times;
  }

?>

<div class="column">
  <div class="item"></div>
<?php
    /*
     * Generate a column of user's images
     */

     foreach ($attendees as $attendee) :
       $attendee_user = get_user($attendee);
 ?>

  <div class="item"><img src="_pics/_users/<?php echo $attendee_user['image']; ?>" /></div>

<?php endforeach; ?>


</div>


<?php
  foreach($available_times as $key => $available_time) :
    if($available_time != "blocked") :
?>
  <div class="column">
    <div class="item">
      <a
        class="button time"
        data-start_time="<?php echo date("h:i", $available_time);?>"
        data-end_time="<?php echo date("h:i", $available_time);?>"
        data-curr_date="<?php echo $start_date;?>"
        >
        <?php echo date("g:i", $available_time);?>
      </a>
    </div>

    <?php
      foreach ($attendee_times as $user_id => $value) :
    ?>
        <div class="item">

      <?php
        if($attendee_times[$user_id][$key] == "free") :
      ?>
          <div class="block free">Free</div>
      <?php
        endif;
      ?>

        </div>
    <?php
      endforeach;
    ?>
  </div>
  <?php endif; ?>
<?php endforeach; ?>
