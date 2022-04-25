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


  <?php require('_menus/friends.php'); ?>
  <?php require('_menus/user.php'); ?>



  <?php
    /*
     * If we're on the calendar page, we want to show the user's username and image
     */
    $message[0] = "Start messages";
    $current_page = basename($_SERVER['PHP_SELF']);

    if($current_page == "calendar.php") :
      $current_user = get_user($_GET['uid']);
  ?>

      <div class="user-info-wrap">
        <div class="img-wrap">
          <img src="_pics/_users/<?php echo $current_user['image']; ?>" />
        </div>
        <div class="username">
          @<?php echo $current_user['username']; ?>
        </div>
      </div>

  <?php endif;?>
</div>





<?php
  foreach ($message as $string) {
  echo '
<script>
  // Testing messages
  console.log("' . $string . '");

</script>';
}
?>


<?php require('_menus/notifications.php'); ?>
<?php require('_popups/include-popups.php'); ?>
