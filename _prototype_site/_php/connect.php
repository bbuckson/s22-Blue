<?php
if(!isset($_SESSION)) {
     session_start();
}


function db_connect(){

/*
  if(file_exists('../../../../../unn/config_ph.ini')){
    $config = parse_ini_file('../../../../../unn/config_ph.ini');
  }
  if(file_exists('../../../../unn/config_ph.ini')){
    $config = parse_ini_file('../../../../unn/config_ph.ini');
  }
  if(file_exists('../../../unn/config_ph.ini')){
    $config = parse_ini_file('../../../unn/config_ph.ini');
  }
  if(file_exists('../../unn/config_ph.ini')){
    $config = parse_ini_file('../../unn/config_ph.ini');
  }
  if(file_exists('../unn/config_ph.ini')){
    $config = parse_ini_file('../unn/config_ph.ini');
  }
  if(file_exists('../unn/config_ph.ini')){
    $config = parse_ini_file('../unn/config_ph.ini');
  }

  $host = $config['host'];
  $dbname = $config['dbname'];
  $username = $config['username'];
  $pass = $config['password'];
*/
    $host = 'localhost';
    $dbname = 'free_time';
    $username = 'root';
    $pass = '';

      try{
        $conn = new PDO("mysql:host=$host;dbname=$dbname;", $username, $pass);
      }catch(PDOException $e){
        die("Connection to the server got f#@ked up");
      }

    return $conn;
}
?>
