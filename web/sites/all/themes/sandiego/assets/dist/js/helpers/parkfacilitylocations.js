//<![CDATA[
      // this variable will collect the html which will eventually be placed in the side_bar 
      var side_bar_html = ""; 
    
      // arrays to hold copies of the markers and html used by the side_bar 
      // because the function closure trick doesnt work there 
      var gmarkers = []; 

     // global "map" variable
      var map = null;
      

//Map markers credited to Maps Icons Collection http://mapicons.nicolasmollet.com
var library = new google.maps.MarkerImage('/sites/default/files/legacy/park-and-recreation/graphics/parkicon.png');
var shadowLibrary = new google.maps.MarkerImage(
	'/sites/default/files/legacy/public-library/graphics/shadowlibrary.png',
	null,
	null,
	new google.maps.Point(12,35)
	);

// A function to create the marker and set up the event window function 
function createMarker(latlng, branch, html1) {
    var contentString = html1;
    var marker = new google.maps.Marker({
    	title: branch,
        position: latlng,
        map: map,
        icon: library,
        shadow: shadowLibrary,
        zIndex: Math.round(latlng.lat()*-100000)<<5
        });

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString); 
        infowindow.open(map,marker);
        });
    // save the info we need to use later for the side_bar
    gmarkers.push(marker);
    // add a line to the side_bar html
    side_bar_html += '<a href="javascript:myclick(' + (gmarkers.length-1) + ')">' + branch + '<\/a><br>';
}
 
// This function picks up the click and opens the corresponding info window
function myclick(i) {
  google.maps.event.trigger(gmarkers[i], "click");
}

function initialize() {
  // create the map
  var myOptions = {
    zoom: 10,
    center: new google.maps.LatLng(32.8,-117.08),
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById("map_canvas"),
                                myOptions);
 
  google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
        });
      // Read the data from example.xml
      downloadUrl("/sites/default/files/parkfacilitylocations.xml", function(doc) {
        var xmlDoc = xmlParse(doc);
        var markers = xmlDoc.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          // obtain the attribues of each marker
          var lat = parseFloat(markers[i].getAttribute("lat"));
          var lng = parseFloat(markers[i].getAttribute("lng"));
          var point = new google.maps.LatLng(lat,lng);
          var branch = markers[i].getAttribute("branch");
          var addr1 = markers[i].getAttribute("addr1");
		  var addr2 = markers[i].getAttribute("addr2");
		  var phone = markers[i].getAttribute("phone");
		  var facebook = markers[i].getAttribute("facebook");
		  var photo = markers[i].getAttribute("photo");
		  var twitter= markers[i].getAttribute("twitter");
			/*var mon = markers[i].getAttribute("mon");
			var tue = markers[i].getAttribute("tue");
			var wed = markers[i].getAttribute("wed");
			var thu = markers[i].getAttribute("thu");
			var fri = markers[i].getAttribute("fri");
			var sat = markers[i].getAttribute("sat");
			var sun = markers[i].getAttribute("sun");*/

		  if (facebook && twitter){
			var html1= "<strong>" + branch + "</strong><br>" + addr1 + "<br>" + addr2 + "<p>" + phone + "&nbsp;&nbsp;<a href='http://twitter.com/" + twitter + "'><img src='/sites/default/files/legacy/public-library/graphics/twittericon.png' width='25' height='25' alt='" + branch + " twitter link' border='0' align='top'></a>&nbsp;&nbsp;<a href='http://www.facebook.com/" + facebook + "'><img src='/sites/default/files/legacy/public-library/graphics/facebookicon.png' width='25' height='25' alt='" + branch + " facebook link' border='0' align='top'></a><br><p align='center'><img src='/sites/default/files/legacy/public-library/graphics/branches/" + photo + "' width='150' height='113' alt='" + branch + " image' border='0'><br><a href='http://maps.google.com/maps?saddr=&daddr=" + addr1 + " San Diego, CA' target ='_blank'>Directions</a></p>";
			}	
		  else if (facebook){
			var html1= "<strong>" + branch + "</strong><br>" + addr1 + "<br>" + addr2 + "<p>" + phone + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.facebook.com/" + facebook + "'><img src='http://www.sandiego.gov/public-library/graphics/facebookicon.png' width='25' height='25' alt='" + branch + " facebook link' border='0' align='top'></a><br><p align='center'><img src='/sites/default/files/legacy/public-library/graphics/branches/" + photo + "' width='150' height='113' alt='" + branch + " image' border='0'><br><a href='http://maps.google.com/maps?saddr=&daddr=" + addr1 + " San Diego, CA' target ='_blank'>Directions</a></p>";
			}	
	 	  else {
			var html1= "<strong>" + branch + "</strong><br>" + addr1 + "<br>" + addr2 + "<p>" + phone + "<br><p align='center'><a href='http://maps.google.com/maps?saddr=&daddr=" + addr1 + " San Diego, CA' target ='_blank'>Directions</a></p>";
			}
          // create the marker
          var marker = createMarker(point,branch,html1);
        }
        // put the assembled side_bar_html contents into the side_bar div
        document.getElementById("side_bar").innerHTML = side_bar_html;
      });
    }
 
var infowindow = new google.maps.InfoWindow(
  { 
    size: new google.maps.Size(150,50)
  });
    

    // This Javascript is based on code provided by the
    // Community Church Javascript Team
    // http://www.bisphamchurch.org.uk/   
    // http://econym.org.uk/gmap/
    // from the v2 tutorial page at:
    // http://econym.org.uk/gmap/basic3.htm 
//]]>
