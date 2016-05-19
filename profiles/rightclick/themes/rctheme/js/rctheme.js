(function ($) {

  "use strict";

  Drupal.behaviors.rctheme_mobileNavMenu = {
    attach: function (context, settings) {
    // For devices smaller than $tab. Show the menu on click.
     if ($(window).width() < 768) {
        $('#block-header-mobilenavbuttondemo', context).click(function(event) {
          $('#block-rc-theme-main-menu > ul').slideToggle('fast');
        });
      }
     }
   };

   Drupal.behaviors.rctheme_styleguide_detailsFallback = {
    attach: function (context, settings) {
      // Show the details tag for non Chrome browsers.
      $('details', context).click(function(event) {
        $('.details-wrapper', $(this)).slideToggle('fast');
      });
     }
   };

})(jQuery);
