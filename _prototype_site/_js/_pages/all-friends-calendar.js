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
