<?php

  function get_all_drawings() {
    global $db;
    $query = 'SELECT * FROM hisschemoller_drawings ';
    $query .= 'ORDER BY date DESC';
    $result = mysqli_query($db, $query);
    confirm_result_set($result);
    return $result;
  }

?>