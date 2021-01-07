<?php
require_once('../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to(url_for('/list.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // this is a form submit
  $drawing = [];
  $drawing['id'] = $id;
  $drawing['description'] = $_POST['description'] ?? '';
  $drawing['date'] = $_POST['date'] ?? '';
  $drawing['latitude'] = $_POST['latitude'] ?? '';
  $drawing['longitude'] = $_POST['longitude'] ?? '';
  update_drawing($drawing);
} else {
  $drawing = get_drawing_by_id($id);
}

$page_title = 'Edit Drawing';
include(SHARED_PATH . '/cms_header.php');

?>

<body>
  <h1>Edit drawing</h1>
  <a href="<?php echo url_for('list.php'); ?>">< Back to overview list</a>
  <form action="<?php echo url_for('edit.php?id=' . h(u($id))); ?>" method="post">
    <div>
      <label>Description</label>
      <input type="text" name="description" value="<?php echo h($drawing['description']); ?>" />
    </div>
    <div>
      <label>Date</label>
      <input type="date" name="date" value="<?php echo h($drawing['date']); ?>" />
    </div>
    <div>
      <label>Latitude</label>
      <input type="number" name="latitude" value="<?php echo h($drawing['latitude']); ?>" />
    </div>
    <div>
      <label>Longitude</label>
      <input type="number" name="longitude" value="<?php echo h($drawing['longitude']); ?>" />
    </div>
    <div>
      <label></label>
      <input type="submit" name="submit" value="Submit" />
    </div>
  </form>
</body>
</html>
