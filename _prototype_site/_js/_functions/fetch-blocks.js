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
  // ).done(
  //   function(results){
  //     $('#test-area').html(results);
  //     console.log("HMM" + results);
  //     //res = results;
  //     //return results['block_type'];
  //
  //     $.each(results,function (i,item) {
  //
  //        console.log(item.start_time);
  //     });
  //   }
  // );
}
