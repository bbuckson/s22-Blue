<?php
  unset($_SESSION['username']);
  unset($_SESSION['user_id']);
  header('Location: ../../register-login.php');
 ?>
