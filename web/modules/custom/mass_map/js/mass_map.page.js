(function ($, Drupal) {
  'use strict';
  Drupal.behaviors.massMap = {
    attach: function (context, settings) {
      var mapId = '.js-google-map';
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
            var locInfo = '';

            locInfo = '<h2 class="ma__image-promo__title"><span class="ma__decorative-link"><a href="#" class="js-clickable-link">' + loc['titleLink'] + '</a></span></h2>';

            if (loc['address'] != null) {
              locInfo = locInfo + '<div class="ma__image-promo__location"><a class="js-location-listing-link" href="#" role="button">' + loc['address'] + '</a></div>';
            }

            if (loc['lede'] != null) {
              locInfo = locInfo + '<div class="ma__image-promo__description"><section class="ma__rich-text js-ma-rich-text"><p>' + loc['lede'] + '</p></section></div>';
            }

            if (loc['address'] != null) {
              locInfo = locInfo + '<span class="ma__decorative-link"><a href="https://www.google.com/maps/place/' + encodeURIComponent(loc['address']) + '" class="js-clickable-link">Directions&nbsp;<svg aria-hidden="true" id="SvgjsSvg1000" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="17" height="16" viewBox="0 0 17 16"><defs id="SvgjsDefs1001"></defs><path id="SvgjsPath1007" d="M739.199 92.7986L739.199 80L735.9989999999999 80L735.9989999999999 95.9983L751.9979999999999 95.9983L751.9979999999999 92.7986ZM743.294 81.0032L743.305 83.5605L746.6049999999999 83.5737L742.9939999999999 87.1849L744.809 89.0001L748.4259999999999 85.3836L748.4399999999999 88.6956L750.997 88.7058L750.976 83.59129999999999L750.966 81.03389999999999L748.409 81.02349999999998L748.409 81.02369999999999Z " transform="matrix(1,0,0,1,-735,-80)"></path></svg></a></span>';
            }

            locInfo = '<section class="ma__image-promo"><div class="ma__image-promo__details">' + locInfo + '</div></section>';

            // Add information to the info windo of that marker.
            google.maps.event.addListener(marker, 'click', (function (marker, locInfo) {
              return function () {
                infowindow.setContent(locInfo);
                infowindow.open(map, marker);
              };
            })(marker, locInfo));
            // append our list to our ul.
            $('.js-location-listing-results').append(locInfo);
          }
        }
        // now fit the map to the newly inclusive bounds
        map.fitBounds(bounds);
      });
    }
  };
})(jQuery, Drupal);
