var MYMAP = {
  map: null,
	bounds: null
}


MYMAP.init = function(selector, latLng, zoom) {
  var myOptions = {
    zoom:zoom,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
panControl: true,
    panControlOptions: {
        position: google.maps.ControlPosition.RIGHT_BOTTOM
    },
    zoomControl: true,
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.SMALL,
        position: google.maps.ControlPosition.RIGHT_BOTTOM
    },
    
    streetViewControl: true,
    streetViewControlOptions: {
        position: google.maps.ControlPosition.RIGHT_BOTTOM
    }
  }
  	this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
	this.bounds = new google.maps.LatLngBounds();
	this.points = [];
	this.markers = []; 
	this.infos = [];
	this.infoBubbles = [];
}

MYMAP.placeMarkers = function(filename, activeLoc, zipLoc, postRegion) {
	jQuery.get(filename, function(xml){
		var zin =90;
		jQuery(xml).find("marker").each(function(){
			var region = jQuery(this).find('region').text();
			var name = jQuery(this).find('name').text();
			var address = jQuery(this).find('address').text();
			var address2 = jQuery(this).find('address2').text();
			var details = jQuery(this).find('details').text();
			var hours = jQuery(this).find('hours').text();
			var hours2 = jQuery(this).find('hours2').text();
			var phone = jQuery(this).find('phone').text();
			var url = jQuery(this).find('url').text();
			var id = jQuery(this).find('id').text();
			var range = jQuery(this).find('range').text();
			
			if(region==postRegion) {
			// create a new LatLng point for the marker
			var lat = jQuery(this).find('lat').text();
			var lng = jQuery(this).find('lng').text();
			var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
			
			// extend the bounds to include the new point
			MYMAP.bounds.extend(point);
			
			var marker = new google.maps.Marker({
				position: point,
				map: MYMAP.map,
				icon: '/wp-content/themes/justsalad/js/marker-green-'+id+'.png',
				zIndex: zin
			});
			zin--;
			MYMAP.markers.push(marker); 

			var html='<div style="font: 11px/15px Helvetica, Arial, sans-serif; color: #777;"><h2 style="padding: 0 0 10px 0; margin: 0;">'+name+'</h2><div style="float: left; width: 130px; margin-right: 15px;">'+address;
			
			if(address2!="") {
				html=html+'<br />'+address2;
			}
			html = html+'<br />'+details+'<h3 style="color: #71D000; padding: 0; margin: 10px 0 0 0;">Hours:</h3>'+hours+'<br />'+hours2+'</div><div style="float: left; width: 100px;"><h3 style="color: #71D000; padding: 0; margin: 0;">Phone:</h3>'+phone+'<br /><br />';
			if(url!="") { 
				html = html+'<a href="'+url+'" style="color: #71D000; font-weight: bold;">Store Bio and Photos</a></div>';
			}
			if(range!="") {
				html = html+'<div style="clear: both; margin-top: 8px;"><br /><h3 style="color: #71D000; padding: 0; margin: 10px 0 0 0;">Delivery Range:</h3>'+range+'</div>';
			}
			html = html+'</div>';
			
			MYMAP.infos.push(html);
			var infoBubble = new InfoBubble({
			  maxWidth: 250,
			  minWidth: 250,
			  content: html,
			  shadowStyle: 1,
			  padding: 10,
			  borderRadius: 0,
			  arrowSize: 10,
			  backgroundColor: 'rgb(255,255,255)',
			  borderWidth: 2,
			  borderColor: '#71d000',
			  disableAutoPan: true,
			  arrowPosition: 75,
			  backgroundClassName: 'test',
			  arrowStye: 2
			});

			MYMAP.infoBubbles.push(infoBubble);
			
			//Add event listeners for all others
			google.maps.event.addListener(marker, 'click', function() {
				infoBubble.setContent(html);
				for( j=0;j<MYMAP.infoBubbles.length; j++ ) {
				 	MYMAP.infoBubbles[j].close(MYMAP.map, marker);
				 }
				infoBubble.open(MYMAP.map, marker);
				MYMAP.map.setCenter(marker.position);
				MYMAP.map.panBy(-20,-70);
				
			});
			}
	});

	/* Add Marker for the user's current location */		
	//FOR TESTING LOCALITY
	var b = true;
	if((activeLoc<0 || activeLoc>=MYMAP.markers.length) && b) {
        function hasPosition(position) {
			//alert(position);
            if(position.coords) {
				var point = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				find_closest_marker(position.coords.latitude, position.coords.longitude);
			}
			else {
				
				var point = new google.maps.LatLng(position.lat(), position.lng());
				find_closest_marker(position.lat(), position.lng());
				
			}
            // extend the bounds to include the new point
			MYMAP.bounds.extend(point);
		
			//if(zipLoc>=0) { MYMAP.map.fitBounds(MYMAP.bounds); }
		
			

			if(zipLoc>0) {
				marker = new google.maps.Marker({
					position: point,
					map: MYMAP.map,
					icon: '/wp-content/themes/justsalad/js/marker-purple-circle.png',
					title: "Your Search Point Is Here"
				});
			}
		}
		//if no HTML nav.geo support, force support (IE8)
		if(!navigator.geolocation) {
			jQuery.webshims.setOptions('geolocation', {
            confirmText: '{location} would like to know your location.'
        	});
			jQuery.webshims.setOptions({
				waitReady: false
			});
      		jQuery.webshims.polyfill('geolocation');
        	
		}
		 
		var mobile = (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
    	if(zipLoc<0 && mobile) {
			navigator.geolocation.getCurrentPosition(hasPosition);
		}
		else {
			if(!mobile && zipLoc<0) {
				if(postRegion==2) { zipLoc="30-34+Cochrane+St+Hong+Kong";}
				//else if(postRegion==3) { }
				else {
					zipLoc="320+Park+Avenue,+New+York,+NY";	
				}
			}
			geocoder = new google.maps.Geocoder();
			geocoder.geocode( {'address': String(zipLoc)}, function(results, status) {
  			if (status == google.maps.GeocoderStatus.OK) {
				position = results[0].geometry.location;
				console.log(position);
			}
				
			  hasPosition(position);
			});
	  
		}
    }
	else if(activeLoc>-1 && activeLoc<MYMAP.markers.length) {
		//open the default location
		 var infoBubble = new InfoBubble({
			  maxWidth: 250,
			  minWidth: 250,
			  content: "",
			  shadowStyle: 1,
			  padding: 10,
			  borderRadius: 0,
			  arrowSize: 10,
			  backgroundColor: 'rgb(255,255,255)',
			  borderWidth: 2,
			  borderColor: '#71d000',
			  disableAutoPan: true,
			  arrowPosition: 75,
			  backgroundClassName: 'test',
			  arrowStye: 2
			});
			
		MYMAP.infoBubbles.push(infoBubble);
		infoBubble.setContent(MYMAP.infos[activeLoc]);
		infoBubble.open(MYMAP.map, MYMAP.markers[activeLoc]);
		MYMAP.markers[activeLoc].setZIndex(100); 
		jQuery("#location-"+activeLoc).slideDown();
		jQuery("#expand-"+activeLoc).attr("src", "/wp-content/themes/justsalad/images/minus.png");
	}
	else {
	var infoBubble = new InfoBubble({
			  maxWidth: 250,
			  minWidth: 250,
			  content: "",
			  shadowStyle: 1,
			  padding: 10,
			  borderRadius: 0,
			  arrowSize: 10,
			  backgroundColor: 'rgb(255,255,255)',
			  borderWidth: 2,
			  borderColor: '#71d000',
			  disableAutoPan: true,
			  arrowPosition: 75,
			  backgroundClassName: 'test',
			  arrowStye: 2
			});
		MYMAP.infoBubbles.push(infoBubble);
		infoBubble.setContent(MYMAP.infos[0]);
		infoBubble.open(MYMAP.map, MYMAP.markers[0]);
		MYMAP.markers[0].setZIndex(100);
		jQuery("#location-0").slideDown();
		jQuery("#expand-0").attr("src", "/wp-content/themes/justsalad/images/minus.png");
	}

//MYMAP.map.fitBounds(MYMAP.bounds);

	});

}

function rad(x) {return x*Math.PI/180;}

function find_closest_marker(lat,lng) {
    var R = 6371;
    var distances = [];
    var closest = -1;
    for( i=0;i<MYMAP.markers.length; i++ ) {
        var mlat = MYMAP.markers[i].position.lat();
        var mlng = MYMAP.markers[i].position.lng();
        var dLat  = rad(mlat - lat);
        var dLong = rad(mlng - lng);
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        distances[i] = d;
        if ( closest == -1 || d < distances[closest] ) {
            closest = i;
        }
    }
   var infoBubble = new InfoBubble({
			  maxWidth: 250,
			  minWidth: 250,
			  content: "",
			  shadowStyle: 1,
			  padding: 10,
			  borderRadius: 0,
			  arrowSize: 10,
			  backgroundColor: 'rgb(255,255,255)',
			  borderWidth: 2,
			  borderColor: '#71d000',
			  disableAutoPan: true,
			  arrowPosition: 75,
			  backgroundClassName: 'test',
			  arrowStye: 2
			});
	MYMAP.infoBubbles.push(infoBubble);
	infoBubble.setContent(MYMAP.infos[closest]);
	infoBubble.open(MYMAP.map, MYMAP.markers[closest]);
	MYMAP.markers[closest].setZIndex(100);
	jQuery("#location-"+closest).slideDown();
	jQuery("#expand-"+closest).attr("src", "/wp-content/themes/justsalad/images/minus.png");
	MYMAP.map.setCenter(MYMAP.markers[closest].position);
	MYMAP.map.panBy(-20,-70);

}

