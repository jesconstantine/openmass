$(function(){
    // console.log('loaded formstack.js');

    // ---- begin formstack reset ------ //
    // see: https://github.com/base2arthur/bootstrap-the-formstack
    // see / edit styles in scss dir custom/_formstack_reset.scss

      // Remove the Formstack styles
      // $('.fsBody link').remove();
      // $('.fsBody style').remove();

      // Map checkbox form elements to what Mayflower is expecting
      $('.fsOptionLabel > input[type="checkbox"]').each(function(el, i) {
        // move checkbox input out from parent label,
        // necessary for custom :before pseudoelement in scss
        $(this)
          .insertBefore($(this).parent());
      });

      // Map radio form elements to what Mayflower is expecting
      $('.fsOptionLabel > input[type="radio"]').each(function(el, i) {
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
      // Map supporting .showMobile for file upload field to USWDS support text
      // $('.showMobile')
        // .addClass('usa-form-hint usa-additional_text');

    // ---- end formstack reset ------ //

});
