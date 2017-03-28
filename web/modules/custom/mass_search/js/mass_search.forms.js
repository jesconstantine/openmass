/**
 * @file
 * Common JS for google custom search HEADER + MOBILE forms (loads globally)
 * Using Mass.gov custom search engine at cse.google.com
 * - api v1 js code
 * - search results page JS in mass_search.results.js
 */
(function () {
  'use strict';

  // ****** Mobile Search button should open mobile menu ******
  var mobileSearchButton = document.querySelector('.ma__header__search .ma__header-search .ma__button-search');

  if (mobileSearchButton !== null) {
    mobileSearchButton.addEventListener('click', function (event) {
      event.preventDefault();
      document.querySelector('body').classList.toggle('show-menu');
    });
  }

  if (window.google) {

    /**
     * load the google custom search module
     * - with english language
     * - with minimalist theme
     */
    google.load('search', '1', {language: 'en', nocss: true});

    /** setOnLoadCallback(callback, @BOOLEAN runOnDomLoad) */
    google.setOnLoadCallback(function () {

      /* search engine id */
      var cx = '010551267445528504028:ivl9x2rf5e8';

      /* set string for message when no results are returned */
      var noResultsString = 'Sorry, we couldn\'t find any results for your query.  Please try searching with different words.';

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
       * set search results set size
       * options:
       * - integer between 1-20,
       * - google.search.Search. SMALL||LARGE _RESULTSET (google determines usually 8||16)
       * - google.search.Search.FILETERED_CSE_RESULTSET (google determines, up to 10results, 10 pages)
       */
      headerSearchControl.setResultSetSize(20);

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
      headerSearchControl.setNoResultsString(noResultsString);

      /** MOBILE SEARCH FORM */

      /**
       * Creates an instance of the CustomSearchControl object,
       * which represents a Custom Search Element. Calling this
       * constructor initializes the Custom Search service and UI.
       */
      var mobileSearchControl = new google.search.CustomSearchControl(cx, customSearchOptions);

      /**
       * set search results set size
       * options:
       * - integer between 1-20,
       * - google.search.Search. SMALL||LARGE _RESULTSET (google determines usually 8||16)
       * - google.search.Search.FILETERED_CSE_RESULTSET (google determines, up to 10results, 10 pages)
       */
      mobileSearchControl.setResultSetSize(20);

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
      mobileSearchControl.setNoResultsString(noResultsString);

      /**
       * Creates an instance of the CustomSearchControl object,
       * which represents a Custom Search Element. Calling this
       * constructor initializes the Custom Search service and UI.
       */
      var searchBandSearchControl = new google.search.CustomSearchControl(cx, customSearchOptions);

      /**
       * set search results set size
       * options:
       * - integer between 1-20,
       * - google.search.Search. SMALL||LARGE _RESULTSET (google determines usually 8||16)
       * - google.search.Search.FILETERED_CSE_RESULTSET (google determines, up to 10results, 10 pages)
       */
      searchBandSearchControl.setResultSetSize(20);

      /**
       * Draw header search form with draw options
       * See .draw() at: https://developers.google.com/custom-search/docs/js/cselement-reference#csedrawoptions-el
       */
      var searchBandOptions = new google.search.DrawOptions();

      /**
       * only draw search form (results are handled in mass_search
       * module route teamplte mass-search.html.twig )
       *
       * set search results route and search term query
       */
      searchBandOptions.enableSearchboxOnly('/search', 'q');

      /**
       * enable autocomplete (see options above: autoCompleteOptions)
       */
      searchBandOptions.setAutoComplete(true);

      /**
       * Displays the search form (when it exists, IE not on results page).
       * Calling this method is the final step in activating a Custom Search
       * Element object, and it produces the UI and search containers.
       *
       * .draw(selector, options)
       */
      var searchBandSearchExists = document.getElementById('cse-search-band-search-form');

      if (searchBandSearchExists) {
        searchBandSearchControl.draw('cse-search-band-search-form', searchBandOptions);
      }

      // Customize "no results" message
      searchBandSearchControl.setNoResultsString(noResultsString);

      // Remove class on form for search banner <form>.
      var bannerSearchForm = document.querySelector('.ma__search-banner form.gsc-search-box');
      if (bannerSearchForm !== null) {
        bannerSearchForm.classList.remove('gsc-search-box');
      }

      // Add classes to form parent for search banner <form>.
      var bannerSearchFormParent = document.querySelector('#cse-search-band-search-form');
      if (bannerSearchFormParent !== null) {
        bannerSearchFormParent.classList.add('ma__search-banner__form');
      }

      // Add classes to <input>.
      var bannerInputField = document.querySelector('.ma__search-banner td.gsc-input');
      if (bannerInputField !== null) {
        bannerInputField.classList.add('ma__search-banner__input');
        var bannerTextInput = document.querySelector('.ma__search-banner td.gsc-input input');
        bannerTextInput.classList.remove('gsc-input');
        bannerTextInput.placeholder = 'Search...';
      }

      // Add classes to <button>.
      var bannerSubmitField = document.querySelector('.ma__search-banner td.gsc-search-button');
      if (bannerSubmitField !== null) {
        var bannerSubmitInput = document.querySelector('.ma__search-banner td.gsc-search-button input');
        bannerSubmitField.classList.add('ma__search-banner__button');
        bannerSubmitField.classList.remove('gsc-search-button');
        bannerSubmitInput.placeholder = 'Search...';
      }

      // Add classes to header <form>.
      var headerSearchForm = document.querySelector('.ma__header form.gsc-search-box');
      if (headerSearchForm !== null) {
        headerSearchForm.classList.add('ma__form');
        headerSearchForm.classList.add('js-header-search-form');
      }
      // Add classes to <input>.
      var headerInputField = document.querySelector('.ma__header input.gsc-input');
      if (headerInputField !== null) {
        headerInputField.classList.add('ma__header-search__input');
        headerInputField.placeholder = 'What can we help you find?';
      }

    }, true);
  }
}());
