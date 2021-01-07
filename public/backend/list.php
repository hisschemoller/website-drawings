<?php 
require_once('../../private/initialize.php');
$page_title = 'List of Drawings';
include(SHARED_PATH . '/cms_header.php');
?>

<body>
  <h1>List of all drawings</h1>
  <ul>

<?php 
  $drawings_set = get_all_drawings();
  while ($row = mysqli_fetch_assoc($drawings_set)) {
    $description = $row['description'];
    $description = strlen($description) > 100 ? substr($description) . '...' : $description;
    echo '<li>';
    echo '<div><a href="' . url_for('edit.php') . '?id=' . $row['id'] . '">' . $description . '</a> (' . $row['date'] . ')</div>';
    echo '</li>';
  }
?>

</ul>
</body>
</html>

<?php db_disconnect($db); ?>
