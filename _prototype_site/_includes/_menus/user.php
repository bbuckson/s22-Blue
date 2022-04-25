<!-- user menu -->
<?php
  // Get user
  $user = get_user($_SESSION['user_id']);
?>
<div class="user-menu-wrap menu right-side bottom">
  <div class="menu-wrap-header">
    <img src="_pics/_users/<?php echo $user['image']; ?>" />
    <div class="username">
      <?php echo $user['username']; ?>
    </div>
  </div>
  <a href="<?php echo $root . 'index.php';?>"><div class="item">Home</div></a>
  <a href="<?php echo $root . 'calendar.php?uid=' . $_SESSION['user_id'];?>"><div class="item">My Calendar</div></a>
  <a href="<?php echo $root . '_php/form_actions/logout.php';?>"><div class="item">Logout</div></a>

</div>
