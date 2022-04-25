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
// The id of the user whose calendar you are trying vie
var this_users_id = $('input[name="this_users_id"]').val();
// Your id
var my_user_id = $('input[name="my_user_id"]').val();

// Update Blocks on calendar initially
updatePersonalCalendar(this_users_id);

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

  $('.overlay-wrap.new-block').find('input[name="start_time"]').val(hour + ':00:00');
  $('.overlay-wrap.new-block').find('input[name="end_time"]').val(endHour + ':00:00');
  $('.overlay-wrap.new-block').find('input[name="date"]').val(currDate);

});



/*
 * Open edit popup when editable block is clicked
 */
$('.blocks-wrap').on('click', '.block', function(){
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



      // Create block
      blocksWrap.find('.block-column').append('<div class="block ' + blockType + '" data-id="' + block['id'] + '" data-edit="' + canEdit + '" data-start_date="' + startDate + '" data-start_time="' + startTime + '" data-end_time="' + endTime + '" data-block_type="' + blockType + '"><div class="title">' + blockMsg + '</div><div class="times">' + fullStartTime + ' - ' + fullEndTime + '</div></div>');

      // Postion the block based on time
      yPos = (startHour - 1) * timeslotHeight + (parseInt(startMinutes) / 60 * timeslotHeight);

      // Calculate height based on length of block
      var diff = ( new Date("1970-1-1 " + endTime) - new Date("1970-1-1 " + startTime) ) / 1000 / 60 / 60;
      blockHeight = diff * timeslotHeight;

      $('.block[data-id="' + id + '"]').css({"top": yPos + "px", "height": blockHeight + "px"});

    });

  });


}
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
$('.close-popup').on('click', function(){
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