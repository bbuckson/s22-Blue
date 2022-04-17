<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Time</title>
    <?php require('_includes/scripts.php'); ?>
  </head>
  <body>

    <?php
    // If user is not logged in -> direct them to register-login page
    // Note: functions are located in _php/functions.php
    if(!is_logged_in())
    {
      header('Location: register-login.php');
    }
    ?>

    <div class="all-content-wrap home">

      <!-- Tob Nav bar -->
      <?php show_top_bar($root); ?>

      <!-- Calendar -->
      <div class="calendar-wrap personal">

        <?php
          $curr_date = date("D M jS");
          $date_formatted = date("Y-m-d");
        ?>

        <div class="date-wrap">
          <?php echo $curr_date; ?>
          <input name="curr_date" type="hidden" value="<?php echo $date_formatted; ?>" />
        </div>

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
          <div class="time-slot-wrap" data-hour="<?php echo $i; ?>" data-hour-type="PM">
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


      <!-- Bottom Nav Bar -->
      <?php show_bottom_bar($root); ?>





    </div>
  </body>
</html>
