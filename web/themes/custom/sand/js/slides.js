/**
 * @file
 * A JavaScript file for the theme.
 *
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function (Drupal, $) {

  'use strict';
  // To understand behaviors, see https://drupal.org/node/756722#behaviors
  Drupal.behaviors.slides = {
    attach: function (context, settings) {
      $('#flexslider-home').flexslider({
        start: function(slider) {
          var $slides = jQuery("div#flexslider-home .slides li")
          //console.log($slides);
          if ($slides.length > 1) {
            $('.hero__content .view-homepage-slide').attr('style', 'padding-bottom: 3em');
          }
          //console.log("flex started");
          $('div.hero__content').fadeIn('slow');
        }
      });
      // Mobile only slider
      if ( $(window).width() < 480 ) {
        $(".flexslider--mobile").flexslider({
          // controlNav: false,
          animation: "slide",
          smoothHeight: false,
          directionNav: true
        });
      }
      $('.flexslider--default').flexslider({
        animation: "slide",
        slideshow: true
      });
      $('.flexslider--fade').flexslider({
        animation: "fade",
        slideshow: true
      });
    }
  };

  // We pass the parameters of this anonymous function are the global variables
  // that this script depend on. For example, if the above script requires
  // jQuery, you should change (Drupal) to (Drupal, jQuery) in the line below
  // and, in this file's first line of JS, change function (Drupal) to
  // (Drupal, $)
})(Drupal, jQuery);
