<?php require("_php/functions.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Time</title>
    <?php require('_includes/scripts.php'); ?>
  </head>
  <body id="register-login">

    <?php
      /*
       * Set the page type
       */
       if(isset($_GET['p']))
       {
         $page_type = $_GET['p'];
       }
       else
       {
         $page_type = "login";
       }

       /*
        * Set error/success messages if available and reset the session
        */
        $error_msg = "";
        $success_msg = "";
        if(isset($_SESSION['error_msg']))
        {
          $error_msg = $_SESSION['error_msg'];
          unset($_SESSION['error_msg']);
        }

        if(isset($_SESSION['success_msg']))
        {
          $success_msg = $_SESSION['success_msg'];
          unset($_SESSION['success_msg']);
        }
    ?>
    <div class="all-content-wrap">



      <!-- LOGIN PAGE -->
      <?php
        if($page_type == "login") :
      ?>
        <div class="content-wrap">
          <div class="logo">Free Time</div>

          <!-- Show Error Messages -->
          <?php if($error_msg != "") : ?>
            <p class="error-msg">
              <?php echo $error_msg;?>
            </p>
          <?php endif; ?>

          <!-- Show Success Messages -->
          <?php if($success_msg != "") : ?>
            <p class="success-msg">
              <?php echo $success_msg;?>
            </p>
          <?php endif; ?>

          <form method="post" action="_php/form_actions/login.php">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="pass" placeholder="Password" required />

            <div class="bottom-buttons-wrap">
              <input class="button green submit" type="submit" value="Login" />
              <a class="register button clear" href="?p=register">Sign Up</a>
            </div>

          </form>
          <a href="?p=forgot_password">Forgot Password</a>
        </div>

      <?php endif; ?>




      <!-- REGISTRATION PAGE -->
      <?php
        if($page_type == "register") :
      ?>
        <div class="content-wrap register">
          <div class="logo">Free Time</div>
          <h3>Create an Account</h3>
          <?php if($error_msg != "") : ?>
            <p class="error-msg">
              <?php echo $error_msg;?>
            </p>
          <?php endif; ?>
          <form method="post" action="_php/form_actions/register.php">
            <input type="text" name="username" placeholder="Username" required />
            <input type="text" name="first_name" placeholder="First Name" required />
            <input type="text" name="last_name" placeholder="Last Name" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="pass" placeholder="Password" required />
            <input type="password" name="pass_2" placeholder="Password Again" required />

            <div class="bottom-buttons-wrap">
              <input class="button green submit" type="submit" value="Create Account" />
              <a class="register button clear" href="?p=login">Login</a>
            </div>

          </form>
        </div>

      <?php endif; ?>




      <!-- SUCCESSFUL REGISTRATION PAGE -->
      <?php
        if($page_type == "register_success") :
      ?>
        <?php
          // If there isn't a response then just go back to login
          if($success_msg == "")
          {
            header('Location: register-login.php');
          }
         ?>
        <div class="content-wrap">
          <div class="logo">Free Time</div>
          <h3>Congrats!</h3>
          <p>
            Your account has been created. Click the button below to go back to login screen.
          </p>
          <br/><br/>
          <a href="register-login.php" class="button green">Login</a>
        </div>

      <?php endif; ?>





      <!-- FORGOT PASSWORD PAGE -->
      <?php
        if($page_type == "forgot_password") :
      ?>
        <div class="content-wrap">
          <div class="logo">Free Time</div>
          <h3>Forgot Password</h3>
          <?php if($error_msg != "") : ?>
            <p class="error-msg">
              <?php echo $error_msg;?>
            </p>
          <?php endif; ?>
          <form method="post" action="_php/form_actions/forgot_password.php">
            <label for="email">Enter your user account's verified email address and we will send you a password reset link.</label>
            <input type="email" name="email" placeholder="Email/Username" required />

            <div class="bottom-buttons-wrap">
              <input class="button green submit" type="submit" value="Send" />
              <a class="register button clear" href="?p=login">Login</a>
            </div>

          </form>
        </div>

      <?php endif; ?>




      <!-- RESET PASSWORD PAGE -->
      <?php
        if($page_type == "reset_password") :
      ?>
        <?php
          /*
           * If the user id isn't set -> back out
           */
           if(!isset($_GET['user_id']))
           {
             header('Location: register-login.php');
           }
        ?>
        <div class="content-wrap">
          <div class="logo">Free Time</div>
          <h3>Forgot Password</h3>
          <?php if($error_msg != "") : ?>
            <p class="error-msg">
              <?php echo $error_msg;?>
            </p>
          <?php endif; ?>
          <form method="post" action="_php/form_actions/reset_password.php">
            <label for="email">Enter your user account's verified email address and we will send you a password reset link.</label>
            <input type="password" name="pass" placeholder="New Password" required />
            <input type="password" name="pass_2" placeholder="New Password Again" required />
            <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>" />
            <div class="bottom-buttons-wrap">
              <input class="button green submit" type="submit" value="Reset Password" />
            </div>

          </form>
        </div>

      <?php endif; ?>

    </div>

  </body>
</html>
