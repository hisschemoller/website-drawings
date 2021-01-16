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
  $drawing['date'] = $_POST['date'] ?? '';
  $drawing['description'] = $_POST['description'] ?? '';
  $drawing['image_file'] = $_POST['image_file'] ?? '';
  $drawing['latitude'] = $_POST['latitude'] ?? '';
  $drawing['longitude'] = $_POST['longitude'] ?? '';
  $drawing['title'] = $_POST['title'] ?? '';
  update_drawing($drawing);
} else {
  $drawing = get_drawing_by_id($id);
}

$page_title = 'Edit Drawing';
include(SHARED_PATH . '/cms_header.php');
?>

<body>
  <div class="container mt-3">
    <div class="row">
      <div class="col">
        <h1>Edit drawing</h1>
      </div>
      <div class="col d-flex align-items-center">
        <a href="<?php echo url_for('backend/list.php'); ?>">< Back to overview list</a>
      </div>
    </div>
    <div id="map" class="map"></div>
    <div id="mouse-position"></div>
    <div class="row">
      <div class="col-md-8">
        <form action="<?php echo url_for('backend/edit.php?id=' . h(u($id))); ?>" method="post">
          <input type="hidden" name="image_file" value="<?php echo h($drawing['image_file']); ?>" />

          <div class="form-floating mb-3 mt-3">
            <input type="text" name="title" id="title" value="<?php echo h($drawing['title']); ?>" placeholder="Title" class="form-control" />
            <label for="description">Title</label>
          </div>

          <input type="hidden" name="image_file" value="<?php echo h($drawing['image_file']); ?>" />
          <div class="form-floating mb-3 mt-3">
            <input type="text" name="description" id="description" value="<?php echo h($drawing['description']); ?>" placeholder="Description" class="form-control" />
            <label for="description">Description</label>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="date" name="date" id="date" value="<?php echo h($drawing['date']); ?>" placeholder="Date" class="form-control" />
                <label for="date">Date</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" name="latitude" id="latitude" value="<?php echo h($drawing['latitude']); ?>" placeholder="Latitude" class="form-control" />
                <label for="latitude">Latitude</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-3">
                <input type="text" name="longitude" id="longitude" value="<?php echo h($drawing['longitude']); ?>" placeholder="Longitude" class="form-control" />
                <label for="longitude">Longitude</label>
              </div>
            </div>
          </div>
          <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
        </form>
      </div>
      <div class="col-md-4">
        <img src="<?php echo url_for('images/drawings/' . h($drawing['image_file'])); ?>" alt="" class="img-fluid mt-3" />
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  <script type="text/javascript">

    const className = 'custom-mouse-position';
    const mousePositionControl = new ol.control.MousePosition({
      coordinateFormat: ol.coordinate.createStringXY(6),
      projection: 'EPSG:4326',
      target: document.getElementById('mouse-position'),
      className,
      undefinedHTML: '&nbsp;',
    });

    const map = new ol.Map({
      controls: ol.control.defaults().extend([mousePositionControl]),
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM()
        })
      ],
      target: 'map',
      view: new ol.View({
        center: ol.proj.fromLonLat([<?php echo h($drawing['longitude']); ?>, <?php echo h($drawing['latitude']); ?>]),
        zoom: 16,
      })
    });

    const feature = new ol.Feature({
      geometry: new ol.geom.Point(ol.proj.fromLonLat([<?php echo h($drawing['longitude']); ?>, <?php echo h($drawing['latitude']); ?>]))
    });

    feature.setStyle(
      new ol.style.Style({
        image: new ol.style.Icon({
          color: 'rgba(255, 0, 0, .5)',
          crossOrigin: 'anonymous',
          scale: 0.1,
          src: 'https://upload.wikimedia.org/wikipedia/commons/e/e3/Green_Dot.svg',
        }),
      })
    );

    const layer = new ol.layer.Vector({
      source: new ol.source.Vector({
        features: [ feature ],
      })
    });
    map.addLayer(layer);

    map.on('click', (event) => {
      const coordsStr = document.querySelector('.' + className).innerHTML;
      const coords = coordsStr.split(',');
      document.querySelector('#longitude').value = parseFloat(coords[0]);
      document.querySelector('#latitude').value = parseFloat(coords[1]);
      console.log('click', parseFloat(coords[0]), coords[1], typeof parseFloat(coords[0]));
    });

  </script>
</body>
</html>
