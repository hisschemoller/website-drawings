<?php
require_once('../../private/initialize.php');
$page_title = 'Rename all files in a directory';
include(SHARED_PATH . '/cms_header.php');
?>

<body>
  <div class="container mt-3">
    <h1>List of all drawings</h1>
    <p>This file get all image files in a folder and renames them, where the old filename is
      expected to be a date and location, like '2016-06-06_weesperstraat.png', which would be
      renamed to 'wouter-hisschemoller_-_2016-06-06_weesperstraat_-_[640|1280].png'
    </p>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Old</th>
          <th scope="col">New</th>
        </tr>
      </thead>
      <tbody>

<?php
// $dir = '../../../../../Pictures/Tekeningen Boek 2020/boek-2020-05-export';
// $dir = '../../../../../Pictures/Tekeningen Boek 2019/boek-2019-05-export';
// $dir = '../../../../../Pictures/Tekeningen Boek 2018-ev/boek-2018-04-export';
// $dir = '../../../../../Pictures/Tekeningen Boek 2017-18/boek-2017-05-export';
$dir = '../images/drawings-640/';
$width = 640;
$pathPos = strlen($dir);
$files = glob($dir."{*.gif,*.jpg,*.jpeg,*.png}",GLOB_BRACE|GLOB_NOSORT);
foreach ($files as $file) {
  $extPos = strpos($file, '.png');
  $fileName = substr($file, $pathPos, $extPos - $pathPos);
  // $pos = strpos($file, '_-__');
  // $newName = substr($file, 0, $pos) . '_-' . substr($file, $pos + 8);
  $newName = $dir . 'wouter-hisschemoller_-_' . substr($fileName, 6) . '_-_' . $width . '.png';
  echo '<tr><td>'.$file.'</td><td>'.$newName.'</td></tr>';
  if ($file != $newName) {
    // rename($file, $newName);
  }
}
?>
      </tbody>
    </table>
  </div>
</body>
</html>
