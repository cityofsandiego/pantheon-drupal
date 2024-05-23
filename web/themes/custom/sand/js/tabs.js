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
  Drupal.behaviors.tabs = {
    attach: function (context, settings) {
        /**
         * @todo set/check hash in url
         *
         * remove default is-active classes defined in html
         * and set programmatically via js
         */
        function change_tab($this) {
          if (!$this.hasClass('is-active')) {
            var $tabid = $($this).closest('div').attr('id');
            var $bucket = $($this.find('.tabs-list__link').attr('href'));

            // set active tab class
            $('#' + $tabid + ' .' + $this.attr('class')).addClass('is-active');
            $('#' + $tabid + ' #' + $bucket.attr('id')).addClass('is-active');

            // remove active class on other items
            $('#' + $tabid + ' .tabs-list__item').not($this).removeClass('is-active');
            $('#' + $tabid + ' .tabs__bucket').not($bucket).removeClass('is-active');

            // set the hashtag on the url
            if (history.pushState) {
              history.pushState(null, null, '#' + $this.attr('id'));
            } else {
              location.hash = $this.attr('id');
            }
          }
        }
        // set active tab on tab click
        $('.js-tabs-list').on( 'click', '.tabs-list__link', function( e ) {
          e.preventDefault();
          var $this = $(this).closest('.tabs-list__item');
          // set active tab
          change_tab( $this );
        });
    }
  };

  // We pass the parameters of this anonymous function are the global variables
  // that this script depend on. For example, if the above script requires
  // jQuery, you should change (Drupal) to (Drupal, jQuery) in the line below
  // and, in this file's first line of JS, change function (Drupal) to
  // (Drupal, $)
})(Drupal, jQuery);
