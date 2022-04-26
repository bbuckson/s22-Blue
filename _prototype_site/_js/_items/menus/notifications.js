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
      console.log(res);
      if(res == "Event request removed.." || res == "Event has been added to your calendar!")
      {
        itemWrap.html('<div class="content-wrap">' + res + '</div>');
        itemWrap.delay(1000).fadeOut(500);
      }

      updatePersonalCalendar(this_users_id);
    }
  );

});
