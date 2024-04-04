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
  Drupal.behaviors.foundation = {
    attach: function (context, settings) {
      $(document).foundation();

      //$('.header .header-second .tbm-main .dropdown > a').once().prepend('<i class="icon-chevron-down hide-on-mobile"></i>');
      $(once('tbm-chevrons', '.header .header-second .tbm-main .tbm-item--has-dropdown > a')).prepend('<i class="icon-chevron-down hide-on-mobile"></i>');

      //$('.header .header-second .tbm-main .tbm-nav.level-0 > li:first-child a').once().replaceWith('<a href="/" class="home-link"><i class="icon-home hide-on-mobile"></i></a>');
      $(once('tbm-home', '.header .header-second .tbm-main .tbm-nav.level-0 > li:first-child a')).replaceWith('<a href="/" class="home-link"><i class="icon-home hide-on-mobile"></i></a>');
    }
  };

  // We pass the parameters of this anonymous function are the global variables
  // that this script depend on. For example, if the above script requires
  // jQuery, you should change (Drupal) to (Drupal, jQuery) in the line below
  // and, in this file's first line of JS, change function (Drupal) to
  // (Drupal, $)
})(Drupal, jQuery);
