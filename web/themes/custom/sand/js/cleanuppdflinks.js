/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

(function ($, Drupal) {
  Drupal.behaviors.cleanUpPDFLinks = {
    attach: function (context, settings) {
      console.log("cleanUpPDFLinks behavior attached."); // To check if behavior is attached

      $('a[href$=".pdf"]', context).each(function () {
        var $link = $(this);
        var $nextSibling = $link[0].nextSibling;

        // Check if the next sibling node is a text node and contains (PDF)
        if ($nextSibling && $nextSibling.nodeType === Node.TEXT_NODE) {
          var textContent = $nextSibling.nodeValue;

          // Check if the text is a PDF marker and, if so, remove it
          if (textContent.match(/^\s*\([^\)]*PDF[^\)]*\)\s*$/i)) {
            $nextSibling.remove();
          }
        }
      });
    }
  };
})(jQuery, Drupal);
