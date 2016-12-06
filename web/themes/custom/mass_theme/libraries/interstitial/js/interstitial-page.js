(function ($) {
  'use strict';
  // console.info('interstitial page');

  var $hideTransitionPageCheckbox = $('#hide-transition-page');
  var $continueButton = $('.ma__transition-page__buttons').find('button[type="submit"]');
  var queryString = (function (a) {
    if (a === '') {
      return {};
    }
    var b = {};
    for (var i = 0; i < a.length; ++i) {
      var p = a[i].split('=', 2);
      if (p.length === 1) {
        b[p[0]] = '';
      }
      else {
        b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, ' '));
      }
    }
    return b;
  })(window.location.search.substr(1).split('&'));

  if (window.localStorage.noInterstitial) {
    $hideTransitionPageCheckbox.attr('checked', JSON.parse(window.localStorage.noInterstitial));
  }


  $hideTransitionPageCheckbox.change(function (e) {
    if (window.localStorage) {
      window.localStorage.noInterstitial = this.checked ? true : null;
    }
  });

  $continueButton.click(function (e) {
    e.preventDefault();
    // Default to mass.gov if somehow there is no incoming query parameter
    window.location.href = queryString.continueURL || 'http://www.mass.gov/portal';
  });
})(jQuery);
