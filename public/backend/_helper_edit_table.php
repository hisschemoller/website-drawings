<?php
require_once('../../private/initialize.php');
$page_title = 'Import images to DB';
include(SHARED_PATH . '/cms_header.php');
$default_latitude = 52.362731;
$default_longitude = 4.905849;
?>

<body>
  <div class="container mt-3">
    <h1>List of all drawings</h1>
    <p>This file shows a list of all entries in the hisschemoller_drawings database table where
      the latitude and longitude are both 0. It also immediately sets them to default values 
      <?php echo $default_latitude; ?> and <?php echo $default_longitude; ?>.</p>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Description</th>
          <th scope="col">Lat</th>
          <th scope="col">Long</th>
        </tr>
      </thead>
      <tbody>

<?php
$drawings_set = get_all_drawings();
while ($row = mysqli_fetch_assoc($drawings_set)) {
  $id = $row['id'];
  $description = $row['description'];
  $latitude = $row['latitude'];
  $longitude = $row['longitude'];
  if ($latitude == 0 && $longitude == 0) {
    $query = "UPDATE hisschemoller_drawings ";
    $query .= "SET longitude='$default_longitude', latitude='$default_latitude' ";
    $query .= "WHERE id='$id' LIMIT 1";
    // $result = mysqli_query($db, $query);
    echo '<tr><td>'.$description.'</td><td>'.$latitude.'</td><td>'.$longitude.'</td></tr>';
  }
}
?>
      </tbody>
    </table>
  </div>
</body>
</html>
