<?php
require_once('../../private/initialize.php');
$page_title = 'Import images to DB';
include(SHARED_PATH . '/cms_header.php');
?>

<body>
  <div class="container mt-3">
    <h1>List of all drawings</h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Title</th>
          <th scope="col">Date</th>
          <th scope="col">W</th>
          <th scope="col">H</th>
          <th scope="col">W</th>
          <th scope="col">H</th>
        </tr>
      </thead>
      <tbody>

<?php
$ext = '.png';
$width_s = '640';
$width_l = '1280';
$baseDir = '../images/drawings-';
$dir_s = $baseDir . $width_s . '/';
$dir_l = $baseDir . $width_l . '/';
$pathPos_s = strlen($dir_s);
$files = glob($dir_s ."{*.png}", GLOB_BRACE|GLOB_NOSORT);
$queryRows = '';
$i = 0;
$numFiles = count($files);
foreach ($files as $file) {
  $extPos = strpos($file, $ext);
  $baseFileName = substr($file, $pathPos_s);
  $widthPos = strpos($baseFileName, $width_s);
  $baseFileName = substr($baseFileName, 0, $widthPos);
  $fileName_s = $baseFileName . $width_s . $ext;
  list($w_s, $h_s) = getimagesize($file);

  $fileName_l = $baseFileName . $width_l . $ext;
  $files_l = glob($dir_l . $fileName_l, GLOB_BRACE|GLOB_NOSORT);
  list($w_l, $h_l) = getimagesize($files_l[0]);

  list($author, $info) = explode('_-_', $baseFileName);
  list($date, $title) = explode('_', $info);
  $title = str_replace('-', ' ', $title);
  $title = ucwords($title);
  echo '<tr><td>'.$title.'</td><td>'.$date.'</td><td>'.$w_l.'</td><td>'.$h_l.'</td><td>'.$w_s.'</td><td>'.$h_s.'</td></tr>';
  

  $queryRows .= "('$fileName_l', '$w_l', '$h_l', '$fileName_s', '$w_s', '$h_s', '$title', '$date')";
  if ($i < $numFiles - 1) {
    $queryRows .= ", ";
  }
  $i++;
}

$query = "INSERT INTO hisschemoller_drawings ";
$query .= "(image_file_large, width_large, height_large, image_file_small, width_small, height_small, description, date) ";
$query .= "VALUES $queryRows";

// $result = mysqli_query($db, $query);

// for UPDATE statements $result is true|false
if($result) {
  echo 'succes';
} else {
  
  // UPDATE failed
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
}
echo $query;
?>
      </tbody>
    </table>
  </div>
</body>
</html>
