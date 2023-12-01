/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */
(function ($, Drupal) {
  Drupal.behaviors.linkProcessing = {
    attach: function (context, settings) {
      var sandiegoDomainRegex = /^(https?:\/\/|\/\/)?www\.sandiego\.gov/;

      $('a', context).each(function () {
        var href = $(this).attr('href');

        // Process only if href attribute is present
        if (href) {
          // Add aria-label for PDF links
          if (href.endsWith('.pdf')) {
            var currentText = $(this).text();
            $(this).attr('aria-label', 'PDF document: ' + currentText);
          }

          // Cleanup URL: Strip off the hostname part for sandiego.gov links and remove /index, /index.shtml, /index/index.shtml (with or without anchors)
          var cleanedHref = href.replace(sandiegoDomainRegex, '').replace(/\/index(\.shtml)?(\/index(\.shtml)?)?(#[^\/]*)?$/, '');

          // Update the href attribute with the cleaned URL
          $(this).attr('href', cleanedHref);
        }
      });
    }
  };
})(jQuery, Drupal);


