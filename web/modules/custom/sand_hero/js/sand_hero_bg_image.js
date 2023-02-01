/**
 * @file
 * sand_hero.js
 *
 */

(function ($, Drupal) {
  Drupal.behaviors.heroBgImage = {
    attach: function (context, settings) {
      var myVariable = drupalSettings.sandHero.heroNodeIDs;
      console.log(myVariable);
      $('#hero-bg-image', context).once('heroBgImage').each(function () {
        $(this).append("<script>console.log('Hello from Hero Rotation!')</script>");
      });
    }
  };
})(jQuery, Drupal);