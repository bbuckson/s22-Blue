<?php
  require('../connect.php');

  $conn = db_connect();

  $username = $_POST['username'];
  $password = $_POST['pass'];

  $data = $conn->prepare('SELECT * FROM users WHERE username = :username');

  $data->bindParam(':username', $username);

  $data->execute();

  $arr = $data->fetch(PDO::FETCH_ASSOC);

  $arr_count = $data->rowCount();

  if($arr_count > 0 && password_verify($password, $arr['password']))
  {
    $username = $arr['username'];
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $arr['id'];
  }
  else
  {
    $_SESSION['error_msg'] = "Incorrect Username or Password";
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
  }

  header('Location: ../../index.php');
