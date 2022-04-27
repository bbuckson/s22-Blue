$(document).ready(function(){  // The id of the user whose calendar you are trying viee
if($('input[name="this_users_id"]').length)
  var this_users_id = $('input[name="this_users_id"]').val();

// Your id
if($('input[name="my_user_id"]').length)
  var my_user_id = $('input[name="my_user_id"]').val();
var setBlockForm = $('.set-block-wrap');

$('.block-type.button').on('click', function(){
  $('.block-type.button.active').removeClass('active');
  $(this).addClass('active');
});


$('.submit[data-form="new-block"]').on('click', function(){
  var blockType = setBlockForm.find('.button.block-type.active').attr('data-value');
  var startDate = setBlockForm.find('input[name="date"]').val();
  var startTime = setBlockForm.find('input[name="start_time"]').val();
  var endTime = setBlockForm.find('input[name="end_time"]').val();


  var errorMsg = "";

  if (blockType == null || blockType == "" || startDate == null || startDate == "" || startTime == null || startTime == "" || endTime == null || endTime == "")
  {
    errorMsg = "All fields are required.";
  }

  setBlockForm.find('p.error-msg').html(errorMsg);

  $.ajax(
    {
      url: "_php/form_actions/new_block.php",
      type: 'POST',
      data: {
        'block_type': blockType,
        'start_time': startTime,
        'end_time': endTime,
        'start_date': startDate
      }
    }
  ).done(
    function(results){
      if(results == "nice"){
        $('.overlay-wrap.new-block').removeClass('show');
        updatePersonalCalendar(this_users_id);
      }
      else{
      }
    }
  );

});
var editBlockForm = $('.edit-block-wrap');

$('.submit[data-form="edit-block"]').on('click', function(){
  var blockType = editBlockForm.find('.button.block-type.active').attr('data-value');
  var startDate = editBlockForm.find('input[name="date"]').val();
  var blockId = editBlockForm.find('input[name="block_id"]').val();
  var startTime = editBlockForm.find('input[name="start_time"]').val();
  var endTime = editBlockForm.find('input[name="end_time"]').val();


  var errorMsg = "";

  if (blockType == null || blockType == "" || startDate == null || startDate == "" || startTime == null || startTime == "" || endTime == null || endTime == "")
  {
    errorMsg = "All fields are required.";
  }

  setBlockForm.find('p.error-msg').html(errorMsg);

  $.ajax(
    {
      url: "_php/form_actions/edit_block.php",
      type: 'POST',
      data: {
        'block_type': blockType,
        'start_time': startTime,
        'end_time': endTime,
        'start_date': startDate,
        'block_id': blockId
      }
    }
  ).done(
    function(results){
      if(results == "nice"){
        $('.overlay-wrap.edit-block').removeClass('show');
        updatePersonalCalendar(this_users_id);
      }
      else{
      }
    }
  );

});



/*
 * Delete Block
 */
$('.button.delete[data-form="edit-block"]').on('click', function(){
  var blockId = $(this).closest('.edit-block-wrap').find('input[name="block_id"]').val();

  $.ajax(
    {
      url: "_php/form_actions/delete_block.php",
      type: 'POST',
      data: {
        'block_id': blockId
      }
    }
  ).done(
    function(results){
      if(results == "nice"){
        $('.overlay-wrap.edit-block').removeClass('show');
        updatePersonalCalendar(this_users_id);
      }

    }
  );
});
var friendSearchInput = $('input[name="find_friend"]');
var friendResultsWrap = $('.add-friend-wrap .friend-results');

friendSearchInput.on('input', function(){
  var val = $(this).val();

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
      friendResultsWrap.html(res);
    }
  )
});


// Select friend
$('.friend-results').on('click', '.item', function(){
  $('.friend-results .item.selected').removeClass('selected');
  $(this).addClass('selected');
});


// Send friend request
$('.submit[data-form="add-friend"]').on('click', function(){
  var userId = $('.friend-results .item.selected').attr('data-user-id');
  $.ajax({
    url: "_php/form_actions/send_friend_requests.php",
    type: "POST",
    data: {
      'user_id': userId
    }
  }).done(
    function(res)
    {
      if(res == "success")
      {
        $('.overlay-wrap.show').removeClass('show');
      }
    }
  )
});
var newEventWrap = $('.overlay-wrap.new-event');

/*
 * Show suggested friends when typing
 */
$('.overlay-wrap').on('input', '.new-event-add-friends',function(){
  var val = $(this).val();
  var wrap = $(this).closest('.overlay-wrap');

  wrap.find('.search-friends-wrap').addClass('show');
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
      wrap.find('.search-friends-wrap').html(res);
    }
  )
});


/*
 * Close suggested friends
 */
 $('.overlay-wrap').on('click', ' *:not(.search-friends-wrap)', function(event){
   event.stopPropagation();
   $('.search-friends-wrap.show').removeClass('show');
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
  newEventWrap.find('.friends-coming').append('<div class="item" data-accepted="0" data-user-id="' + userId + '"><img src="' + userImage + '" /><div class="title">' + userName + '</div></div>');

});

/*
 * Remove friend from attendee list
 */
 $('.overlay-wrap').on('click', '.friends-coming > .item, .friends-coming > .item > *', function(event){
   event.stopPropagation();

   // If we click on children, we need to set item
   var itemWrap = $(this);
   if(!$(this).hasClass('item'))
    itemWrap = $(this).closest('.item');

   // If this user isn't unchecked
   if(!itemWrap.hasClass('removed'))
   {
     itemWrap.addClass('removed');
     itemWrap.closest('.overlay-wrap').find('input[value="' + itemWrap.attr('data-user-id') + '"]').prop('checked', false);
   }
   else
   {
     itemWrap.removeClass('removed');
     itemWrap.closest('.overlay-wrap').find('input[value="' + itemWrap.attr('data-user-id') + '"]').prop('checked', true);

   }
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
    newEventWrap.find('p.error-msg').html(errorMsg);
    return 0;
  }



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
      updatePersonalCalendar(this_users_id);
      $('.overlay-wrap.show').removeClass('show');

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
var suggestATimeWrap = $('.suggest-a-time-wrap');

/*
 * Show suggested friends when typing
 */
 console.log('sweet');
suggestATimeWrap.on('input', '.suggest-a-time-add-a-friend',function(){
  var val = $(this).val();
  var wrap = $(this).closest('.overlay-wrap');
  console.log('cool');

  wrap.find('.search-friends-wrap').addClass('show');
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
      wrap.find('.search-friends-wrap').html(res);
    }
  )
});



/*
 * On Select friend
 */
suggestATimeWrap.on('click', '.search-friends-wrap > .item', function(){
  var userId = $(this).attr('data-user-id');
  var userName = $(this).attr('data-username');
  var userImage = $(this).find('img').attr('src');

  // Reset
  suggestATimeWrap.find('.search-friends-wrap').removeClass('show');
  suggestATimeWrap.find('.search-friends-wrap').html();
  suggestATimeWrap.find('.new-event-add-friends').val('');

  // Add checkbox for user selected
  suggestATimeWrap.find('.hidden-checkboxes').append('<input type="checkbox" name="invitees[]" value="' + userId + '" checked="checked" />');

  // Add user to list of attendees
  suggestATimeWrap.find('.friends-coming').append('<div class="item" data-accepted="0" data-user-id="' + userId + '"><img src="' + userImage + '" /><div class="title">' + userName + '</div></div>');

});


/*
 * On Submit
 */
 $('.button.submit[data-form="suggest-a-time"]').on('click', function(){

   // Gather attendees
   var attendees = new Array();
   suggestATimeWrap.find("input:checked").each(function() {
      attendees.push($(this).val());
   });

   // Error message
   suggestATimeWrap.find('.error-msg').html('');
   if(attendees.length < 1 )
   {
     suggestATimeWrap.find('.error-msg').html('Look for some friends to invite!');
   }

   $.ajax(
     {
       url: "_php/form_actions/suggest-a-time.php",
       type: 'POST',
       data: {
         'attendees': attendees
       }
     }
   ).done(
     function(results){
       console.log(results);
     }
   );


 });
// The id of the user whose calendar you are trying vie
var this_users_id = $('input[name="this_users_id"]').val();
// Your id
var my_user_id = $('input[name="my_user_id"]').val();
var relationship_type = $('input[name="relationship"]').val();

// Update Blocks on calendar initially
updatePersonalCalendar(this_users_id);


$('.time-slot-wrap').on('click', function(e){
  e.stopPropagation();
  // If we're on the home page make the time slots do nothing
  if($(this).closest('.calendar-wrap').hasClass('all-friends'))
  {
    return 0;
  }

  var hour = $(this).attr('data-hour');
  var hourType = $(this).attr('data-hour-type');
  var currDate = $('input[name="curr_date"]').val();


  hour = parseInt(hour);
  endHour = hour + 1;

  // the inputs takes 24 hour time so we need to add 12 if it's PM
  if (hourType == "PM")
  {
    hourType += 12;
  }

  // Convert back to string so we can add a leading zero if it's one digit
  hour = hour.toString();
  endHour = endHour.toString();

  if(hour.length == 1)
  {
    hour = "0" + hour;
  }
  if(endHour.length == 1)
  {
    endHour = "0" + endHour;
  }

  $('.overlay-wrap.new-block').find('input[name="start_time"]').val(hour + ':00:00');
  $('.overlay-wrap.new-block').find('input[name="end_time"]').val(endHour + ':00:00');
  $('.overlay-wrap.new-block').find('input[name="date"]').val(currDate);

});



/*
 * Open edit popup when editable block is clicked
 */
$('.blocks-wrap').on('click', '.block:not(.event)', function(){
  // If you can't edit -> Just exit
  if($(this).attr('data-edit') == "false")
  {
    return 0;
  }
  var startTime = $(this).attr('data-start_time').substring(0,8);
  var endTime = $(this).attr('data-end_time').substring(0,8);
  var blockType = $(this).attr('data-block_type');
  var startDate = $(this).attr('data-start_date');
  var blockId = $(this).attr('data-id');

  $('.overlay-wrap.edit-block').addClass('show');

  $('.overlay-wrap.edit-block').find('input[name="block_id"]').val(blockId);
  $('.overlay-wrap.edit-block').find('input[name="start_time"]').val(startTime);
  $('.overlay-wrap.edit-block').find('input[name="end_time"]').val(endTime);
  $('.overlay-wrap.edit-block').find('input[name="date"]').val(startDate);
  $('.overlay-wrap.edit-block').find('.button.block-type.' + blockType).addClass('active');

  // $('.overlay-wrap.edit-block').find('input[name="end_time"]').val(endHour + ':00:00');
  // $('.overlay-wrap.edit-block').find('input[name="date"]').val(currDate);
});



/*
 * Show the blocks on the personal calendar
 */
function updatePersonalCalendar(user_id)
{

  var blocksWrap = $('.blocks-wrap');

  var timeslotHeight = 56;

  // Define variables
  var startTime, endTime, id;
  var hour, minutes;
  var blockMsg;
  var yPos = 0;
  var blockHeight = 0;

  // Need to do this because it's the only way I can figure out how to use the data
  var blockList = fetchBlocks(user_id).done(function(response){
    // Clear preious blocks to add new ones
    blocksWrap.find('.block-column').html('');

    // Go through each block
    $.each(response, function(i, block){

      id              = block['id'];

      startTime       = block['start_time'];
      startHour       = parseInt(startTime.substring(0,2));
      var twelveHourFormatStartTime = (startHour > 12) ? startHour - 12 : startHour;
      startMinutes    = startTime.substring(3,5);
      blockType       = block['block_type'];
      fullStartTime   = twelveHourFormatStartTime + ":" + startMinutes;

      endTime         = block['end_time'];
      endHour         = parseInt(endTime.substring(0,2));
      var twelveHourFormatEndTime = (endHour > 12) ? endHour - 12 : endHour;
      endMinutes      = endTime.substring(3,5);
      blockType       = block['block_type'];
      fullEndTime     = twelveHourFormatEndTime + ":" + endMinutes;

      startDate       = block['start_date'];

      // Set block Message
      blockMsg = (blockType == 'blocked') ? "Blocked" : "Free";

      // Check if user owns this block
      var canEdit = (this_users_id == my_user_id) ? "true" : "false";

      // Postion the block based on time
      yPos = (startHour - 1) * timeslotHeight + (parseInt(startMinutes) / 60 * timeslotHeight);

      // Calculate height based on length of block
      var diff = ( new Date("1970-1-1 " + endTime) - new Date("1970-1-1 " + startTime) ) / 1000 / 60 / 60;
      blockHeight = diff * timeslotHeight;

      // Create Free or Blocked block
      if(blockType == 'blocked' || blockType == 'free')
      {
        blocksWrap.find('.block-column').append('<div class="block ' + blockType + '" data-id="' + block['id'] + '" data-edit="' + canEdit + '" data-start_date="' + startDate + '" data-start_time="' + startTime + '" data-end_time="' + endTime + '" data-block_type="' + blockType + '"><div class="title">' + blockMsg + '</div><div class="times">' + fullStartTime + ' - ' + fullEndTime + '</div></div>');


        $('.block[data-id="' + id + '"]').css({"top": yPos + "px", "height": blockHeight + "px"});
      }
      if(blockType == 'event')
      {

        $.ajax(
          {
            url: "_php/functions/show_event_block.php",
            type: 'POST',
            data: {
              'event_id': block['event_id'],
              'block_id': block['id'],
              'user_id': this_users_id,
              'full_start_time': fullStartTime,
              'full_end_time': fullEndTime,
              'y_pos': yPos,
              'block_height': blockHeight
            }
          }
        ).done(
          function(results){
            blocksWrap.find('.block-column').append(results);
            $('.block[data-id="' + id + '"]').css({"top": yPos + "px", "height": blockHeight + "px"});
          }
        )
      }




    });

  });


}
if(relationship_type == "friends")
{
  /*
   * When you click on friend's time slot
   */
  $('.time-slot-wrap').on('click', function(){
    var hour = $(this).attr('data-hour');
    var hourType = $(this).attr('data-hour-type');
    var currDate = $('input[name="curr_date"]').val();


    hour = parseInt(hour);
    endHour = hour + 1;

    // the inputs takes 24 hour time so we need to add 12 if it's PM
    if (hourType == "PM")
    {
      hourType += 12;
    }

    // Convert back to string so we can add a leading zero if it's one digit
    hour = hour.toString();
    endHour = endHour.toString();

    if(hour.length == 1)
    {
      hour = "0" + hour;
    }
    if(endHour.length == 1)
    {
      endHour = "0" + endHour;
    }

    $('.overlay-wrap.new-event').find('input[name="start_time"]').val(hour + ':00:00');
    $('.overlay-wrap.new-event').find('input[name="end_time"]').val(endHour + ':00:00');
    $('.overlay-wrap.new-event').find('input[name="date"]').val(currDate);

  });

  /*
   * When you click on friends free block
   */
   $('.user-calendar.friends').on('click', '.block.free', function(){

     var startTime = $(this).attr('data-start_time').substring(0,8);
     var endTime = $(this).attr('data-end_time').substring(0,8);
     // var hourType = $(this).attr('data-hour-type');
     var currDate = $('input[name="curr_date"]').val();

     var popupWrap = $('.overlay-wrap.new-event');


     $('.overlay-wrap.new-event').find('input[name="start_time"]').val(startTime);
     $('.overlay-wrap.new-event').find('input[name="end_time"]').val(endTime);
     $('.overlay-wrap.new-event').find('input[name="date"]').val(currDate);

     popupWrap.addClass('show');

   });
}
var allFriendsWrap = $('.calendar-wrap.all-friends');

/*
 * Go through each friend column and add blocks
 */

// columnCount is to help us move colums over
var columnCount = 0;

allFriendsWrap.find('.block-column').each(function(){
  var friendId = $(this).find('input[name="friend_id"]').val();
  console.log(friendId);

  var columnWrap = $(this);

  // Move columns to the left
  // columnWrap.css('transform', 'translateX(-' + columnCount * 75 + 'px)');
  // columnCount++;

  /*
   * Show free blocks
   */
   $.ajax(
     {
       url: "_php/functions/show_free_and_blocked_blocks.php",
       type: 'POST',
       data: {
         'user_id': friendId,
       }
     }
   ).done(
     function(results){
       columnWrap.append(results);



       // Style Blocks
       columnWrap.find('.block').each(function(){

         var timeslotHeight = 56;

         startTime       = $(this).attr('data-start_time');
         startHour       = parseInt(startTime.substring(0,2));
         startMinutes    = startTime.substring(3,5);

         endTime       = $(this).attr('data-end_time');
         endHour       = parseInt(startTime.substring(0,2));
         endMinutes    = startTime.substring(3,5);

         // Postion the block based on time
         yPos = (startHour - 1) * timeslotHeight + (parseInt(startMinutes) / 60 * timeslotHeight) + 19;

         // Calculate height based on length of block
         var diff = ( new Date("1970-1-1 " + endTime) - new Date("1970-1-1 " + startTime) ) / 1000 / 60 / 60;
         blockHeight = diff * timeslotHeight;


         $(this).css({"top": yPos + "px", "height": blockHeight + "px"});

       });
     }
   )


});



/*
 * Position user image wraps at the top
 */
$('.all-content-wrap.home').find('.user-image-wrap').each(function(){
  var count = $(this).attr('data-count');
  $(this).css('left', count * 180 + "px");
});



/*
 * Have the time slots scroll with the page
 */
 var timeSlotsWrap = $('.all-content-wrap.home').find('.time-slots-wrap');
$('.all-content-wrap.home').find('.calendar-wrap').on('scroll', function(){
  var scrollLeft = $(this).scrollLeft();
  // timeSlotsWrap.css('transform', 'translateX(' + scrollLeft + 'px)');
});
var notificationsMenu = $('.notifications-menu-wrap');

/*
 * When menu is opened
 */
notificationsMenu.on('classChange', function(){

  if( $(this).hasClass('open') )
  {

    // Populate notifications
    $.ajax({
      url: "_php/menus/retrieve-notifications.php",
      type: "POST",
      data: {
      }
    }).done(
      function(res)
      {
        notificationsMenu.find('.items-wrap').html(res);
      }
    );


    // Remove Seen
    $.ajax({
      url: "_php/menus/set-seen-notifications.php",
      type: "POST",
      data: {
      }
    }).done(
      function(res)
      {
      }
    );

  }
});



/*
 * When friend request is accepted or rejected
 */
notificationsMenu.on('click', '[data-type="friend_request"] .button', function(){
  var itemWrap = $(this).closest('.item');
  var value = $(this).attr('data-value');
  var senderId = $(this).closest('.item').attr('data-sender');
  var notificationId = $(this).closest('.item').attr('data-notification-id');

  // Handle accept/reject
  $.ajax({
    url: "_php/form_actions/accept-reject-friend-request.php",
    type: "POST",
    data: {
      'sender_id': senderId,
      'value': value,
      'notification_id': notificationId
    }
  }).done(
    function(res)
    {
      itemWrap.html('<div class="content-wrap">' + res + '</div>');
      itemWrap.delay(1000).fadeOut(500);
    }
  );

});







/*
 * When Event request is accepted or rejected
 */
notificationsMenu.on('click', '[data-type="event_request"] .button', function(){
  var itemWrap = $(this).closest('.item');
  var value = $(this).attr('data-value');
  // var senderId = $(this).closest('.item').attr('data-sender');
  var notificationId = $(this).closest('.item').attr('data-notification-id');
  var usersInEventId = $(this).closest('.item').attr('data-users-in-event-id');
  var eventId = $(this).closest('.item').attr('data-event-id');

  // Handle accept/reject
  $.ajax({
    url: "_php/form_actions/accept-reject-event-request.php",
    type: "POST",
    data: {
      'notification_id': notificationId,
      'users_in_event_id': usersInEventId,
      'event_id': eventId,
      'value': value,
    }
  }).done(
    function(res)
    {
      if(res == "Event request removed.." || res == "Event has been added to your calendar!")
      {
        itemWrap.html('<div class="content-wrap">' + res + '</div>');
        itemWrap.delay(1000).fadeOut(500);
      }

      updatePersonalCalendar(this_users_id);
    }
  );

});
var friendsMenu = $('.friends-menu-wrap');

/*
 * When menu is opened
 */
friendsMenu.on('classChange', function(){
  if( $(this).hasClass('open') )
  {

    // Populate friends
    $.ajax({
      url: "_php/menus/retrieve-friends-list.php",
      type: "POST",
      data: {
      }
    }).done(
      function(res)
      {
        friendsMenu.find('.friends-list-wrap').html(res);
      }
    );

  }
});
// Open popup
$('*[data-open-popup]').on('click', function(){
  // open popup
  $('.overlay-wrap.' + $(this).attr('data-open-popup')).addClass('show');

  // Close any open menus
  $('.menu.open').removeClass('open');
});

// Close popup
$('.overlay-wrap').on('click', '.close-popup', function(){
  $('.overlay-wrap.show').removeClass('show');
});
/*
 * This handles opening things when any item with 'data-open-pane' attribute is clicked on
 *
 * The value of the attribute is the class of the item it's supposed to open.
 *
 * It toggles class 'open' on it
 *
 */

$('*[data-open-pane]').on('click', function(){

  if($('.' + $(this).attr('data-open-pane')).hasClass('open'))
  {
    $('.' + $(this).attr('data-open-pane')).removeClass('open');
  }
  else
  {
    $('.menu.open').removeClass('open');
    $('.' + $(this).attr('data-open-pane')).addClass('open').trigger('classChange');;
  }

});
/*
 * Returns an array of Blocks
 *
 * @Param user_id = the id of the user that owns the calendar you want to view
 */
function fetchBlocks(user_id) {
  // var res;
  return $.ajax(
    {
      url: "_php/functions/get_calendar_blocks.php",
      type: 'POST',
      dataType: 'json',
      cache: false,
      data: {
        'user_id': user_id
      }
    }
  );

}
});                                                                                