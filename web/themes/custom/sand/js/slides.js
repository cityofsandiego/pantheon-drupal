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
  Drupal.behaviors.slides = {
    attach: function (context, settings) {
      $('#hero__slides--primary').flexslider({
        controlNav: false,
        customDirectionNav: $(".custom-navigation--primary a")
      });
      $('#hero__slides--secondary').flexslider({
          controlNav: false,
          customDirectionNav: $(".custom-navigation--secondary a")
      });
      $('.flexslider--default').flexslider({
        animation: "slide",
        slideshow: false,
        start: function(slider) {
          var count = $('.total-slides').text(slider.count);
        },
        after: function(slider) {
          $('.current-slide').text(slider.currentSlide+1);
        }
      });
      var counter = '<li class="flex-counter"><span class="current-slide">1</span> / <span class="total-slides"></span></li>';
      $('.flexslider .flex-control-nav').html( counter );
      var index = $('.flexslider li:has(.flex-active)').index('.flex-control-nav li')+1;
      var total = $('.flexslider .flex-control-nav li').length;
      $('.flexslider--thumbnails').flexslider({
        animation: "slide",
        slideshow: false,
        controlNav: false,
        sync: ".flexslider--thumbnails-nav"
      });
      $('.flexslider--thumbnails-nav').flexslider({
        animation: "slide",
        itemWidth: 150,
        itemMargin: 5,
        slideshow: false,
        controlNav: false,
        asNavFor: ".flexslider--thumbnails"
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
    }
  };

  // We pass the parameters of this anonymous function are the global variables
  // that this script depend on. For example, if the above script requires
  // jQuery, you should change (Drupal) to (Drupal, jQuery) in the line below
  // and, in this file's first line of JS, change function (Drupal) to
  // (Drupal, $)
})(Drupal, jQuery);

jQuery(function () {
  if (jQuery('body').hasClass('front')) {
    var $slides = jQuery("div#hero__slides--primary .slides li")
    console.log($slides);
    if ($slides.length > 1) {
      jQuery("div.hero__content").addClass("multi");
      jQuery("div.custom-navigation").removeClass("hidden").fadeIn("slow");
    }
    jQuery("div#hero__slides--primary").removeClass("hidden");
    jQuery("div#get_it_done").removeClass("hidden");
  }
});