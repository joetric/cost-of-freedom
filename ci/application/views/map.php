<!--
//Copyright 2011 Joseph R. Tricarico.<br />
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transitfone<?php //echo $title?$title:'Transitfone';?></title>
<link rel="stylesheet" href="/css/main.css" type="text/css"/>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-27073758-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<!-- ArcGIS map scripts -->
<script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.5"></script>
<link rel="stylesheet" type="text/css" href="http://serverapi.arcgisonline.com/jsapi/arcgis/2.5/js/dojo/dijit/themes/tundra/tundra.css">
<link rel="stylesheet" type="text/css" href="http://serverapi.arcgisonline.com/jsapi/arcgis/2.5/js/esri/dijit/css/Popup.css"/>

<script type="text/javascript">
  dojo.require("esri.map");
  dojo.require("esri.layers.KMLLayer");
  var map;


  function init() {
	var wgs84 = new esri.SpatialReference({wkid:4326});
  //var wgs84wm = new esri.SpatialReference({wkid:102100});
    var greaterPhila = new esri.geometry.Extent(-74.654846, 39.701904, -75.834503, 40.341311, wgs84); // (xmin, ymin, xmax, ymax, spatialReference)
	var greaterPhila = esri.geometry.geographicToWebMercator(greaterPhila);
    var map = new esri.Map("map", {slider:false, wrapAround180:true});
	map.setExtent(greaterPhila, true); // extent, fit
	
	// add a basemap
    var basemapURL= "http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer"
    var basemap = new esri.layers.ArcGISTiledMapServiceLayer(basemapURL);
    map.addLayer(basemap);
	
	// load data from KML
	var kmlUrl = 'http://dev.transitfone.com/septa/perks?format=kml',
      kml = new esri.layers.KMLLayer(kmlUrl); 
    map.addLayer(kml);
	
	dojo.connect(map, 'onLoad', function() { 
        //resize the map when the browser resizes
        dojo.connect(dijit.byId('map'), 'resize', map,map.resize);
    });
  }
  dojo.ready(init);
  

</script>

</head>
<body class="tundra">
<div class="wrapper" id="map">
	<div id="doc-header">
		<div class="content"><a href="/"><img src="/img/transitfone_h46_bg0cf.gif" alt="transitfone" width="216" height="46" border="0" /></a>
        
        <div style="float:right;">
        Hint: hold down the Shift key and drag the mouse to zoom.
        </div>
        
        </div>
	</div>
    <div id="map2" style="position:fixed;width:100%;height:100%;"></div>
</div>
<div class="footer">
<p class="smaller"><br />
		&copy;2011 <a href="http://www.azavea.com/about-us/staff-profiles/joe-tricarico">Joseph Tricarico</a>. Derived from <a href="http://codeigniter.com/">CodeIgniter</a> and contributions by <a href="http://twitter.com/benedmunds">Ben Edmunds</a>.<br />
		Data provided by the <a href="http://septa.org/">Southeastern Pennsylvania Transportation Authority</a>. <br />
	  For help or comments, e-mail <strong>info@transitfone.com</strong>. Click <a href="http://stats.pingdom.com/yfyiivab1310/433995">here for uptime stats</a>.</p>
</div>
</body>
</html>