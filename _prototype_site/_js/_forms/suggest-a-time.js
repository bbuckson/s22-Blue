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
