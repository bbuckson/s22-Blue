<?php
  /*
   * Gather information for the form
   */
   require('../functions.php');

   $event_id = $_POST['event_id'];

   $event = get_event($event_id);

   $users_in_event = get_all_users_in_event($event_id);


 ?>


<h3>Edit Event</h3>
<p class="error-msg">

</p>
<input type="hidden" name="event-id" value="<?php echo $event_id; ?>" />

<div class="row">
  <input type="text" name="event_title" placeholder="Title" value="<?php echo $event['title']; ?>" required />
</div>

<div class="row">
  <textarea name="event_description" placeholder="Add a description..." ><?php echo $event['description']; ?></textarea>
</div>


<div class="row">
  <span>Date</span>
  <input type="date" name="date" value="<?php echo $event['start_date'];?>" required />
</div>

<div class="row">
  <span>Start Time</span>
  <input type="time" name="start_time" value="<?php echo $event['start_time'];?>" required />
</div>

<div class="row">
  <span>End Time</span>
  <input type="time" name="end_time" value="<?php echo $event['end_time'];?>" required />
</div>

<div class="single-label">
  Who's Coming?
</div>
<div class="row add-friends-wrap">

  <div class="search-friends-wrap">
  </div>
  <input class="new-event-add-friends" type="text" name="title" placeholder="Add Friends..." required />

</div>

<!-- list of friends coming -->
<div class="row friends-coming">
  <?php
  if(isset($users_in_event) && sizeof($users_in_event) > 0 ):
    // Go through each user and add them to list
    foreach ($users_in_event as $attendee) :
      $user = get_user($attendee['receiving_user_id']);
  ?>

    <div class="item" data-accepted="<?php echo $attendee['accepted'];?>" data-user-id="<?php echo $user['id']; ?>">
      <img src="_pics/_users/<?php echo $user['image']; ?>" />
      <div class="title">
        <?php echo $user['username']; ?>
      </div>
    </div>
  <?php
    endforeach;
  endif;
  ?>
</div>

<!-- Hold checkbox of users that are invited -->
<div class="hidden-checkboxes">


<?php
if(isset($users_in_event) && sizeof($users_in_event) > 0 ):
  // Go through each user and add them to list
  foreach ($users_in_event as $attendee) :
    $user = get_user($attendee['receiving_user_id']);
?>

  <input type="checkbox" name="invitees[]" value="<?php echo $user['id']; ?>" checked="checked" />
<?php
  endforeach;
endif;
?>

</div>

<div class="row">
  <div class="button submit" data-form="edit-event">
    Update Event3.
  </div>
</div>
<div class="close-popup">
  Cancel
</div>
