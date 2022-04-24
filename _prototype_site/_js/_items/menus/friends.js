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
        console.log(res);
        friendsMenu.find('.friends-list-wrap').html(res);
      }
    );

  }
});
