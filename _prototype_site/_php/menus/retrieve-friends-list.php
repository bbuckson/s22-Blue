<?php
    if(!isset($_SESSION)) {
       session_start();
    }
    require('../functions.php');

    $user_id = $_SESSION['user_id'];

    $conn = db_connect();
    $data = $conn->prepare('SELECT * FROM friends WHERE user_id_1 = :user_id');
    $data->bindParam(':user_id', $user_id);

    if($data->execute())
    {
      $arr = $data->fetchAll(PDO::FETCH_ASSOC);

      foreach ($arr as $item) :
        $friend = get_user($item['user_id_2']);
  ?>
      <div class="item-wrap">
        <a href="calendar?uid=<?php echo $friend['id']; ?>">
          <img src="_pics/_users/<?php echo $friend['image'];?>" class="icon" />
          <div class="msg-wrap">
            <?php echo $friend['username'];?>
          </div>
        </a>
      </div>
  <?php
      endforeach;
    }

  ?>
