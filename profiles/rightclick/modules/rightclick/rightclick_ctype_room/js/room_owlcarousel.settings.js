(function ($) {
  Drupal.behaviors.Room = {
    attach: function (context, settings) {
      $('.room-photos').owlCarousel({
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