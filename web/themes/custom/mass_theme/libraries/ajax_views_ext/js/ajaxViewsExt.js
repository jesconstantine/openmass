/**
 * @file
 * Extends drupal view AJAX filtering functionality with accessible announcements.
 */
(function ($, Drupal) {

  // @TODO: revisit and confirm this language.
  var FILTERED_ANNOUNCEMENT = "New content loaded. Now displaying a new set of filtered items.";

  Drupal.behaviors.ajaxViewsExt = {
    attach: function(context, settings) {
      // We hook off of the document-level view ajax event
      $(document).once('views-ajax').ajaxComplete(function (e, xhr, settings) {
        xhr.done(function() {
          Drupal.announce(FILTERED_ANNOUNCEMENT);
        });
      });
    }
  };
})(jQuery, Drupal);
