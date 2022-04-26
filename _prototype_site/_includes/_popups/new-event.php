<!-- Popup to set block of time -->
<div class="overlay-wrap new-event">
  <div class="set-event-wrap">
    <h3>New Event</h3>
    <p class="error-msg">

    </p>
    <!-- <div class="single-label">
      Block Type
    </div>

    <div class="row">
      <div class="button free block-type" data-value="free">
        Free
      </div>
      <div class="button blocked block-type" data-value="blocked">
        Blocked
      </div>
    </div> -->


    <div class="row">
      <input type="text" name="event_title" placeholder="Title" required />
    </div>

    <div class="row">
      <textarea name="event_description" placeholder="Add a description..." ></textarea>
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
      <div class="item" data-accepted="1">
        <img src="_pics/_users/<?php echo $current_user['image']; ?>" />
        <div class="title">
          <?php echo $current_user['username']; ?>
        </div>
      </div>
    </div>

    <!-- Hold checkbox of users that are invited -->
    <div class="hidden-checkboxes">
      <input type="checkbox" name="invitees[]" value="<?php echo $current_user['id']; ?>" checked="checked" />
    </div>


    <div class="row">
      <div class="button submit" data-form="new-event">
        Send Invite
      </div>
    </div>
    <div class="close-popup">
      Cancel
    </div>
  </div>
</div>
