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
