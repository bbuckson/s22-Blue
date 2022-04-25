<?php
  require('../connect.php');

  $block_id = $_POST['block_id'];

  $conn = db_connect();

  $data = $conn->prepare('DELETE FROM blocks WHERE id = :id');

  $data->bindParam(':id', $block_id);

  if($data->execute())
  {
    echo "nice";
  }



?>
