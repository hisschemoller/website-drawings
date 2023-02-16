<?php 
require_once('../../private/initialize.php');
$page_title = 'List of Drawings';
include(SHARED_PATH . '/cms_header.php');
?>

<body>
  <div class="container mt-3">
    <h1>List of all drawings</h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Description</th>
          <th scope="col">Date</th>
          <th scope="col">Longitude</th>
          <th scope="col">Latitude</th>
        </tr>
      </thead>
      <tbody>

<?php 
  $drawings_set = get_all_drawings();
  while ($row = mysqli_fetch_assoc($drawings_set)) {
    $description = $row['description'];
    $description = strlen($description) > 50 ? substr($description, 0, 50) . '...' : $description;
    echo '<tr>';
    echo '<td><a href="' . url_for('backend/edit.php') . '?id=' . $row['id'] . '">' . $description . '</a></td>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td>' . $row['longitude'] . '</td>';
    echo '<td>' . $row['latitude'] . '</td>';
    echo '</tr>';
  }
?>

      </tbody>
    </table>
  </div>
</body>
</html>

<?php db_disconnect($db); ?>
