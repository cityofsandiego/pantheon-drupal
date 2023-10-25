/**
 * @file
 * San Diego Admin Module behaviors.
 */
(function (Drupal) {

  'use strict';

  Drupal.behaviors.sandAdminGoogleAnalytics = {
    attach: function (context, settings) {

      // Function to alter Google Translate widget content
      const alterTranslateWidget = () => {
        let translateElement = document.querySelector('#google_translate_element .goog-te-gadget-simple');

        if (translateElement) {
          // Remove existing content inside the widget
          while (translateElement.firstChild) {
            translateElement.removeChild(translateElement.firstChild);
          }

          // Add new content with styling
          let newLink = document.createElement('a');
          newLink.innerHTML = '<span>Translate </span><i class="icon-translate"></i>';
          newLink.style.backgroundColor = 'transparent';
          newLink.style.textDecorationSkipInk = 'none';
          newLink.style.color = '#fff';
          newLink.style.fontSize = '0.75rem';
          newLink.style.fontWeight = 'bold';
          newLink.style.textDecoration = 'none';
          newLink.style.position = 'absolute';  // Changed from 'absolute' to 'inherit'
          newLink.style.fontFamily = 'Open Sans';
          newLink.style.top = '-0.1em'; //
          newLink.style.left = '-2.5em'; //

          newLink.addEventListener('mouseover', function() {
            this.style.color = '#fff';
          });

          translateElement.appendChild(newLink);
        }

        // Hide the original Translate span and i elements
        let originalElements = document.querySelectorAll('#google_translate_element > span, #google_translate_element > i');
        originalElements.forEach(element => {
          element.style.display = 'none';
        });
      };

      // Initialize Google Translate
      window.googleTranslateElementInit = function() {
        new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
        // Make sure to alter the widget after it has initialized
        alterTranslateWidget();
      };

      // Add Google Translate script to the document
      let script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
      document.body.appendChild(script);

      // Wait for the gadget to be loaded
      let interval = setInterval(function () {
        let $gadget = $('.goog-te-gadget', context);
        if ($gadget.length) {
          clearInterval(interval);

          // Update the styles
          $gadget.find('span').css({
            'font-size': '0.75rem'
          });
        }
      }, 100);

    }
  };

} (Drupal));
