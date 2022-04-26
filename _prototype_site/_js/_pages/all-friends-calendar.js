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
       //console.log(results);
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
         yPos = (startHour - 1) * timeslotHeight + (parseInt(startMinutes) / 60 * timeslotHeight);

         // Calculate height based on length of block
         var diff = ( new Date("1970-1-1 " + endTime) - new Date("1970-1-1 " + startTime) ) / 1000 / 60 / 60;
         blockHeight = diff * timeslotHeight;


         $(this).css({"top": yPos + "px", "height": blockHeight + "px"});

       });
     }
   )

  // /*
  //  * Show event blocks
  //  */
  //  $.ajax(
  //    {
  //      url: "_php/functions/show_event_block.php",
  //      type: 'POST',
  //      data: {
  //        'event_id': block['event_id'],
  //        'block_id': block['id'],
  //        'user_id': this_users_id,
  //        'full_start_time': fullStartTime,
  //        'full_end_time': fullEndTime,
  //        'y_pos': yPos,
  //        'block_height': blockHeight
  //      }
  //    }
  //  ).done(
  //    function(results){
  //      blocksWrap.find('.block-column').append(results);
  //      $('.block[data-id="' + id + '"]').css({"top": yPos + "px", "height": blockHeight + "px"});
  //    }
  //  )

});
