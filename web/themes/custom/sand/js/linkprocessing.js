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
      // Get the current hostname
      var currentHostname = window.location.hostname;

      // Define regex patterns for hostnames, including .build
      var sandiegoDomains = /^(https?:\/\/|\/\/)?(www\.)?(sandiego\.gov|sandgov\.build)/;
      var insidesdDomains = /^(https?:\/\/|\/\/)?(www\.)?(insidesandiego\.org|insidesd\.build)/;
      var citynetDomains = /^(https?:\/\/|\/\/)?(citynet\.)(sandiego\.gov|build)/;
      var sdgov2DomainRegex = /^(https?:\/\/|\/\/)?sdgov2\.lndo\.site/;

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
              $nextSibling.nodeValue = textContent.replace(/\s*\([^\)]*PDF[^\)]*\)\s*/, ' ');
            }
          }

          // Remove specific PDF icon image if it exists
          var $pdfIcon = $link.closest('span.file').find('img.file-icon[src$="application-pdf.png"]');
          if ($pdfIcon.length) {
            $pdfIcon.remove();
          }

          // Cleanup URL: If current hostname is www.sandiego.gov or sandgov.build, strip sandiego.gov-related links
          if (currentHostname.match(sandiegoDomains)) {
            href = href.replace(sandiegoDomains, '');
          }

          // If current hostname is insidesandiego.org or insidesd.build or similar, strip insidesd-related links
          if (currentHostname.match(insidesdDomains)) {
            href = href.replace(insidesdDomains, '');
          }

          // If current hostname is citynet.sandiego.gov or citynet.build, strip citynet-related links
          if (currentHostname.match(citynetDomains)) {
            href = href.replace(citynetDomains, '');
          }

          // Cleanup URL: remove /index, /index.shtml, /index/index.shtml (with or without anchors)
          var cleanedHref = href.replace(/\/index(\.shtml)?(\/index(\.shtml)?)?(#[^\/]*)?$/, '');

          // Update the href attribute with the cleaned URL
          $link.attr('href', cleanedHref);
        }
      });
    }
  };
})(jQuery, Drupal);
