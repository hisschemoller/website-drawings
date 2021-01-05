<?php
  require_once('../../private/initialize.php');

  $drawings_set = get_all_drawings();
  $drawings_array = [];
  while ($row = mysqli_fetch_assoc($drawings_set)) {
    $drawings_array[] = $row;
  }

  // $arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
  echo json_encode($drawings_array);

  db_disconnect($db);
?>
