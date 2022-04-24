<?php
if(!isset($_SESSION)) {
     session_start();
}
require('connect.php');

function is_logged_in(){
  if(isset($_SESSION['username_free_blocks']))
  {
    return true;
  }
  return false;
}



/*
 * Display the bar on the top of the screen
 */
function show_top_bar($root)
{
  require($root . '_includes/top-bar.php');
}


/*
 * Display the bar on the bottom of the screen
 */
function show_bottom_bar($root)
{
  require($root . '_includes/bottom-bar.php');
}


/*
 * Get user row with their id as parameter
 */

function get_user($user_id)
{
  $conn = db_connect();

  $data = $conn->prepare('SELECT * FROM users WHERE id = :id');
  $data->bindParam(':id', $user_id);

  $data->execute();

  $arr = $data->fetchAll(PDO::FETCH_ASSOC);

  return $arr[0];
}
