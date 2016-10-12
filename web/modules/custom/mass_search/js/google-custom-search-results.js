/**
 * @file
 * JS for google custom search results page content FORM + RESULTS (loads once)
 * Using Mass.gov custom search engine at cse.google.com
 * - api v1 js code
 * - header and mobile nav search forms js in google-custom-search-forms.js
 */
(function() {
  'use strict';

  console.log(google);

  /**
   * load the google custom search module
   * - with english language
   * - with minimalist theme
   */
  google.load('search', '1', {language: 'en', style: google.loader.themes.MINIMALIST});

  /**  setOnLoadCallback(callback, @BOOLEAN runOnDomLoad) */
  google.setOnLoadCallback(function() {

    var cx = '010551267445528504028:ivl9x2rf5e8'; /**  search engine id */

    /**
     * Set custom search options
     * See: https://developers.google.com/custom-search/docs/js/cselement-reference#opt_options
     */
    var customSearchOptions = {};

    /**  disable search results orderby functionality */
    customSearchOptions['enableOrderBy'] = false;

    /**  autocomplete settings */
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

    /**
     * Customize search control with available methods
     * See: https://developers.google.com/custom-search/docs/js/cselement-reference#customsearchcontrol-methods
    */
    resultsPageSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);


    /**
     * Draw search form with draw options
     * See .draw() at: https://developers.google.com/custom-search/docs/js/cselement-reference#csedrawoptions-el
     */

    var resultsOptions = new google.search.DrawOptions();

    /**
     * search form is a cse search form custom block placed in the
     * pre-conent region for this node only
     * see templates/block/block--csesearchform-2
     */
    resultsOptions.setSearchFormRoot('cse-search-results-form');

    /**
     * enable autocomplete (see options above: autoCompleteOptions)
     */
    resultsOptions.setAutoComplete(true);

    /**
     * Displays the search form. Calling this method is the final
     * step in activating a Custom Search Element object, and it
     * produces the UI and search containers.
     *
     * .draw(selector, options)
     */
    resultsPageSearchControl.draw('cse-search-results', resultsOptions);

    /**
     * Parse URL parameters
     * @return array params - array of parameters from querystring
     */
    function parseParamsFromUrl() {
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
    }

    /**  Get array of the url querystring params */
    var urlParams = parseParamsFromUrl();

    /**  Set param for the search query */
    var queryParamName = 'q';

    /**  If the search param is in the querystring,
     * populate the search form text input with it
     */
    if (urlParams[queryParamName]) {
      resultsPageSearchControl.execute(urlParams[queryParamName]);
    }

  }, true);

}());
