<?php
require_once('../../private/initialize.php');
$page_title = 'Rename all files in a directory';
include(SHARED_PATH . '/cms_header.php');
?>

<body>
  <div class="container mt-3">
    <h1>List of all drawings</h1>
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
$dir = '../images/drawings-original/';
$newDir = '../images/drawings-1280/';
$newWidth = 1280;
$files = glob($dir."{*.gif,*.jpg,*.jpeg,*.png}", GLOB_BRACE|GLOB_NOSORT);
$numFiles = count($files);
foreach ($files as $file) {
  $pathPos = strlen($dir);
  $extPos = strpos($file, '.png');
  $newName = $newDir . substr($file, $pathPos, $extPos - $pathPos) . '_-_' . $newWidth . '.png';
  echo '<tr><td>'.$file.'</td><td>'.$newName.'</td></tr>';
  if ($file != $newName) {
    resize($newWidth, $newName, $file);
  }
}

function resize($newWidth, $targetFile, $originalFile) {

  $info = getimagesize($originalFile);
  $mime = $info['mime'];

  switch ($mime) {
    case 'image/jpeg':
      $image_create_func = 'imagecreatefromjpeg';
      $image_save_func = 'imagejpeg';
      $new_image_ext = 'jpg';
      break;

    case 'image/png':
      $image_create_func = 'imagecreatefrompng';
      $image_save_func = 'imagepng';
      $new_image_ext = 'png';
      break;

    case 'image/gif':
      $image_create_func = 'imagecreatefromgif';
      $image_save_func = 'imagegif';
      $new_image_ext = 'gif';
      break;

    default: 
      throw new Exception('Unknown image type.');
  }

  $img = $image_create_func($originalFile);
  list($width, $height) = getimagesize($originalFile);

  $newHeight = ($height / $width) * $newWidth;
  $tmp = imagecreatetruecolor($newWidth, $newHeight);
  imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

  if (file_exists($targetFile)) {
    unlink($targetFile);
  }
  $image_save_func($tmp, $targetFile);
}
?>
      </tbody>
    </table>
  </div>
</body>
</html>
