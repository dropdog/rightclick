(function ($) {
  Drupal.behaviors.Quotes = {
    attach: function (context, settings) {

      $('#block-quotes-block > div.views-rows').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        responsive: {
          0: {
            items: 1
          }
        },
        singleItem: true,
        pagination: false
      })

    }
  };
})(jQuery);