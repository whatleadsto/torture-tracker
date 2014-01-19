<!DOCTYPE html>
<html>
<head>
  <title>jVectorMap demo</title>
  <link rel="stylesheet" media="all" href="jquery-jvectormap.css"/>
  <script src="tests/assets/jquery-1.8.2.js"></script>
  <script src="jquery-jvectormap.js"></script>
  <script src="jquery-mousewheel.js"></script>

  <script src="lib/jvectormap.js"></script>

  <script src="lib/abstract-element.js"></script>
  <script src="lib/abstract-canvas-element.js"></script>
  <script src="lib/abstract-shape-element.js"></script>

  <script src="lib/svg-element.js"></script>
  <script src="lib/svg-group-element.js"></script>
  <script src="lib/svg-canvas-element.js"></script>
  <script src="lib/svg-shape-element.js"></script>
  <script src="lib/svg-path-element.js"></script>
  <script src="lib/svg-circle-element.js"></script>

  <script src="lib/vml-element.js"></script>
  <script src="lib/vml-group-element.js"></script>
  <script src="lib/vml-canvas-element.js"></script>
  <script src="lib/vml-shape-element.js"></script>
  <script src="lib/vml-path-element.js"></script>
  <script src="lib/vml-circle-element.js"></script>

  <script src="lib/vector-canvas.js"></script>
  <script src="lib/simple-scale.js"></script>
  <script src="lib/numeric-scale.js"></script>
  <script src="lib/ordinal-scale.js"></script>
  <script src="lib/color-scale.js"></script>
  <script src="lib/data-series.js"></script>
  <script src="lib/proj.js"></script>
  <script src="lib/world-map.js"></script>

  <script src="tests/assets/jquery-jvectormap-world-mill-en.js"></script>
  <script>
    jQuery.noConflict();
    jQuery(function(){
      var $ = jQuery;

      // $('#focus-single').click(function(){
      //   $('#map1').vectorMap('set', 'focus', 'AU');
      // });
      // $('#focus-multiple').click(function(){
      //   $('#map1').vectorMap('set', 'focus', ['AU', 'JP']);
      // });
      // $('#focus-init').click(function(){
      //   $('#map1').vectorMap('set', 'focus', 1, 0, 0);
      // });

      $('#map1').vectorMap({
        map: 'world_mill_en',
        backgroundColor: '#6bd4f0',
        focusOn: {
          x: 1,
          y: 1,
          scale: 1
        },
        series: {
          regions: [{
            scale: ['#c70200', '#00c725'],
            normalizeFunction: 'polynomial',
            values: {
              <?php
              $api = file_get_contents('http://localhost/scrapers/process_memberships.php');
              $api = json_decode($api,true);
              foreach ($api as $country) {
                $json .= "'" . $country['short_name'] . "' : '" . $country['score'] . "',";
              }
                $json = rtrim($json,',');
                echo $json;
              ?>
            }
          }]
        }
      });
    })
  </script>
</head>
<body>
    <header>
      <h1>Relations Tracker</h1>
      <h2> by <a href="http://causehub.io">CauseHub</a></h2>
    </header>
    <div id="map1" style="width: 100%; height: 100%"></div>
    <section class="options">
      <form>
        <input type="checkbox" name="treaties-signed" id="treaties-signed" value="treaties-signed">Treaties Signed</input>
        <input type="checkbox" name="total-relations" id="total-relations" value="total-relations">Total Relations</input>
      </form>
    </section>
</body>

</html>