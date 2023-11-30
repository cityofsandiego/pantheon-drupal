/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

(function ($, Drupal) {
  Drupal.behaviors.cleanupOldContent = {
    attach: function (context, settings) {

      // Cleaning up URLs
      $('a', context).each(function () {
        var href = $(this).attr('href');
        if (href) {
          // Remove /index, /index.shtml, /index/index.shtml (with or without anchors)
          href = href.replace(/\/index(\.shtml)?(\/index(\.shtml)?)?(#[^\/]*)?$/, '');

          // Update the href attribute
          $(this).attr('href', href);
        }
      });
    }
  };
})(jQuery, Drupal);

