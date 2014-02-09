<!DOCTYPE html>
<html>
<head>
  <title><?php $title = 'Torture Tracker'; echo $title; ?></title>
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

      <?php 
      $api = file_get_contents('http://relationstracker.causehub.io/scrapers/api.php');
      echo $api;
      $api = json_decode($api,true); 
      ?>

      var countryScore = {<?php
              $json = '';
              foreach ($api as $country) {
                $json .= "'" . $country['short_name'] . "':" . $country['score'] . ",";
              }
                $json = rtrim($json,',');
                echo $json;
              ?>};

      var shared_memberships = {<?php
              $json = '';
              foreach ($api as $country) {
                $json .= "'" . $country['short_name'] . "':" . $country['shared_memberships'] . ",";
              }
                $json = rtrim($json,',');
                echo $json;
              ?>};

      var treaties_signed = {<?php
              $json = '';
              foreach ($api as $country) {
                $json .= "'" . $country['short_name'] . "':" . $country['treaties_signed'] . ",";
              }
                $json = rtrim($json,',');
                echo $json;
              ?>};

      var incoming_investment = {<?php
              $json = '';
              foreach ($api as $country) {
                $json .= "'" . $country['short_name'] . "':" . $country['investment_fdi'] . ",";
              }
                $json = rtrim($json,',');
                echo $json;
              ?>};

      function drawMap(score){
        $('#map1').empty();
        $('#map1').vectorMap({
          map: 'world_mill_en',
          backgroundColor: 'none',
          focusOn: {
            x: 1,
            y: 1,
            scale: 1
          },
          series: {
            regions: [{
              scale: ['#c70200', '#00c725'],
              normalizeFunction: 'polynomial',
              values: score
            }]
          },
          onRegionLabelShow: function(event, label, code){
            var scoreType = $( "input:checked" ).attr('name');
            <?php
            $json = '';
            foreach($api as $country) {
              $json .= "if(code=='" . $country['short_name'] . "' && scoreType=='treaties_signed'){";
              $json .= "label.text('" . $country['long_name'] . " | " . $country['treaties_signed'] . " treaties signed' )";
              $json .= "}
              ";
              $json .= "if(code=='" . $country['short_name'] . "' && scoreType=='shared_memberships'){";
              $json .= "label.text('" . $country['long_name'] . " | " . $country['shared_memberships'] . " shared memberships' )";
              $json .= "}
              ";
            }
              $json = rtrim($json,',');
              echo $json;

            ?>
          }
        });
      }


      drawMap(countryScore);

      $( "input" ).on( "click", function() {
        if($( "input:checked" ).val()!='All Relations'){
          var scoreType = $( "input:checked" ).attr('alt');
          eval("drawMap(" + scoreType + ");");
          document.body.style.backgroundImage="url('images/"+scoreType+".jpg')";
        }
        else{
          drawMap(countryScore);
        }
      });

    })
  </script>
</head>
<body>
    <header>
      <h1><?php echo $title; ?></h1>
      <h2> by <a href="http://causehub.io">CauseHub</a>, <a href="http://bcinformetrics.co.uk" target="_blank">Black Country Infometrics</a> and <a href="http://amnesty.org.uk" target="">Amnesty International</a></h2>
    </header>
    <div id="map1" style="width: 100%; height: 100%"></div>
    <section class="options">
      <form>
        <label><input type="radio" name="showgroup" alt="shared_memberships" id="shared_memberships" value="Shared Memberships"><span>Shared Memberships</span></input></label>
        <label><input type="radio" name="showgroup" alt="treaties_signed" id="treaties_signed" value="Treaties Signed"><span>Treaties Signed</span></input></label>
         <label><input type="radio" name="showgroup" alt="incoming_investment" id="incoming_investment" value="Incoming Investment"><span>Incoming Investment</span></input></label>
        <label><input type="radio" name="showgroup" alt="total_relations" id="total-relations" value="All Relations" checked=true><span>All Relations</span></input></label>
      </form>
    </section>
</body>

</html>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46743356-5', 'causehub.io');
  ga('send', 'pageview');

</script>