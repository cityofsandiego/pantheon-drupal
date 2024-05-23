/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

(function ($, Drupal) {
  Drupal.behaviors.optimizeLinkProcessing = {
    attach: function (context, settings) {
      var sandiegoDomainRegex = /^(https?:\/\/|\/\/)?www\.sandiego\.gov/;
      var sdgov2DomainRegex = /^(https?:\/\/|\/\/)sdgov2\.lndo\.site/;

      $('a', context).each(function () {
        var $link = $(this);
        var href = $link.attr('href');

        // Process only if href attribute is present
        if (href) {
          // Strip off the sdgov2.lndo.site domain
          href = href.replace(sdgov2DomainRegex, '');
          // Add aria-label for PDF links and modify "(PDF)" text after the link
          if (href.endsWith('.pdf')) {
            var currentText = $link.text();
            $link.attr('aria-label', 'PDF document: ' + currentText);

            // Modify "(PDF)" text node immediately following the link
            var $nextSibling = $link[0].nextSibling;
            if ($nextSibling && $nextSibling.nodeType === Node.TEXT_NODE) {
              var textContent = $nextSibling.nodeValue;
              // Replace only the (PDF) part, keeping the rest of the text
              $nextSibling.nodeValue = textContent.replace(/\s*\([^\)]*PDF[^\)]*\)\s*/, ' ');
            }
          }

          // Remove specific PDF icon image if it exists
          var $pdfIcon = $link.closest('span.file').find('img.file-icon[src$="application-pdf.png"]');
          if ($pdfIcon.length) {
            $pdfIcon.remove();
          }

          // Cleanup URL: Strip off the hostname part for sandiego.gov links and remove /index, /index.shtml, /index/index.shtml (with or without anchors)
          var cleanedHref = href.replace(sandiegoDomainRegex, '').replace(/\/index(\.shtml)?(\/index(\.shtml)?)?(#[^\/]*)?$/, '');

          // Update the href attribute with the cleaned URL
          $link.attr('href', cleanedHref);
        }
      });
    }
  };
})(jQuery, Drupal);
