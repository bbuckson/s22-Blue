<?php
// If user is not logged in -> direct them to register-login page
// Note: functions are located in _php/functions.php
if(!is_logged_in())
{
  require("_php/functions.php");
  header('Location: register-login.php');
  echo '<script>console.log("Not Logged In")</script>';
  //echo "<script>window.location.href='target.php';</script>";
}
else
{
  echo '<script>console.log("Is Logged In")</script>';
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Time</title>
    <?php require('_includes/scripts.php'); ?>
  </head>
  <body>



    <input type="hidden" name="this_users_id" value="<?php echo $_SESSION['user_id']; ?>" />
    <input type="hidden" name="my_user_id" value="<?php echo $_SESSION['user_id']; ?>" />

    <div class="all-content-wrap home">
      <!-- <div id="test-area" style="margin-top: 150px; font-size: 8px;">  </div> -->

      <!-- Tob Nav bar -->
      <?php show_top_bar($root); ?>

      <!-- Calendar -->
      <div class="calendar-wrap personal">

        <?php
          $curr_date = date("D M jS");
          $date_formatted = date("Y-m-d");
        ?>

        <div class="blocks-wrap">
          <div class="block-column">

          </div>
          <!-- <div class="block free">
            <div class="title">
              Free
            </div>
            <div class="times">
              4:00 - 11
            </div>
          </div>
          <div class="block blocked">
            <div class="title">
              Blocked
            </div>
            <div class="times">
              4:00 - 11
            </div>
          </div> -->
        </div>


        <div class="date-wrap">
          <?php echo $curr_date; ?>
          <input name="curr_date" type="hidden" value="<?php echo $date_formatted; ?>" />
        </div>


        <!-- Time Slots -->
        <?php
          for($i = 1; $i < 13; $i++) :
        ?>
          <div class="time-slot-wrap" data-hour="<?php echo $i; ?>" data-hour-type="AM">
            <div class="time-text">
              <?php echo $i . ' AM'; ?>
            </div>
            <div class="time-slot">

            </div>
          </div>
        <?php endfor; ?>

        <?php
          for($i = 1; $i < 13; $i++) :
        ?>
          <div class="time-slot-wrap" data-hour="<?php echo $i + 12; ?>" data-hour-type="PM">
            <div class="time-text">
              <?php echo $i . ' PM'; ?>
            </div>
            <div class="time-slot">

            </div>
          </div>
        <?php endfor; ?>
      </div>


      <!-- Popup to set block of time -->
      <div class="overlay-wrap new-block">
        <div class="set-block-wrap">
          <h3>New Block</h3>
          <p class="error-msg">

          </p>
          <div class="single-label">
            Block Type
          </div>

          <div class="row">
            <div class="button free block-type" data-value="free">
              Free
            </div>
            <div class="button blocked block-type" data-value="blocked">
              Blocked
            </div>
          </div>

          <div class="row">
            <span>Date</span>
            <input type="date" name="date" required />
          </div>

          <div class="row">
            <span>Start Time</span>
            <input type="time" name="start_time" required />
          </div>

          <div class="row">
            <span>End Time</span>
            <input type="time" name="end_time" required />
          </div>

          <div class="row">
            <div class="button submit" data-form="new-block">
              Add Block
            </div>
          </div>
          <div class="close-popup">
            Cancel
          </div>
        </div>
      </div>





      <!-- Popup to EDIT block of time -->
      <div class="overlay-wrap edit-block">
        <div class="edit-block-wrap">
          <input type="hidden" name="block_id" />
          <h3>Edit Block</h3>
          <p class="error-msg">

          </p>
          <div class="single-label">
            Block Type
          </div>

          <div class="row">
            <div class="button free block-type" data-value="free">
              Free
            </div>
            <div class="button blocked block-type" data-value="blocked">
              Blocked
            </div>
          </div>

          <div class="row">
            <span>Date</span>
            <input type="date" name="date" required />
          </div>

          <div class="row">
            <span>Start Time</span>
            <input type="time" name="start_time" required />
          </div>

          <div class="row">
            <span>End Time</span>
            <input type="time" name="end_time" required />
          </div>

          <div class="row">
            <div class="button submit" data-form="edit-block">
              Save
            </div>
          </div>
          <div class="close-popup">
            Cancel
          </div>

        </div>
      </div>



      </div>


      <!-- Bottom Nav Bar -->
      <?php show_bottom_bar($root); ?>





    </div>
  </body>
</html>
