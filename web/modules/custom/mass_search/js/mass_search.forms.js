/**
 * @file
 * Common JS for google custom search HEADER + MOBILE forms (loads globally)
 * Using Mass.gov custom search engine at cse.google.com
 * - api v1 js code
 * - search results page JS in mass_search.results.js
 */
(function () {
  'use strict';

  if (window.google) {

    /**
     * load the google custom search module
     * - with english language
     * - with minimalist theme
     */
    google.load('search', '1', {language: 'en', style: google.loader.themes.MINIMALIST});

    /** setOnLoadCallback(callback, @BOOLEAN runOnDomLoad) */
    google.setOnLoadCallback(function () {

      /* search engine id */
      var cx = '010551267445528504028:ivl9x2rf5e8';

      /**
       * Set custom search options
       * See: https://developers.google.com/custom-search/docs/js/cselement-reference#opt_options
       */
      var customSearchOptions = {};

      /** autocomplete settings */
      var autoCompleteOptions = {
        maxCompletions: 3
      };
      customSearchOptions['autoCompleteOptions'] = autoCompleteOptions;

      /** HEADER SEARCH FORM */

      /**
       * Creates an instance of the CustomSearchControl object,
       * which represents a Custom Search Element. Calling this
       * constructor initializes the Custom Search service and UI.
       */
      var headerSearchControl = new google.search.CustomSearchControl(cx, customSearchOptions);

      /**
       * Customize search control with available methods
       * See: https://developers.google.com/custom-search/docs/js/cselement-reference#customsearchcontrol-methods
       */
      headerSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);

      /**
       * Draw header search form with draw options
       * See .draw() at: https://developers.google.com/custom-search/docs/js/cselement-reference#csedrawoptions-el
       */
      var headerOptions = new google.search.DrawOptions();

      /**
       * only draw search form (results are handled in mass_search
       * module route teamplte mass-search.html.twig )
       *
       * set search results route and search term query
       */
      headerOptions.enableSearchboxOnly('/search', 'q');

      /**
       * enable autocomplete (see options above: autoCompleteOptions)
       */
      headerOptions.setAutoComplete(true);

      /**
       * Displays the search form (when it exists, IE not on results page).
       * Calling this method is the final step in activating a Custom Search
       * Element object, and it produces the UI and search containers.
       *
       * .draw(selector, options)
       */
      var headerSearchExists = document.getElementById('cse-header-search-form');

      if (headerSearchExists) {
        headerSearchControl.draw('cse-header-search-form', headerOptions);
      }

      // Customize "no results" message
      headerSearchControl.setNoResultsString("Sorry, we couldn't find any results for your query.  Please search for something else.");

      /** MOBILE SEARCH FORM */

      /**
       * Creates an instance of the CustomSearchControl object,
       * which represents a Custom Search Element. Calling this
       * constructor initializes the Custom Search service and UI.
       */
      var mobileSearchControl = new google.search.CustomSearchControl(cx, customSearchOptions);

      /**
       * Customize search control with available methods
       * See: https://developers.google.com/custom-search/docs/js/cselement-reference#customsearchcontrol-methods
       */
      mobileSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);

      /**
       * Draw mobile search form with draw options
       * See .draw() at: https://developers.google.com/custom-search/docs/js/cselement-reference#csedrawoptions-el
       */
      var mobileOptions = new google.search.DrawOptions();

      /**
       * only draw search form (results are handled in mass_search
       * module route teamplte mass-search.html.twig )
       *
       * set search results route and search term query
       */
      mobileOptions.enableSearchboxOnly('/search', 'q');

      /**
       * enable autocomplete (see options above: autoCompleteOptions)
       */

      mobileOptions.setAutoComplete(true);

      /**
       * Displays the search form. Calling this method is the final step
       * in activating a Custom Search Element object, and it produces the
       * UI and search containers.
       *
       * .draw(selector, options)
       */
      mobileSearchControl.draw('cse-search-form-mobile', mobileOptions);

      // Customize "no results" message
      mobileSearchControl.setNoResultsString("Sorry, we couldn't find any results for your query.  Please search for something else.");

    }, true);
  }
}());
