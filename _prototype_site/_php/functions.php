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


/*
 * Get event row with their id as parameter
 */

function get_event($event_id)
{
  $conn = db_connect();

  $data = $conn->prepare('SELECT * FROM events WHERE id = :id');
  $data->bindParam(':id', $event_id);

  $data->execute();

  $arr = $data->fetchAll(PDO::FETCH_ASSOC);

  if($data->rowCount() > 0)
    return $arr[0];
}




/*
 * Get block row with their id as parameter
 */

function get_block($block_id)
{
  $conn = db_connect();

  $data = $conn->prepare('SELECT * FROM blocks WHERE id = :id');
  $data->bindParam(':id', $block_id);

  $data->execute();

  $arr = $data->fetchAll(PDO::FETCH_ASSOC);

  if($data->rowCount() > 0)
    return $arr[0];
}



/*
 * Get users_in_event row with their id as parameter
 */

function get_users_in_event($event_id, $user_id)
{
  $conn = db_connect();

  $data = $conn->prepare('SELECT * FROM users_in_event WHERE event_id = :event_id AND receiving_user_id = :receiving_user_id');
  $data->bindParam(':event_id', $event_id);
  $data->bindParam(':receiving_user_id', $user_id);

  $data->execute();

  $arr = $data->fetchAll(PDO::FETCH_ASSOC);

  if($data->rowCount() > 0)
    return $arr[0];
}



/*
 * Get users_in_event row with their id as parameter
 */

function get_notification($notification_id)
{
  $conn = db_connect();

  $data = $conn->prepare('SELECT * FROM notifications WHERE$notification_id = :notification_id');
  $data->bindParam(':notification_id', $notification_id);

  $data->execute();

  $arr = $data->fetchAll(PDO::FETCH_ASSOC);

  if($data->rowCount() > 0)
    return $arr[0];
}
