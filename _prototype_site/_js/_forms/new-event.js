var newEventWrap = $('.overlay-wrap.new-event');

/*
 * Show suggested friends when typing
 */
$('.new-event-add-friends').on('input', function(){
  var val = $(this).val();

  newEventWrap.find('.search-friends-wrap').addClass('show');
  $.ajax(
    {
      url: "_php/functions/find_friend.php",
      type: "POST",
      data: {
        'val': val
      }
    }
  ).done(
    function(res)
    {
      newEventWrap.find('.search-friends-wrap').html(res);
    }
  )
});


/*
 * On Select friend
 */
newEventWrap.find('.search-friends-wrap').on('click', '.item', function(){
  var userId = $(this).attr('data-user-id');
  var userName = $(this).attr('data-username');
  var userImage = $(this).find('img').attr('src');

  // Reset
  newEventWrap.find('.search-friends-wrap').removeClass('show');
  newEventWrap.find('.search-friends-wrap').html();
  newEventWrap.find('.new-event-add-friends').val('');

  // Add checkbox for user selected
  newEventWrap.find('.hidden-checkboxes').append('<input type="checkbox" name="invitees[]" value="' + userId + '" checked="checked" />');

  // Add user to list of attendees
  newEventWrap.find('.friends-coming').append('<div class="item"><img src="' + userImage + '" /><div class="title">' + userName + '</div></div>');

});


/*
 * On Submit
 */
$('.button.submit[data-form="new-event"]').on('click', function(){
  var title = newEventWrap.find('[name="event_title"]').val();
  var desc = newEventWrap.find('[name="event_description"]').val();
  var startDate = newEventWrap.find('input[name="date"]').val();
  var startTime = newEventWrap.find('input[name="start_time"]').val();
  var endTime = newEventWrap.find('input[name="end_time"]').val();

  var attendees = new Array();
  newEventWrap.find("input:checked").each(function() {
     attendees.push($(this).val());
  });

  var errorMsg = "";
  if (title == null || title == "" || startDate == null || startDate == "" || startTime == null || startTime == "" || endTime == null || endTime == "")
  {
    errorMsg = "All fields are required.";
  }

  newEventWrap.find('p.error-msg').html(errorMsg);

  $.ajax(
    {
      url: "_php/form_actions/new_event.php",
      type: 'POST',
      data: {
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
      updatePersonalCalendar(this_users_id);
      $('.overlay-wrap.show').removeClass('show');
      // if(results == "nice"){
      //   $('.overlay-wrap.new-block').removeClass('show');
      //   updatePersonalCalendar(this_users_id);
      // }
      // else{
      // }
    }
  );


});
