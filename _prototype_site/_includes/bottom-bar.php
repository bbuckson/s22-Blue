<div class="bottom-bar">
  <?php
    //include($root . '_pics/_icons/friends.svg');
    //include($root . '_pics/_icons/add.svg');
    //include($root . '_pics/_icons/user.svg');
    $friends_icon = '_pics/_icons/friends.svg';
    $add_icon = '_pics/_icons/add.svg';
    $user_icon = '_pics/_icons/user.svg';
  ?>

  <img src="<?php echo $root . $friends_icon; ?>" data-open-pane="friends-menu-wrap" />
  <img src="<?php echo $root . $add_icon; ?>" />
  <img class="user-icon" src="<?php echo $root . $user_icon; ?>" data-open-pane="user-menu-wrap" />

  <!-- user menu -->
  <div class="user-menu-wrap menu right-side bottom">
    <div class="menu-wrap-header"></div>
    <a href="<?php echo $root . '_php/form_actions/logout.php';?>"><div class="item">Logout</div></a>
  </div>

  <!-- Friends menu -->
  <div class="friends-menu-wrap menu left-side bottom">
    <div class="menu-wrap-header">Friends</div>

    <!-- Show friends (done dynamically)-->
    <div class="friends-list-wrap">
    </div>

    <a href="#" class="add-friend-button" data-open-popup="add-friend-popup"><div class="item add-friend-button">+ Add Friend</div></a>

  </div>




</div>






<?php require('_menus/notifications.php'); ?>
<?php require('_popups/include-popups.php'); ?>
