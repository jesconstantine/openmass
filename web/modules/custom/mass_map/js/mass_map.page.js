(function ($, Drupal) {
    Drupal.behaviors.massMap = {
        attach: function (context, settings) {
            var mapId = "main-content";
            // Using once() to apply the myCustomBehaviour effect when you want to do just run one function.
            $(context).find('#'+mapId).once('#'+mapId).addClass('mass-map-processed').each(function () {
                $(this).height('500px');
                var mapProp= {
                    center:new google.maps.LatLng(42.4072107,-71.3824374),
                    zoom:8
                };
                var map=new google.maps.Map($(this)[0],mapProp);

            });
        }
    };
})(jQuery, Drupal);