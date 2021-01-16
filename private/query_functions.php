<?php

function get_all_drawings() {
  global $db;
  $query = "SELECT * FROM hisschemoller_drawings ORDER BY `date` DESC";
  $result = mysqli_query($db, $query);
  confirm_result_set($result);
  return $result;
}

function get_drawing_by_id($id) {
  global $db;
  $query = "SELECT * FROM hisschemoller_drawings WHERE id='" . db_escape($db, $id) . "'";
  $result = mysqli_query($db, $query);
  confirm_result_set($result);
  $drawing = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $drawing;
}

function update_drawing($drawing) {
  global $db;
  $query = "UPDATE hisschemoller_drawings SET ";
  $query .= "description='" . db_escape($db, $drawing['description']) . "', ";
  $query .= "date='" . db_escape($db, $drawing['date']) . "', ";
  $query .= "latitude='" . db_escape($db, $drawing['latitude']) . "', ";
  $query .= "longitude='" . db_escape($db, $drawing['longitude']) . "', ";
  $query .= "title='" . db_escape($db, $drawing['title']) . "' ";
  $query .= "WHERE id='" . db_escape($db, $drawing['id']) . "' ";
  $query .= "LIMIT 1";
  $result = mysqli_query($db, $query);
  
  // for UPDATE statements $result is true|false
  if($result) {
    return true;
  } else {
    
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

?>