<?php
  require('../connect.php');

  if($_POST['pass'] != $_POST['pass_2'])
  {
    $_SESSION['error_msg'] = "Passwords Must Match";

    header('Location: ../../register-login.php?p=register');
  }


  $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

  $username = $_POST['username'];
  $email = $_POST['email'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];

  $conn = db_connect();

  $data = $conn->prepare('INSERT INTO users (username, email, first_name, last_name, password)
                                     VALUES (:username, :email, :first_name, :last_name, :password)');

  $data->bindParam(':username', $username);
  $data->bindParam(':email', $email);
  $data->bindParam(':first_name', $first_name);
  $data->bindParam(':last_name', $last_name);
  $data->bindParam(':password', $password);


  if($data->execute())
  {
    //$_SESSION['username'] = $_POST['username'];
    $_SESSION['success_msg'] = "Nice";
    session_write_close();

    header('Location: ../../register-login.php?p=register_success');
  }
  else
  {
    var_dump($_POST);
  }


 ?>
