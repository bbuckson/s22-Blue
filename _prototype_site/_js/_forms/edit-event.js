$('.calendar-wrap').on('click', '.block.event[data-edit="true"]', function(){
  var popupWrap = $('.overlay-wrap.edit-event');

  var eventId = $(this).attr('data-event-id');

  $.ajax(
    {
      url: "_php/functions/show_edit_event_contents.php",
      type: "POST",
      data: {
        'event_id': eventId
      }
    }
  ).done(
    function(res)
    {
      popupWrap.find('.edit-event-wrap').html(res);
      popupWrap.addClass('show');
    }
  )

});



/*
 * On Submit
 */
$('.edit-event-wrap').on('click', '.button.submit[data-form="edit-event"]', function(){

  var editEventWrap = $('.edit-event-wrap');


  var eventId = editEventWrap.find('[name="event-id"]').val();

  var title = editEventWrap.find('[name="event_title"]').val();
  var desc = editEventWrap.find('[name="event_description"]').val();
  var startDate = editEventWrap.find('input[name="date"]').val();
  var startTime = editEventWrap.find('input[name="start_time"]').val();
  var endTime = editEventWrap.find('input[name="end_time"]').val();

  var attendees = new Array();
  editEventWrap.find("input:checked").each(function() {
     attendees.push($(this).val());
  });

  var errorMsg = "";
  if (title == null || title == "" || startDate == null || startDate == "" || startTime == null || startTime == "" || endTime == null || endTime == "")
  {
    errorMsg = "All fields are required.";
    editEventWrap.find('p.error-msg').html(errorMsg);
    return 0;
  }



  $.ajax(
    {
      url: "_php/form_actions/edit_event.php",
      type: 'POST',
      data: {
        'event_id': eventId,
        'event_title': title,
        'event_description': desc,
        'start_time': startTime,
        'end_time': endTime,
        'start_date': startDate,
        'attendees': attendees
      }
    }
  ).done(
    function(results){
      console.log(results);
      updatePersonalCalendar(this_users_id);
      //$('.overlay-wrap.show').removeClass('show');

    }
  );


});



/*
 * On Select friend
 */
$('.edit-event-wrap').on('click', '.search-friends-wrap > .item', function(){
  var userId = $(this).attr('data-user-id');
  var userName = $(this).attr('data-username');
  var userImage = $(this).find('img').attr('src');

  // Reset
  $('.edit-event-wrap').find('.search-friends-wrap').removeClass('show');
  $('.edit-event-wrap').find('.search-friends-wrap').html();
  $('.edit-event-wrap').find('.new-event-add-friends').val('');

  // Add checkbox for user selected
  $('.edit-event-wrap').find('.hidden-checkboxes').append('<input type="checkbox" name="invitees[]" value="' + userId + '" checked="checked" />');

  // Add user to list of attendees
  $('.edit-event-wrap').find('.friends-coming').append('<div class="item" data-accepted="0" data-user-id="' + userId + '"><img src="' + userImage + '" /><div class="title">' + userName + '</div></div>');

});
