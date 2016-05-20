(function ($) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {

      $('.high-slides-owl').owlCarousel({
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