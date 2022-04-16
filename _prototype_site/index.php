<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Time</title>
    <?php require('_includes/scripts.php'); ?>
  </head>
  <body>

    <?php
    // If user is not logged in -> direct them to register-login page
    // Note: functions are located in _php/functions.php
    if(!is_logged_in())
    {
      header('Location: register-login.php');
    }
    ?>

    <h1>INDEX</h1>

  </body>
</html>
