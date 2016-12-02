$(function(){
  $('a[href]').click(function(e) {
    var href = $(this).attr('href');
    if(window.localStorage.noInterstitial && JSON.parse(window.localStorage.noInterstitial)) {
      return;
    }
    // TODO: This is not a valid test to ship. We should use a more sophisticated regular expression or something to cover all scenarios.
    if(href.indexOf('mass.gov') == -1 || href.indexOf('/agencies/')) {
      e.preventDefault();
      window.location = window.location.origin+"/leaving-pilot?continueURL="+this.href;
    }
  });
});
