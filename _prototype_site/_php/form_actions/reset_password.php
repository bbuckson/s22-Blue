<?php
  require('../connect.php');

  $pass1 = $_POST['pass'];
  $pass2 = $_POST['pass_2'];

  $user_id = $_POST['user_id'];

  if($pass1 != $pass2)
  {
    $_SESSION['error_msg'] = "Passwords must match";
    header('Location: ../../register-login.php?p=reset_password&user_id=' . $user_id);
  }

  $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

  $conn = db_connect();

  $data = $conn->prepare('UPDATE users SET password = :password WHERE id = :user_id');

  $data->bindParam(':password', $password);
  $data->bindParam(':user_id', $user_id);

  if($data->execute())
  {
    $_SESSION['success_msg'] = "Password has successfully been changed.";
    header('Location: ../../register-login.php');
  }

 ?>
