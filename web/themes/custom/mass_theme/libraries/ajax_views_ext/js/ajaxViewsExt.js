console.info('ajax views extension');
(function ($) {
  Drupal.behaviors.ajaxViewsExt = {
    attach: function(context, settings) {
      $(document).once('views-ajax').ajaxComplete(function (e, xhr, settings) {
        xhr.done(function() {
          console.log("Ajax View Updated: ", arguments);

          // Drupal.announce("Filtered view has been updated, now displaying new items.");
        });
      });
    }
  };
})(jQuery);
