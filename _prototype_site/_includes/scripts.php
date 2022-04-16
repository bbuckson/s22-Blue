<?php
  /*
    Define $root in the php page calling scripts.
    $root should be a string that points to local folder

    ex: If the page calling scripts is in a subdirectory of the root folder then $root = '../'
  */
 ?>
<?php if(!isset($root)){$root = '';} ?>
<?php require($root . "_php/functions.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo $root; ?>main.css?v=<?php echo rand(2,100);?>">
<script type="text/javascript" src="<?php echo $root; ?>main.js"></script>
