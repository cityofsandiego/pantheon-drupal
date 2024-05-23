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
  Drupal.behaviors.modal = {
    attach: function (context, settings) {
      $('.gallery-pop-link').magnificPopup({
        type:'inline',
        midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        callbacks : {
          open: function() {
            // gallery pop up
            $('#gallery-pop').flexslider({
              animation: "slide",
              controlNav: false,
              keyboard: true,
              multipleKeyboard: true,
              directionNav: true,
              animationLoop: false,
              slideshow: false,
              itemWidth: 880,
              sync: "#gallery-pop-nav"
            });
           // the synced thumbnail nav
            $('#gallery-pop-nav').flexslider({
              animation: "slide",
              controlNav: false,
              animationLoop: false,
              slideshow: false,
              itemWidth: 80,
              asNavFor: '#gallery-pop'
            });
          }
        }
      });
      $('.js-modal-video').magnificPopup({
        type : 'iframe',
        mainClass : 'mfp-fade'
      });
      $('.popup-modal').magnificPopup({
        type:'inline',
        midClick: true,
        closeBtnInside:true
      });

      // sandiego.js
      $(".popup-modal").click(function() {
        var href = $(this).attr('href');
        if( $(href).has('iframe').length > 0) {
          $(href + " iframe").attr("src", $(href + " iframe").attr("src").replace("autoplay=0", "autoplay=1")); //make the video autoplay after popup
        }
      });
      $.magnificPopup.instance.close = function () {
        try {
          $(".mfp-container iframe").attr("src", $(".mfp-container iframe").attr("src").replace("autoplay=1", "autoplay=0")); //remove autoplay when popup is closed
        } catch (e) {
          // do nothing if this is not a video.
        }
        $.magnificPopup.proto.close.call(this);
      };
      $('.popup-modal').magnificPopup({
        type:'inline',
        midClick: true,
        closeBtnInside:true
      });
    }
  };

  // We pass the parameters of this anonymous function are the global variables
  // that this script depend on. For example, if the above script requires
  // jQuery, you should change (Drupal) to (Drupal, jQuery) in the line below
  // and, in this file's first line of JS, change function (Drupal) to
  // (Drupal, $)
})(Drupal, jQuery);
