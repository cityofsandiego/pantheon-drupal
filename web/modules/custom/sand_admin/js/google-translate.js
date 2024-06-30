/**
 * @file
 * San Diego Admin Module behaviors.
 */
(function(Drupal) {

  'use strict';

  Drupal.behaviors.sandAdminGoogleTranslate = {
    attach: function(context, settings) {

      // Function to alter Google Translate widget content
      const alterTranslateWidget = () => {
        let translateElement = document.querySelector('#google_translate_element .goog-te-gadget-simple');

        if (!translateElement) return;

        // Remove existing content inside the widget
        while (translateElement.firstChild) {
          translateElement.removeChild(translateElement.firstChild);
        }

        // Check if body has specific classes
        let bodyClasses = document.body.className.split(' ');
        let changeColor = !['node-type-outreach', 'node-type-outreach2', 'node-type-application', 'theme-insidesd'].some(cls => bodyClasses.includes(cls));

        // Create and style new link element
        let newLink = document.createElement('a');
        if (!changeColor) {
          newLink.addEventListener('mouseover', function() {
            this.style.color = 'inherit';
          });
        }
        newLink.innerHTML = '<span style="font-size: 0.75rem;font-family: "Open Sans", sans-serif;font-weight: bold;">Translate </span><i class="icon-translate"></i>';
        Object.assign(newLink.style, {
          backgroundColor: 'transparent',
          textDecorationSkipInk: 'none',
          fontWeight: 'bold',
          textDecoration: 'none',
          position: 'relative',
          color: changeColor ? '#fff' : 'inherit',
        });

        translateElement.appendChild(newLink);

        // Hide original Translate span and i elements
        let originalElements = document.querySelectorAll('#google_translate_element > span, #google_translate_element > i');
        originalElements.forEach(el => el.style.display = 'none');
      };

      // Initialize Google Translate
      window.googleTranslateElementInit = () => {
        new google.translate.TranslateElement({
          pageLanguage: 'en',
          layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');

        alterTranslateWidget();
      };

      // Add Google Translate script to the document
      let script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
      document.body.appendChild(script);

    }
  };
}(Drupal));
