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
      console.log(res);
      if(res == "success")
      {

      }
    }
  )
});
