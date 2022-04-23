<div class="bottom-bar">
  <?php
    //include($root . '_pics/_icons/friends.svg');
    //include($root . '_pics/_icons/add.svg');
    //include($root . '_pics/_icons/user.svg');
    $friends_icon = '_pics/_icons/friends.svg';
    $add_icon = '_pics/_icons/add.svg';
    $user_icon = '_pics/_icons/user.svg';
  ?>

  <img src="<?php echo $root . $friends_icon; ?>" />
  <img src="<?php echo $root . $add_icon; ?>" />
  <img class="user-icon" src="<?php echo $root . $user_icon; ?>" data-open-pane="user-menu-wrap" />


  <div class="user-menu-wrap">
    <a href="<?php echo $root . '_php/form_actions/logout.php';?>"><div class="item">Logout</div></a>
  </div>

</div>
