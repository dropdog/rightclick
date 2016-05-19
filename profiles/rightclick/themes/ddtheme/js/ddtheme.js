(function ($, Drupal) {

  "use strict";

  /**
   * Responsive navigation tabs.
   * This also supports collapsible navigable is the 'is-collapsible' class is
   * added to the main element, and a target element is included.
   */
  function init(i, tab) {
    var $tab = $(tab);
    var $target = $tab.find('[data-drupal-nav-tabs-target]');
    var isCollapsible = $tab.hasClass('is-collapsible');

    function openMenu(e) {
      $target.toggleClass('is-open');
    }
    
    function handleResize(e) {
      $tab.addClass('is-horizontal');
      var $tabs = $tab.find('.tabs');
      var isHorizontal = $tabs.outerHeight() <= $tabs.find('.tabs__tab').outerHeight();
      $tab.toggleClass('is-horizontal', isHorizontal);
      if (isCollapsible) {
        $tab.toggleClass('is-collapse-enabled', !isHorizontal);
      }
      if (isHorizontal) {
        $target.removeClass('is-open');
      }
    }

    $tab.addClass('position-container is-horizontal-enabled');

    $tab.on('click.tabs', '[data-drupal-nav-tabs-trigger]', openMenu);
    $(window).on('resize.tabs', Drupal.debounce(handleResize, 150)).trigger('resize.tabs');
  }

  /**
   * Initialise the tabs JS.
   */
  Drupal.behaviors.navTabs = {
    attach: function (context, settings) {
      var $tabs = $(context).find('[data-drupal-nav-tabs]');
      if ($tabs.length) {
        var notSmartPhone = window.matchMedia('(min-width: 300px)');
        if (notSmartPhone.matches) {
          $tabs.once('nav-tabs').each(init);
        }
      }
    }
  };

  Drupal.behaviors.ddtheme_mobileNavMenu = {
    // perform jQuery as normal in here
    attach: function (context, settings) {
      // For devices smaller than $tab. Show the menu on click.
      if ($(window).width() < 768) {
        $('#block-header-mobilenavbuttondemo', context).click(function (event) {
          $('#block-rc-theme-main-menu > ul').slideToggle('fast');
        });
      }
    }
  };

})(jQuery, Drupal);
