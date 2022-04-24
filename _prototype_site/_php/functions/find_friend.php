<?php
  require('../connect.php');

  $val = "%" . $_POST['val'] . "%";

  $conn = db_connect();

  $data = $conn->prepare('SELECT * FROM users WHERE username LIKE :username');

  $data->bindParam(':username', $val);

  if($data->execute())
  {
    $arr = $data->fetchAll(PDO::FETCH_ASSOC);

    // If there are any results
    if($data->rowCount() > 0 && $_POST['val'] != "")
    {
      //echo json_encode($arr);
      foreach ($arr as $item) :
?>

    <a class="item"data-user-id="<?php echo $item['id']; ?>" data-username="<?php echo $item['username']; ?>">
      <img class="icon" src="_pics/_users/<?php echo $item['image']; ?>" />
      <div class="name">
        <?php echo $item['username']; ?>
      </div>
    </a>
<?php endforeach;
    }
    else
    {
      echo "No Results";
    }
  }
  else
  {
    echo "Something went wrong";
  }



 ?>
