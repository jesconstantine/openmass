(function ($, Drupal) {
    Drupal.behaviors.massMap = {
        attach: function (context, settings) {
            var mapId = "main-content";
            var locations = drupalSettings.locations;
            console.log(locations);
            // Using once() to apply the myCustomBehaviour effect when you want to do just run one function.
            $(context).find('#'+mapId).once('#'+mapId).addClass('mass-map-processed').each(function () {
                $(this).height('500px');
                var mapProp= {
                    center:new google.maps.LatLng(42.4072107,-71.3824374),
                    zoom:8
                };
                var map = new google.maps.Map($(this)[0],mapProp);
                var bounds = new google.maps.LatLngBounds();
                var infowindow = new google.maps.InfoWindow();
                // Create the list element:
                var locList = document.createElement('ul');

                for (var key in locations) {
                    if (locations.hasOwnProperty(key)) {
                        var loc = locations[key];
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(loc['location']['lat'],loc['location']['lon'])
                        });
                        marker.setMap(map);

                        //extend the bounds to include each marker's position
                        bounds.extend(marker.position);

                        var locListItem = document.createElement('li');
                        var locAddress = document.createElement('div');

                        locAddress.appendChild(document.createTextNode(loc['address']));
                        locListItem.appendChild(locAddress);

                        google.maps.event.addListener(marker, 'click', (function(marker) {
                            return function() {
                                infowindow.setContent(locAddress);
                                infowindow.open(map, marker);
                            }
                        })(marker));

                        console.log(loc['address']);

                        locList.appendChild(locListItem);
                    }
                }
                //now fit the map to the newly inclusive bounds
                map.fitBounds(bounds);

                document.getElementById(mapId).appendChild(locList);

            });
        }
    };
})(jQuery, Drupal);