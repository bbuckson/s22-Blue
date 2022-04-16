<?php
if(!isset($_SESSION)) {
     session_start();
}
require('connect.php');

function is_logged_in(){
  if(isset($_SESSION['username']))
  {
    return true;
  }
  return false;
}
