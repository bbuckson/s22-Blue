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
  suggestATimeWrap.find('.suggest-a-time-add-a-friend').val('');

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

   // Gather rest of data
   var startDate = suggestATimeWrap.find('input[name="date"]').val();
   var startTime = suggestATimeWrap.find('input[name="start_time"]').val();
   var endTime = suggestATimeWrap.find('input[name="end_time"]').val();

   $.ajax(
     {
       url: "_php/form_actions/suggest-a-time.php",
       type: 'POST',
       data: {
         'attendees': attendees,
         'start_date': startDate,
         'start_time': startTime,
         'end_time': endTime
       }
     }
   ).done(
     function(results){
       //console.log(results);
       suggestATimeWrap.find('.results-wrap > .content-wrap').html(results);
     }
   );


 });




 /*
  * When you click on friends free block
  */
  $('.results-wrap').on('click', '.button.time', function(){
    console.log('color');



    var startTime = $(this).attr('data-start_time').substring(0,8);
    var endTime = $(this).attr('data-end_time').substring(0,8);
    // // var hourType = $(this).attr('data-hour-type');
    var currDate = $(this).attr('data-curr_date');


    // Transfer attendees from suggest a time and
    var attendees = $('.overlay-wrap.suggest-a-time').find('.friends-coming').html();
    var checkboxes = $('.overlay-wrap.suggest-a-time').find('.hidden-checkboxes').html();

    $('.overlay-wrap.show').removeClass('show');

    var popupWrap = $('.overlay-wrap.new-event');


    $('.overlay-wrap.new-event').find('input[name="start_time"]').val(startTime);
    $('.overlay-wrap.new-event').find('input[name="end_time"]').val(endTime);
    $('.overlay-wrap.new-event').find('input[name="date"]').val(currDate);

    $('.overlay-wrap.new-event').find('.row.friends-coming').html(attendees);
    $('.overlay-wrap.new-event').find('.hidden-checkboxes').html(checkboxes);


    popupWrap.addClass('show');

  });
