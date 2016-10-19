$(function(){

    // ---- begin formstack reset ------ //
    // see: https://github.com/base2arthur/bootstrap-the-formstack

      // Remove the Formstack styles
      // $('.fsBody link').remove();
      // $('.fsBody style').remove();


      // Update select elements to match Mayflower
      $('select.fsField').each(function(el,i) {

        var $this = $(this),
        $label = $this.siblings( "label[for=" + $this.attr( "id" ) + "]" );

        // add class to label
        $label.addClass('ma__select-box__label');

        // add class to field div container
        $(this).parent().addClass('ma__feedback-form__type');

        // wrap label + input with section.ma__select-box.js-dropdown
        $this.add($label).wrapAll( '<section class="ma__select-box js-dropdown"/>' );

        // 1. add classes to the select element
        // 2. wrap select element with div.ma__select-box__field
        $(this).addClass('ma__select-box__select js-dropdown-select')
               .wrap('<div class="ma__select-box__field" />');

        // get the text value of the first option (used below)
        var firstOptionText = $(this).find('option').first().text();

        // create the div.ma__select-box__link + child spans,
        // this is what is rendered visually in place of the select
        $(this).after('<div class="ma__select-box__link">'
                      + '<span class="js-dropdown-link">'
                      + firstOptionText
                      + '</span><span class="ma__select-box__icon"></span></div>');

      });

      /*
      // Map checkbox form elements to what Mayflower is expecting
       $('.fsOptionLabel > input[type="checkbox"]').each(function(el, i) {
        $(this)
          .parent().wrap('<span class="ma__input-checkbox" />');

        // move checkbox input out from parent label,
        // necessary for custom :before pseudoelement in scss
        $(this)
          .insertBefore($(this).parent());
      });
      */

      // Map radio form elements to what Mayflower is expecting
      $('.fsOptionLabel > input[type="radio"]').each(function(el, i) {
        $(this)
          .parent().wrap('<span class="ma__input-radio" />');

        // move radio input out from parent label,
        // necessary for custom :before pseudoelement in scss
        $(this)
          .insertBefore($(this).parent());
      });

      // Make submit button a big button
      // $('.fsSubmitButton').addClass('usa-button-big');

      // Remove manual styles from all inputs
      // $('input', $('.fsBody')).attr('style', '');

      // Map top error message to what USWDS is expecting // failing
      // CONSIDER: add event listener for dynamic error DOM content that we can hook into here instead of duplicating alert, form styles
      // $('.fsError')
      //   .removeClass('fsError')
      //   .addClass('usa-alert usa-alert-error');

      //   -- app specific overrides -- //

      // HOMEPAGE -- //
      // Add appropriate class to homepage form > radio fieldset
      $('#label46538067').addClass('ma__feedback-form__permission');
      // Add appropriate class to homepage form > name field
      $('#fsRow2504022-2').addClass('ma__feedback-form__name');
      // Add appropriate class to homepage form > email field
      $('#fsRow2504022-3').addClass('ma__feedback-form__email');
      // Add appropriate class to homepage form > feedback field
      $('#fsRow2504022-4').addClass('ma__feedback-form__feedback');
      // Add appropriate class to homepage form > submit
      $('#fsSubmit2504022').addClass('ma__feedback-form__controls');


      // FEEDBACK FORM -- //


    // ---- end formstack reset ------ //

});
