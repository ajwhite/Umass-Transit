<!-- google maps api -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">
$j = jQuery.noConflict();
</script>
<!-- autocomplete -->
<link rel="stylesheet" href="/assets/js/autocomplete/TextboxList.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="/assets/js/autocomplete/TextboxList.Autocomplete.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="/assets/js/autocomplete/growingInput.js"></script>
<script src="/assets/js/autocomplete.compatible//TextboxList.js" type="text/javascript" charset="utf-8"></script>		
<script src="/assets/js/autocomplete.compatible/TextboxList.Autocomplete.js" type="text/javascript" charset="utf-8"></script>
<script src="/assets/js/autocomplete.compatible/TextboxList.Autocomplete.Binary.js" type="text/javascript" charset="utf-8"></script>

<!-- modal -->
<!--
<link rel="stylesheet" href="assets/css/reset.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="assets/css/demo.css" type="text/css" media="screen" title="no title" charset="utf-8">
-->
<link rel="stylesheet" href="/assets/js/modal/assets/css/simplemodal.css" type="text/css" media="screen" title="no title" charset="utf-8">
<script src="/assets/js/modal/Demo/assets/javascript/mootools-core-1.3.1.js" type="text/javascript" charset="utf-8"></script>
<script src="/assets/js/modal/Demo/assets/javascript/mootools-more-1.3.1.1.js" type="text/javascript" charset="utf-8"></script>
<script src="/assets/js/modal/simple-modal.js" type="text/javascript" charset="utf-8"></script>
	
<style type="text/css">
	.adp-legal,.warnbox-content,.warnbox-c1,.warnbox-c2{display:none;}
	.textboxlist{background-color:white; margin-right:5px;}
	/* fix */ 
	.textboxlist-autocomplete {width: 350px !important;}
</style>

<a href="/routes/ghack" style="font-size:10px;">google hack</a><br/>

Well, go pick your locations
<br/>

<div style="display:none;">
	<a id="toggle_input_map" href="javascript:void(0)">Click on Map</a> |
	<a id="toggle_input_form" href="javascript:void(0)">Text Input</a>
</div>

<div id="route" class="route_input_wrapper">
	<div style="width:380px; float:left;">
		Start Location<br/>
		<input type="text" name="start_location" id="start_location" />
	</div>
	
	<div style="width:380px; float:left;">
		End Location<br/>
		<input type="text" name="end_location" id="end_location" />
	</div>
	<br style="clear:both" />

</div>

<div id="map" class="route_input_wrapper">
	<div style="float:left">
		<div id="route_indicator">
			 <span id="step1" class="start">Tap Map where you're <strong>coming from</strong> or type a location above</span>
			 <span id="stepArrow">-----&gt;</span>
			 <span id="step2" class="end">Tap Map where you're <strong>going</strong> or type a location above</span>
			
			
			 <a href="javascript:void(0)" id="saveRoute">Bookmark<span>It</span></a>
		</div>

		<div id="map_input_steps">
			<div id="step1" class="step">Tap where you're coming from</div>
			<div id="step2" class="step">Tap where you're going</div>
		</div>

		<div id="canvas"></div>
	</div>
	<div id="directionContainer">
		<span class="start">Bartlett</span>
		<div id="directionsPanel" style="width:300px; background-color:white;"></div>
			<span class="end">Amherst Center</span>
	</div>
	<br style="clear:both;"/>
</div>






<style type="text/css">
#map{ margin-top:15px;}
#route {   }
#canvas{ width:600px; height:400px; margin-top:10px;}

.start, .end {padding: 5px; background-color:green; color:white; border-radius:5px;}
#directionContainer .start, #directionContainer .end{ display:block; }

#directionContainer{
	float:left; width:300px; margin-left:20px;
	display:none; margin-top:42px;
}

#directionsPanel div { z-index: 2;}

#saveRoute { padding: 5px; background-color:orange; color:white; border-radius:5px;}


#route_indicator{margin:12px 0 15px 10px; }

#map_input_steps { display:none; height:20px; border:1px solid gray; background-color:green; color:white; padding:5px; }


#step2, #stepArrow, #saveRoute { display:none; }

.step { display:none; }
/*#step1 {display:block;}*/


.simple-modal-footer { margin-top:-20px;}
.tb {
padding: 3px 4px 0;
border: 1px solid #999; height:20px; outline:0; font-size:13px;}
#reminder_entry {display:none;}
/* DIRECTIONS HACK BELOW */
/*.adp-directions{display:none;}*/
</style>


<script type="text/javascript">
// hold state
var ENTRY_STATES = {
	TEXT : 'text',
	MAP  : 'map'
};
var ENTRY_STATE = ENTRY_STATES.TEXT;

// route object
var route = {
	start: null,
	end: null,
	startName: null,
	startEnd: null
};

// google maps
var map = null;
var geocoder;
var directionsService;
var directionsDisplay;

// autocomplete
var startAC;
var endAC;
var start_locations = [
	["280 Hicks way, Amherst MA", "Bartlett", null, "Bartlett"],
	["544 N Pleasant Street, Amherst MA", "Morrill", null, "Morrill"],
	["709 N Pleasant Street, Amherst MA", "Lederle", null, "Lederle"],
	["280 Hicks way, Amherst MA", "Library", null, "Library"],
	["31 S Pleasant Street, Amhrest MA", "Amherst Center", null, "Amherst Center"],
];
var end_locations = start_locations;



	
var mapApp  = {
	mapStates: {
		START: 'start',
		END  : 'end'
	},
	state: 'start',
	startMarker: null,
	endMarker: null,
	infoWindow: null,
	modal: null,
	bookmarkModal: null,
	

	
	saveBookmark: function(){
	
		this.bookmarkModal =  new SimpleModal({"hideHeader":true, "closeButton":false, "btn_ok":"Save","onAppend":function(){
			$("simple-modal").fade("hide");
				setTimeout((function(){ $("simple-modal").fade("show")}), 200 );
				var tw = new Fx.Tween($("simple-modal"),{
				duration: 500,
				transition: 'linear',
				link: 'cancel',
				property: 'top'
			}).start(-400, 35)}});
        this.bookmarkModal.addButton("Save", "btn primary", function(){
        	$j('.simple-modal-footer').prepend("<img src='http://ideaindex.com/images/ajax-loader.gif' style='height:25px; margin:2px 10px -10px 0; '/>");
        	$j('.primary').hide();
			setTimeout(function(){
				$j("#saveRoute").css('background-color', 'green');
				$j("#saveRoute").text("Saved");
	         	mapApp.bookmarkModal.hide();
	         }, 600);
        });
        this.bookmarkModal.addButton("Cancel", "btn");
        this.bookmarkModal.show({
          "model":"modal",
          "title":"New Bookmark",
          "contents":"<br/><img src='http://aux.iconpedia.net/uploads/1601722968.png' style='float:left; height:30px;'/>"+
          // textbox
          "<div style='float:left; margin-left:10px; width:85%;'>"+
          "<input type='text' id='bookmarkNickname' value='Nickname' class='tb' "+
          " style='float:left;margin-top:3px;width:100%;'/>" +
          // reminder toggle
          "<img src='http://icons.iconarchive.com/icons/pixelmixer/basic/48/plus-icon.png' style='height:15px; margin-top:3px; float:left;' />" +
          "<a href='javascript:void(0)' id='reminder_toggle' style='margin: 2px 0 0 5px;float:left;'>Add Reminder</a>"+
          "</div><br style='clear:both;'/>" +
          // reminder
          
          "<div id='reminder_entry'> " +
          "<img src='http://icons.iconarchive.com/icons/custom-icon-design/office/256/calendar-icon.png' style='float:left;height:30px;'/>" +
          "<div style='float:left; margin-left:10px; margin-top:4px;'>"+
          "<select id='reminder_hour'><option>12</option></select> : " +
          "<select id='reminder_minute'><option>00</option></select> " +
          "<select id='reminder_pm'><option>AM</option><option>PM</option></select> </div><br style='clear:both;'/></div><br style='clear:both;'/>"
        }); 
        $j("#reminder_toggle").click(function(){
        	if ($j("#reminder_entry").is(':visible')){
        		$j("#reminder_toggle").text('Add Reminder');
				$j("#reminder_entry").slideUp();
        	} else {
        		$j("#reminder_toggle").text('Cancel Reminder');
				$j("#reminder_entry").slideDown();
        	}
		});
	},
	
	nextStep: function(){
		if (this.state == this.mapStates.START){		
			$j("#stepArrow").fadeIn();
			$j("#step2").fadeIn();
		} else if (this.state == this.mapStates.END){
			$j("#saveRoute").fadeIn();
			this.showModal();
			setTimeout(function(){
				processRoute();
			}, 1200);

		}
	},
	prevStep: function(){
	
	},
	
	
	init: function(){
		this.infoWindow = new google.maps.InfoWindow({ 
			size: new google.maps.Size(150,50)
		});
	},
	
	dropMarker: function(coord, name){
		if (this.state == this.mapStates.START){
			this.clearMarker(this.startMarker);
			route.start = coord;
		
			this.startMarker = this.createMarker(coord, "name", "<b>Location</b><br/>"+coord);
			// enter final state
			if (name){
				$j("#step1").text(name);
			} else {
				startAC.add("Bartlett");
				$j("#step1").text("Bartlett");
			}
			this.nextStep();
			this.state = this.mapStates.END;
		} else if (this.state == this.mapStates.END){
			this.clearMarker(this.endMarker);
			route.end = coord;
			this.endMarker = this.createMarker(coord, "name", "<b>Location</b><br/>"+coord);
			
			endAC.clear();
			if (name){
				$j("#step2").text(name);
			} else {
				endAC.add("Amherst Center");
				$j("#step2").text("Amherst Center");
			}
			this.nextStep();
		}
	},
	
	clearMarkers: function(){
		this.clearMarker(this.startMarker);
		this.clearMarker(this.endMarker);
	},
	
	clearMarker: function(marker){
		if (marker){
			marker.setMap(null);
			marker = null;
		}
	},
	
	createMarker: function(latlng, name, html){

		var contentString = html;
	    var marker = new google.maps.Marker({
	        position: latlng,
	        map: map,
	        zIndex: Math.round(latlng.lat()*-100000)<<5,
	        animation: google.maps.Animation.BOUNCE
	    });
	    
	    
	
	    google.maps.event.addListener(marker, 'click', function() {
	       // this.infoWindow.setContent(contentString); 
	        //this.infoWindow.open(map,marker);
	    });
	    //google.maps.event.trigger(marker, 'click');    
	    return marker;
	},
	
	showModal: function(){
		this.modal = new SimpleModal({"hideHeader":true, "closeButton":false, "btn_ok":"Close window", "width":600,"onAppend":function(){
			$("simple-modal").fade("hide");
				setTimeout((function(){ $("simple-modal").fade("show")}), 200 );
				var tw = new Fx.Tween($("simple-modal"),{
				duration: 400,
				transition: 'linear',
				link: 'cancel',
				property: 'top'
			}).start(-100, 40)}});
		this.modal.show({
          "title":"loading",
          "contents":""
          //"<div style='position:relative; height:300px;'><div style='absolute; bottom:0;'>HIHI</div></div>"
        });
        
        setTimeout(function(){
				mapApp.hideModal();
			}, 1200);
		$j(".simple-modal-footer .btn").hide();
		$j(".simple-modal-footer").append("<img src='http://ideaindex.com/images/ajax-loader.gif' style='height:40px;'/>");
	},
	
	hideModal: function(){
		this.modal.hide();
	}
	

};






// bootstrap this shit
$j(document).ready(function(){
	registerEvents();

	geocoder = new google.maps.Geocoder();
	directionsService = new google.maps.DirectionsService();
	directionsDisplay = new google.maps.DirectionsRenderer();
	initializeMap();	
	initializeAutocomplete();



});

function registerEvents(){
	/*
	$j("#route_button").click(function(){
		route.start = startAC.getValues()[0][0];
		route.end = endAC.getValues()[0][0];
		route.startName = startAC.getValues()[0][1];
		route.endName = endAC.getValues()[0][1];
		
		if (route.start && route.end){
			processRoute();
		}
		$j("#route").slideUp();
		showMap();
	});
	*/
	
	$j("#saveRoute").click(function(){
		mapApp.saveBookmark();
		/*
		mapApp.showModal();
		setTimeout(function(){
			mapApp.hideModal();
			$j("#saveRoute").css('background-color', 'green');
			$j("#saveRoute").text("Saved");
		}, 500);
		*/
	});

	$j("#toggle_input_form").click(function(){
		//$j("#map").slideUp();
		$j("#route").slideDown();
	});
	
	$j("#toggle_input_map").click(function(){
		$j("#route").slideUp();
		showMap();
	});
}

function showMap(){
	$j("#map").slideDown();
	if (map == null){
		initializeMap();
	}
}

function initializeMap(){
	if ($j("#canvas").is(':visible')){
		do_initializeMap();
		geocodeAddress("Amhrest, MA", function(coord){
			setMapTo(coord);
		});
	}

}

function processRoute(){
	// get route and draw to map
	calcRoute(route.start, route.end);
	$j("#directionContainer").show();
	$j("#route_indicator").show();
	$j("#map_input_steps").hide();
	mapApp.clearMarkers();
	
}

function do_initializeMap(){
    var myOptions = {
      zoom: 13,
      center: new google.maps.LatLng(-34.397, 150.644),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('canvas'),
        myOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('directionsPanel'));
	google.maps.event.trigger(map, 'rasterizeMap');
	
	google.maps.event.addListener(map, 'click', function() {
		//infowindow.close();
	});

	google.maps.event.addListener(map, 'click', function(event) {
		mapApp.dropMarker(event.latLng);
	});
	
	google.maps.event.addListener(map, 'zoom_changed', function(e) {
		//console.log(map.getZoom());
  	});
	
	
	/* GET USER POSITION VIA MOBILE GPS */
	/*
	// Try W3C Geolocation (Preferred)
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
      map.setCenter(initialLocation);
    }, function() { 
      handleNoGeolocation(browserSupportFlag);
    });
  // Try Google Gears Geolocation
  } else if (google.gears) {
    var geo = google.gears.factory.create('beta.geolocation');
    geo.getCurrentPosition(function(position) {
      initialLocation = new google.maps.LatLng(position.latitude,position.longitude);
      map.setCenter(initialLocation);
    }, function() {
      handleNoGeoLocation(browserSupportFlag);
    });
  // Browser doesn't support Geolocation
  } else {
    handleNoGeolocation(browserSupportFlag);
  }
  */

}








 
















function setMapTo(coord, bounce){
	var anim = google.maps.Animation.DROP;
	if (bounce){
		anim = google.maps.Animation.BOUNCE;
	}
	if (coord){
		map.setCenter(coord);
		//var src = "http://eric.lubow.org/wp-content/uploads/2009/12/gmap_blue_icon.png";
		var src= "http://cdn3.iconfinder.com/data/icons/freeapplication/png/24x24/Person.png";
		var marker = new google.maps.Marker({
			map:map,
			position: coord,
			icon: src,
			animation: anim
		});
	} else {
		alert('nope');
	}
}

function calcRoute(start, end){
	var request = {
		origin: start,
		destination: end,
		travelMode: google.maps.TravelMode.WALKING
	};
	directionsService.route(request, function(result, status){
		if (status == google.maps.DirectionsStatus.OK){
			directionsDisplay.setDirections(result);
		}
	});
}


function geocodeAddress(address, callback){
	geocoder.geocode({'address': address}, function(results, status){
		if (status == google.maps.GeocoderStatus.OK){
			// if a callback exists, execute it
			if (callback && typeof callback == 'function'){
				callback(results[0].geometry.location);
			}
		} else {
			alert("geocoding error");
		}
	});
}



function initializeAutocomplete(){

	startAC = new $j.TextboxList('#start_location', {max:1, plugins:{autocomplete:{onlyFromValues:true}},bitsOptions: {addOnBlur: true}});
	startAC.plugins['autocomplete'].setValues(start_locations);
	startAC.addEvent('bitBoxAdd', function(bit){
		
		if (mapApp.state == mapApp.mapStates.START && bit.getValue()[0]){
			geocodeAddress(bit.getValue()[0], function(coord){
				mapApp.dropMarker(coord, bit.getValue()[1]);
			});
		}
		
		
	});
	
	endAC = new $j.TextboxList('#end_location', {plugins:{autocomplete:{onlyFromValues:true}},bitsOptions: {addOnBlur: true}});
	endAC.plugins['autocomplete'].setValues(end_locations);
	endAC.addEvent('bitBoxAdd', function(bit){
		if (mapApp.state == mapApp.mapStates.END && bit.getValue()[0]){
			geocodeAddress(bit.getValue()[0], function(coord){
				mapApp.dropMarker(coord, bit.getValue()[1]);
			});
		}
	});
}



</script>
