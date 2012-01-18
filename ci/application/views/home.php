<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Voter ID</title>
<link rel="stylesheet" href="/css/main.css" type="text/css"/>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="/application/libraries/OpenLayers-2.11/OpenLayers.js"></script>
<script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.5"></script>
<script type="text/javascript">

var map;

$( function() {
	// easy function to zoom and center the map with the WGS 84 spatial reference system
   var zoomAndCenter = function(map, lat, lon, zoomLevel) {
   map.setCenter(
            wgs84toMapProj(new OpenLayers.LonLat(lon,lat)), zoomLevel
        );
   }         	
	
	map = new OpenLayers.Map('map');
	
	// transform proj function
	var wgs84toMapProj = function(obj) {
		return obj.transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject())
	}
	
	// OSM layer sources from MapQuest
   arrayOSM = ["http://otile1.mqcdn.com/tiles/1.0.0/osm/${z}/${x}/${y}.png",
                 "http://otile2.mqcdn.com/tiles/1.0.0/osm/${z}/${x}/${y}.png",
                 "http://otile3.mqcdn.com/tiles/1.0.0/osm/${z}/${x}/${y}.png",
                 "http://otile4.mqcdn.com/tiles/1.0.0/osm/${z}/${x}/${y}.png"];
   arrayAerial = ["http://oatile1.mqcdn.com/tiles/1.0.0/sat/${z}/${x}/${y}.png",
                  "http://oatile2.mqcdn.com/tiles/1.0.0/sat/${z}/${x}/${y}.png",
                  "http://oatile3.mqcdn.com/tiles/1.0.0/sat/${z}/${x}/${y}.png",
                  "http://oatile4.mqcdn.com/tiles/1.0.0/sat/${z}/${x}/${y}.png"];
   
   // define layers
   var baseOSM = new OpenLayers.Layer.OSM("MapQuest-OSM Tiles", arrayOSM);
   var baseAerial = new OpenLayers.Layer.OSM("MapQuest Open Aerial Tiles", arrayAerial);                  
	
	// add layers and controls
	map.addLayers([baseOSM, baseAerial]);
	map.addControl(new OpenLayers.Control.LayerSwitcher());
	
	
	// set default map layout
	zoomAndCenter(map, 40,-100,4);
	//map.zoomToMaxExtent();
	
	// add marker layer	
	var markers = new OpenLayers.Layer.Markers( "Markers" );
	map.addLayer(markers);
	
	/* define geocoder object */
	var geocoder = new esri.tasks.Locator(
   		"http://tasks.arcgisonline.com/ArcGIS/rest/services/Locators/TA_Address_NA_10/GeocodeServer"
	);
	
	/* geocoding function */	
	var geocode = function(address) {
		geocoder.addressToLocations({SingleLine:address, Country:'US'}, ["Loc_name", "State"], gcCallback)
	}
	
	/* callback for the geocoder */
	var gcCallback = function(candidates) {
		// display address, lat, lon
		$('#formatted-address').text(candidates[0]['address']
			+' ('+candidates[0]['location']['y'] //lat
			+', '+candidates[0]['location']['x'] //lon
			+')');
			
		// fill in state
		var stateAbbr = candidates[0]['attributes']['State'] // 2-char state abbreviation
		
		// search and display voter requirements
		$.getJSON('/index.php/api/voter_id_docs/'+stateAbbr, function(data){
			numDocs = data.documents.length;
			if(numDocs > 0) {
				// create list of documents
				$('#vote-req-header').text('To vote in '+stateAbbr+', you will need one of these:');
				$('#vote-req-content').html('<ul/>');
				for(x in data.documents) {
					$('#vote-req-content ul').append('<li>'+data.documents[x]+'</li>');
				}
				
				$('#vote-id-header').text('How to get a voter ID in '+stateAbbr+':');
				
				// get JSON from BC api
				$.getJSON('/index.php/api/birth_certificate/'+stateAbbr, function(bc_data){
						if(bc_data.length>0){	
							$('#vote-id-content').html('Please visit <a target="_blank" href="'+bc_data[0].url_photo_id+'">'+bc_data[0].url_photo_id+'</a> for more information.');
							$('#bc-header').text('Getting a birth certificate in '+stateAbbr+':');
							$('#bc-content').show();
							$('#bc-cost span').text(bc_data[0].cost_bc);
							// $('#bc-cost span').text(bc_data.cost_bc);
						}else{
							$('#vote-id-content').text('Information not yet available.');
						}
					});				
				
				// voter id

				
			} else {
				// display notice
				$('#vote-req-header').text('Sorry, this information is not yet available for '+stateAbbr+'.');
			}
			
			});
		
		
		
		// zoom map to location
		zoomAndCenter(map, candidates[0]['location']['y'], candidates[0]['location']['x'], 16);
		
		// mark user's address
		var size = new OpenLayers.Size(21,25);
		var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
		var icon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png', size, offset);
		markers.addMarker(new OpenLayers.Marker(wgs84toMapProj(new OpenLayers.LonLat(candidates[0]['location']['x'],candidates[0]['location']['y'])),icon));

		// add markers for places to get documentation
		
	}
	
	$('#address-form').submit( function() {
		geocode($.trim($('#address').val())); // geocode using the address the user entered
		return false; // prevent form from sending HTTP request
	});
	
});

</script>
</head>
<body>
<div class="wrapper">
	<div id="doc-header">
		<div class="content"><h1 style="color:white;">Cost of Freedom</h1></div>
	</div>
	<div class="container">
		<div class="content">
            <div>
              <h1>The high cost of a "free" photo ID</h1>
                <h2>Enter your address to see ID requirements for your area:</h2>
                <form id="address-form">
                <p>
                <input id="address" name="address" type="search" placeholder="Ex: 501 Auburn Avenue NE, Atlanta, GA" style="width:300px;"/>
                <input type="submit" name="submit-address" id="submit-address" value="Search" />
                </p>
                </form>
                <h5 id="formatted-address">&nbsp;</h5>
                <h4 id="vote-req-header"></h4>
                <div id="vote-req-content"></div>
                <h4 id="vote-id-header"></h4>
                <div id="vote-id-content"></div>
                <h4 id="bc-header"></h4>
                <div id="bc-content" style="display:none;">
                 <ul>
                	<li id="bc-mail-in"></li>
                	<li id="bc-online"></li>
					<li id="bc-cost">Cost: <span></span></li>
					<li id="bc-office">Office: <span></span></li>     
					<li id="bc-location">Location: <span></span></li>     
					<li id="bc-hours">Hours: <span></span></li> 
					</ul>            
                </div>
            </div>
            <div id="map"></div>
		</div>
	</div>
	<div class="push"></div>
</div>
<div class="footer">
<p class="smaller"><br />
		Built at RHoK Global Philadelphia 2011. Derived from <a href="http://codeigniter.com/">CodeIgniter</a>.<br />
		Data provided by the <a href="http://866ourvote.org/">Lawyers' Committee for Civil Rights Under Law</a>. <br />
		Map built with <a href="http://openlayers.org/">OpenLayers</a> and powered by <a href="http://mapquest.com">MapQuest</a>. Geocoding by <a href="http://esri.com/">Esri</a>.
</div>
</body>
</html>