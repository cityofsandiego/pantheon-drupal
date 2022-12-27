/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function (Drupal, $) {

  'use strict';
  // To understand behaviors, see https://drupal.org/node/756722#behaviors
  Drupal.behaviors.accordion = {
    attach: function (context, settings) {
      /**
       * @todo use hardware acceleration methods instead of
       * jQuery's fadeIn/Out methods.
       * e.g. Velocity.js, animate.css
       */
      $('.js-toggle-accordion').on( 'click', '.accordion__link', function( e ) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $this   = $(this),
            $parent = $this.closest('.accordion'),
            $icon   = $this.children('.toggle-icon');
        // current drawer
        if ( $parent.hasClass('current') ) {
          $parent
            .removeClass('current is-open')
            .children('.accordion__drawer')
            .stop( true, true )
            .slideUp(),
          $icon
            .removeClass('open')  ;
            // new drawer
        } else {
          // show new drawer
          $parent
            .addClass('current is-open')
            .children('.accordion__drawer')
            .stop( true, true )
            .slideDown(function () {
              $('.flexslider').resize();
            }),
          $icon
            .addClass('open');
        }
      });
    }
  };

  // We pass the parameters of this anonymous function are the global variables
  // that this script depend on. For example, if the above script requires
  // jQuery, you should change (Drupal) to (Drupal, jQuery) in the line below
  // and, in this file's first line of JS, change function (Drupal) to
  // (Drupal, $)
})(Drupal, jQuery);
