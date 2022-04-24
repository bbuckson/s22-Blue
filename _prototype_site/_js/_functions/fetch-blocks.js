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
