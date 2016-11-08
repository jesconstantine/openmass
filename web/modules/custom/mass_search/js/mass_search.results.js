/**
 * @file
 * Extends Drupal object with mass custom js objects
 *
 * Loads google custom search results page FORM + RESULTS (loads once)
 * Using Mass.gov custom search engine at cse.google.com
 * - api v1 js code
 * - header and mobile nav search forms js in mass_search.forms.js
 */

(function(Drupal) {
  'use strict';

  /**
   * Extends Drupal object with mass custom js object
   * @namespace
   */
  Drupal.mass = Drupal.mass || {};

  // Contains custom methods related to mass_search.
  Drupal.mass.search = Drupal.mass.search || {};

  // Contains custom methods to improve mass_search accessibility (a11y).
  Drupal.mass.search.a11y = Drupal.mass.search.a11y || {};

  // Contains custom generic helper methods
  Drupal.mass.helpers = Drupal.mass.helpers || {};

  // Confirm that we have access to the google object which is returned by
  // mass_search js external library google.com/jsapi
  if (window.google) {

    /**
     * Loads the google custom search module
     * - with english language
     * - with minimalist theme
     *
     * @return google.search module
     */
    google.load('search', '1', {language: 'en', style: google.loader.themes.MINIMALIST});
  }

  Drupal.behaviors.massSearchResults = {};
  Drupal.behaviors.massSearchResults.attach = function (context) {

    if (window.google.search) {
      /**
       * setOnLoadCallback(callback, @BOOLEAN runOnDomLoad)
       */
      google.setOnLoadCallback(function () {

        // Define google custom search engine id.
        var cx = '010551267445528504028:ivl9x2rf5e8';

        // Set custom search options.
        var customSearchOptions = {};

        // Disable search results orderby functionality.
        customSearchOptions['enableOrderBy'] = false;

        // Set autocomplete settings.
        var autoCompleteOptions = {
          maxCompletions: 3
        };
        customSearchOptions['autoCompleteOptions'] = autoCompleteOptions;

        /**
         * Creates an instance of the CustomSearchControl object,
         * which represents a Custom Search Element. Calling this
         * constructor initializes the Custom Search service and UI.
         */
        var resultsPageSearchControl = new google.search.CustomSearchControl(cx, customSearchOptions);

        // Customize search control with available methods.
        resultsPageSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);


        // Draws search form with draw options.
        var resultsOptions = new google.search.DrawOptions();

        // Set search form element.
        // See markup in mass_search module templates/mass_search.html.twig
        resultsOptions.setSearchFormRoot('cse-search-results-form');

        // Enable autocomplete (see options above: autoCompleteOptions).
        resultsOptions.setAutoComplete(true);

        // Display the search form + search results.
        // .draw(selector, options)
        resultsPageSearchControl.draw('cse-search-results', resultsOptions);

        // Get array of the url querystring params.
        var urlParams = Drupal.mass.helpers.parseParamsFromUrl();

        // Define param for the search query.
        var queryParamName = 'q';

        // Execute the search
        if (urlParams[queryParamName]) {
          resultsPageSearchControl.execute(urlParams[queryParamName]);
        }

        /**
         * @todo Consider using drupal announce to notify assistive devices
         * that search results are loading / have finished for searches that
         * happen from search results page (IE when there is no page load)
         *
         * see .setSearchStartingCallback() && .setSearchCompleteCallback() :
         * https://developers.google.com/custom-search/docs/js/cselement-reference#customsearchcontrol-methods
         */

      }, true); // google.search onLoadCallback
    } // endif window.google.search
  }; // Drupal.behaviors.massSearchResults.attach
  /**

  /**
   * Parses URL parameters
   * @return array params - array of parameters from querystring
   */
  Drupal.mass.helpers.parseParamsFromUrl = function () {
    var params = {};
    var parts = window.location.search.substr(1).split('&');
    for (var i = 0; i < parts.length; i++) {
      var keyValuePair = parts[i].split('=');
      var key = decodeURIComponent(keyValuePair[0]);
      params[key] = keyValuePair[1] ?
          decodeURIComponent(keyValuePair[1].replace(/\+/g, ' ')) :
          keyValuePair[1];
    }
    return params;
  };
})(Drupal);
