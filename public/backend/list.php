<?php require_once('../../private/initialize.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>List</title>
  <link rel="stylesheet" href="css/backend.css">
</head>
<body>
  <h1>List of all drawings</h1>
  <ul>

<?php 
  $drawings_set = get_all_drawings();
  while ($row = mysqli_fetch_assoc($drawings_set)) {
    $description = $row['description'];
    $description = strlen($description) > 100 ? substr($description) . '...' : $description;
    echo '<li>';
    echo '<div><a href="edit?id=' . $row['id'] . '">' . $description . '</a> (' . $row['date'] . ')</div>';
    echo '</li>';
  }
?>

</ul>
</body>
</html>

<?php db_disconnect($db); ?>
