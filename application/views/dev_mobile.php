<div data-role="page" data-theme="c" id="home">


<style type="text/css">
	.adp-legal,.warnbox-content,.warnbox-c1,.warnbox-c2{display:none;}
	.textboxlist{background-color:white; margin-right:5px;}
	/* fix */ 
	.textboxlist-autocomplete {width: 350px !important;}
</style>


<script type="text/javascript">
//var availableRoutes = [{'Bartlett', 'Morrill', 'Lederle', 'Library', 'Amherst Center'];
var availableRoutes = <?= json_encode($routes); ?>;
//	console.log(availableRoutes);


$j('#home').live('pagecreate',function(){

	$j("#start_location").autocomplete({
		minLength: 0,
		source: availableRoutes,
		focus: function(event, ui){
			$j('#start_location').val(ui.item.label);
			return false;
		},
		select: function(event, ui){
			$j('#start_location').val(ui.item.label);
			
			geocodeAddress(ui.item.address, function(coord){
				mapApp.dropMarker(coord, ui.item.label);
			});
			
			
		}
	}).data( "autocomplete" )._renderItem = function( ul, item ) {
		return $j( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( "<a>" + item.label + "</a>" )
			.appendTo( ul );
	};
	
	
	$j("#end_location").autocomplete({
		minLength: 0,
		source: availableRoutes,
		focus: function(event, ui){
			$j('#end_location').val(ui.item.label);
			return false;
		},
		select: function(event, ui){
			$j('#end_location').val(ui.item.label);
			
			geocodeAddress(ui.item.address, function(coord){
				mapApp.dropMarker(coord, ui.item.label);
			});
			
			
		}
	}).data( "autocomplete" )._renderItem = function( ul, item ) {
		return $j( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( "<a>" + item.label + "</a>" )
			.appendTo( ul );
	};
	
	$j("#start_location, #end_location").focus(function(){
		$j('html,body').animate({
			scrollTop: $j("#start_location").offset().top - 20
		}, 500);
	});
	
	$j("#directions_section h1").bind('click', function(){
		$j('html,body').animate({
			scrollTop: $j('#directions_section h1').offset().top - 5
		}, 500);
	});
	
	$j("#resetRoute").click(function(){
		window.location = '/';
	});
	
});


</script>


<div data-role="header" data-theme="f" data-position="inline">
	<h1>Home</h1>
	<a href="/routes" data-icon="star">Routes</a>
	<a href="/friends" data-icon="check">Friends</a>
</div>
  <div data-role="content">

<div id="topSection">
 <span>Find your bus the easy way</span>
</div>



<div id="route" class="route_input_wrapper">

<div style="width:130px; float:left;">
		Start Location<br/>
		<input type="text" name="start_location" id="start_location"  data-inline="true" />
	</div>
	
	<div style="width:130px; float:left; margin-left:20px;">
		End Location<br/>
		<input type="text" name="end_location" id="end_location" data-inline="true" />
	</div>
	<br style="clear:both" />


</div>

<div data-role="collapsible" id="map_section">
	<h1>Or tap the map</h1>
	<div id="map" class="route_input_wrapper">
		<div>
			<div id="route_indicator">
				 <span id="step1" class="start">Tap Map where you're <strong>coming from</strong> or type a location above</span>
				 <span id="stepArrow">-----&gt;</span>
				 <span id="step2" class="end">Tap Map where you're <strong>going</strong> or type a location above</span>
			</div>
	
			<div id="map_input_steps">
				<div id="step1" class="step">Tap where you're coming from</div>
				<div id="step2" class="step">Tap where you're going</div>
			</div>
	
			<div id="canvas"></div>
		</div>
	</div>
</div>
<div data-role="collapsible" data-collapsed="false" id="directions_section" style="display:none;">
	<h1>Directions</h1>
	<img src="/assets/images/dummy_route.png"/>
	<!--
<div id="directionContainer">
		<span class="start">Bartlett</span>
		<div id="directionsPanel" style="background-color:white;">
		Please select a route
		</div>
			<span class="end">Lederle</span>
	</div>
-->
</div>
<!-- <a href="javascript:void(0)" data-role="button" id="saveRoute">Bookmark<span>It</span></a> -->
<a href="/home/bookmark" id="bookmarkRoute" data-rel="dialog" data-role="button" style="display:none;">Bookmark It</a>
<a href="javascript:void(0)" id="resetRoute" data-rel="dialog" data-role="button" style="display:none;">Reset Route</a>

  </div>
  <!-- /Content -->
  <div data-role="footer" data-theme="f">
    <div class="ui-bar">
    	<a href="/home/logout" data-icon="gear"  data-iconpos="notext"></a>
    <!--
 <a href="contact.php" data-role="button" data-icon="plus" data-theme="f" rel="external">Contact</a>
     <a href="" data-role="button" data-icon="star" data-theme="f">Facebook</a>
     <a href="" data-role="button" data-icon="star" data-theme="f">Twitter</a>
-->
    </div>
  </div>
  <!-- /Footer --> 



<style type="text/css">
#map{  }
#route {   }
#canvas{ width:101%; height:250px; margin-top:-8px; margin-left:-13px;}

.start, .end {padding: 5px; background-color:green; color:white; border-radius:5px; font-size:12px;}
#directionContainer .start, #directionContainer .end{ display:block; }

#directionContainer{
	width:100%;display:none;
}

#directionsPanel div { z-index: 2;}



#route_indicator{}

#map_input_steps { display:none; height:20px; border:1px solid gray; background-color:green; color:white; padding:5px; }


#step1, #step2, #stepArrow { display:none; }

.step { display:none; }
/*#step1 {display:block;}*/


.simple-modal-footer { margin-top:-30px;}
.adp-directions {width:100%;}

#start_location,#end_location, #start_location:focus,#end_location:focus  {outline:none;}

.tb {
padding: 3px 4px 0;
border: 1px solid #999; height:20px; outline:0; font-size:13px;}
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

/*
	locations:
	- Bartlett
	- Morill
	- Library
	- Franklin
	- Van Meter
	- Town Houses
	- AmherstPO
	- Amherst
	- Mall
*/
var start_locations = [
	["280 Hicks way, Amherst MA", "Bartlett", null, "Bartlett"],
	["544 N Pleasant Street, Amherst MA", "Morrill", null, "Morrill"],
	["709 N Pleasant Street, Amherst MA", "Lederle", null, "Lederle"],
	["280 Hicks way, Amherst MA", "Library", null, "Library"],
	["31 S Pleasant Street, Amhrest MA", "Amherst Center", null, "Amherst Center"],
];
var end_locations = start_locations;



function toRad(deg)
{
	var multiplier = 0.0174532925;
	var rad = deg * multiplier;
	return rad
}

function getDistance(a, b)
{
	lat1 = toRad(a.lat());
	lon1 = toRad(a.lng());
	lat2 = toRad(b.lat());
	lon2 = toRad(b.lng());
	
	var d_lat = lat2 - lat1;
	var d_lon = lon2 - lon1;
	
	
	var temp = (Math.pow(Math.sin(d_lat/2.0), 2) + 
				Math.cos(lat1) * Math.cos(lat2) * 
				Math.pow(Math.sin(d_lon/2.0), 2)
			    );

	
	var distance = 3956 * 2 * Math.atan2(Math.sqrt(temp), Math.sqrt(1-temp));

	distance = distance.toFixed(2);
	
	return distance;
}

function calculateClosestLocation(coord){
	//console.log(availableRoutes);
}


	
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
			//$j("#stepArrow").fadeIn();
			//$j("#step2").fadeIn();
		} else if (this.state == this.mapStates.END){
			//$j("#saveRoute").fadeIn();
			this.showModal();
			setTimeout(function(){
				processRoute();
				$j("#directions_section").show();
				$j("#bookmarkRoute").show();
				$j("#resetRoute").show();
				setTimeout(function(){
					$j("body,html").animate({scrollTop: $j("#directions_section h1").offset().top-5}, 500);
				}, 200);
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
		calculateClosestLocation(coord);
		
		if (this.state == this.mapStates.START){
			this.clearMarker(this.startMarker);
			route.start = coord;
			
		
			this.startMarker = this.createMarker(coord, "name", "<b>Location</b><br/>"+coord);
			// enter final state
			if (name){
				//$j("#step1").text(name);
				$j("#start_location").val(name);
			} else {
				//startAC.add("Bartlett");
				$j("#start_location").val("Bartlett");
				//$j("#step1").text("Bartlett");
			}
			this.nextStep();
			this.state = this.mapStates.END;
		} else if (this.state == this.mapStates.END){
			this.clearMarker(this.endMarker);
			route.end = coord;
			this.endMarker = this.createMarker(coord, "name", "<b>Location</b><br/>"+coord);
			
			//endAC.clear();
			if (name){
				$j("#end_location").val(name);
				//$j("#step2").text(name);
			} else {
				$j("#end_location").val("Lederle");
				//endAC.add("Lederle");
				//$j("#step2").text("Lederle");
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
			}).start(-100, 0)}});
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
//$j('#home').live('pagecreate',function(){
$j(document).ready(function(){
	registerEvents();
	geocoder = new google.maps.Geocoder();
	directionsService = new google.maps.DirectionsService();
	directionsDisplay = new google.maps.DirectionsRenderer();
	initializeMap();	
	//initializeAutocomplete();



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
		setMapTo(new google.maps.LatLng(42.389551, -72.528133));
		/*
geocodeAddress("Amhrest, MA", function(coord){
			setMapTo(coord);
		});
*/
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
      zoom: 14,
      center: new google.maps.LatLng(42.389551, -72.528133),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('canvas'),
        myOptions);
    directionsDisplay.setMap(map);
    //directionsDisplay.setPanel(document.getElementById('directionsPanel'));
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
		travelMode: google.maps.TravelMode.DRIVING
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

</div>
<!-- /Home -->