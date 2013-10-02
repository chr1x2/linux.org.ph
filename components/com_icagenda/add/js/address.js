function initialize(){
				  
// edit 2.0.4  $(function() {
    $("#jform_address").autocomplete({
      //This bit uses the geocoder to fetch address values
      source: function(request, response) {
        geocoder.geocode( {'address': request.term }, function(results, status) {
          response($.map(results, function(item) {
            return {
              label:  item.formatted_address,
              value: item.formatted_address,
              latitude: item.geometry.location.lat(),
              longitude: item.geometry.location.lng()
            }
          }));
        })
      },
      //This bit is executed upon selection of an address
      select: function(event, ui) {
        var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
        marker.setPosition(location);
        map.setCenter(location);
        $('#jform_coordinate').val(marker.getPosition().lat()+', '+marker.getPosition().lng());
      }
    });
//  });
	
  //Add listener to marker for reverse geocoding
  google.maps.event.addListener(marker, 'drag', function() {
    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
          $('#jform_address').val(results[0].formatted_address);
          $('#jform_coordinate').val(marker.getPosition().lat()+', '+marker.getPosition().lng());
        }
      }
    });
  });
  
});