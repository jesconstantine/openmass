(function ($, Drupal) {
  'use strict';
  Drupal.behaviors.massMap = {
    attach: function (context, settings) {
      var mapId = '.gmap';
      var locations = drupalSettings.locations;

      // Using once() to apply the myCustomBehaviour effect when you want to do just run one function.
      $(context).find(mapId).once(mapId).addClass('mass-map-processed').each(function () {
        // Set the height so the map is visible.
        $(this).height('500px');
        // Create a map with its center at the center of MA
        var mapProp = {
          center: new google.maps.LatLng(42.4072107, -71.3824374),
          zoom: 8
        };
        var map = new google.maps.Map($(this)[0], mapProp);
        // Keep track of the bounds so we can adjust based on markers.
        var bounds = new google.maps.LatLngBounds();
        // Info windows to label map points
        var infowindow = new google.maps.InfoWindow();
        // Create the list element:

        $('.loclist').append("<ul class='map-list'></ul>");

        // Go over list of locations,.
        for (var key in locations) {
          if (locations.hasOwnProperty(key)) {
            var loc = locations[key];
            // Set the marker of the location.
            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(loc['location']['lat'], loc['location']['lon'])
            });
            marker.setMap(map);

            // extend the bounds to include each marker's position
            bounds.extend(marker.position);

            // Get information about the location.
            var locInfo = loc['titleLink'] + '<div>' + loc['address'] + '</div><div>' + loc['lede'] + '</div>';

            // Add information to the info windo of that marker.
            google.maps.event.addListener(marker, 'click', (function (marker, locInfo) {
              return function () {
                infowindow.setContent(locInfo);
                infowindow.open(map, marker);
              };
            })(marker, locInfo));
            // append our list to our ul.
            $('.map-list').append('<li>' + locInfo + '</li>');
          }
        }
        // now fit the map to the newly inclusive bounds
        map.fitBounds(bounds);
      });
    }
  };
})(jQuery, Drupal);
