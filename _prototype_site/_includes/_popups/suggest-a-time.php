<!-- Popup to set block of time -->
<div class="overlay-wrap suggest-a-time">
  <div class="suggest-a-time-wrap">
    <h3>Suggest a Time</h3>
    <p class="error-msg">

    </p>

    <div class="row">
      <span>Date</span>
      <input type="date" name="date" required />
    </div>

    <div class="row">
      <span>Start Time</span>
      <input type="time" name="start_time" />
    </div>

    <div class="row">
      <span>End Time</span>
      <input type="time" name="end_time" />
    </div>

    <div class="single-label">
      Who should be there?
    </div>
    <div class="row add-friends-wrap">

      <div class="search-friends-wrap">
      </div>
      <input class="suggest-a-time-add-a-friend" type="text" name="title" placeholder="Add Friends..." required />

    </div>

    <!-- list of friends coming -->
    <div class="row friends-coming">

    </div>

    <!-- Hold checkbox of users that are invited -->
    <div class="hidden-checkboxes">

    </div>


    <!-- Results -->
    <div class="results-wrap">
      <div class="single-label">
        Results
      </div>
      <div class="content-wrap">

      </div>
    </div>



    <div class="row">
      <div class="button submit" data-form="suggest-a-time">
        Find A Time
      </div>
    </div>
    <div class="close-popup">
      Cancel
    </div>
  </div>
</div>
