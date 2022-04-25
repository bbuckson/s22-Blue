<?php
// If user is not logged in -> direct them to register-login page
// Note: functions are located in _php/functions.php
require("_php/functions.php");
// if(!is_logged_in())
// {
//   header('Location: register-login.php');
// }
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


    <?php
      /*
       * Set initial relationship type
       */
       $relationship_type = "none";
       $time_slot_popup_to_open = "none";

      /*
       * Check if this is the user's personal calendar
       */
       $is_personal_calendar = false;
       if($_SESSION['user_id'] == $_GET['uid'])
       {
         $relationship_type = "personal";
         $time_slot_popup_to_open = "new-block";
       }

       /*
        * Check if it's a friend
        */
        $conn = db_connect();
        $data = $conn->prepare('SELECT * FROM friends WHERE user_id_1 = :user_id AND user_id_2 = :user_id_2');
        $data->bindParam(':user_id', $_SESSION['user_id']);
        $data->bindParam(':user_id_2', $_GET['uid']);
        $data->execute();
        if($data->rowCount() > 0 && $_GET['uid'] != $_SESSION['user_id'])
        {
          $relationship_type = "friends";
          $time_slot_popup_to_open = "new-event";
        }


       /*
        * If this isn't their personal calendar, make sure they can't edit
        */

        echo '<input type="hidden" name="relationship" value="' . $relationship_type . '" />';
    ?>
    <input type="hidden" name="this_users_id" value="<?php echo $_GET['uid']; ?>" />
    <input type="hidden" name="my_user_id" value="<?php echo $_SESSION['user_id']; ?>" />

    <div class="all-content-wrap home">
      <!-- <div id="test-area" style="margin-top: 150px; font-size: 8px;">  </div> -->

      <!-- Tob Nav bar -->
      <?php show_top_bar($root); ?>

      <!-- Calendar -->
      <div class="calendar-wrap user-calendar <?php echo $relationship_type;?>">

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
          <div class="time-slot-wrap" data-hour="<?php echo $i; ?>" data-hour-type="AM" data-open-popup="<?php echo $time_slot_popup_to_open; ?>">
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
          <div class="time-slot-wrap" data-hour="<?php echo $i + 12; ?>" data-hour-type="PM" data-open-popup="<?php echo $time_slot_popup_to_open; ?>">
            <div class="time-text">
              <?php echo $i . ' PM'; ?>
            </div>
            <div class="time-slot">

            </div>
          </div>
        <?php endfor; ?>
      </div>


      </div>


      <!-- Bottom Nav Bar -->
      <?php show_bottom_bar($root); ?>





    </div>
  </body>
</html>
