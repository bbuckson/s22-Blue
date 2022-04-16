<?php
  require('../connect.php');

  $conn = db_connect();

  $email = $_POST['email'];

  $data = $conn->prepare('SELECT * FROM users WHERE email = :email');

  $data->bindParam(':email', $email);

  $data->execute();

  $arr = $data->fetch(PDO::FETCH_ASSOC);

  $arr_count = $data->rowCount();

  // If email isn't found in database
  if($arr_count < 1)
  {
    $_SESSION['error_msg'] = "We don't have an account associated with that e-mail!";
    header('Location: ../../register-login.php?p=forgot_password');
  }
  // If email is gound
  else
  {
     $to = $email;
     $subject = "Free Time - Reset Password";

     $message = "<b>Reset Password</b>";
     $message .= "<a href=\"\">Click here to reset password</a>";

     $header = "From:matt@matthaslem.tech \r\n";
     $header .= "MIME-Version: 1.0\r\n";
     $header .= "Content-type: text/html\r\n";

     $retval = mail ($to,$subject,$message,$header);

     if( $retval == true ) {
        echo "Message sent successfully...";
        header('Location: ../../register-login.php?p=reset_password&user_id=' . $arr['id']);

     }else {
        echo "Message could not be sent...";
     }
  }


 ?>
