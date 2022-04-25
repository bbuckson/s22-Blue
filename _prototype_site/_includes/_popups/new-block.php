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
