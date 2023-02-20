/**
 * @file
 * sand_hero.js
 *
 */

(function ($, Drupal) {
  Drupal.behaviors.heroBgImage = {
    attach: function (context, settings) {
      var myVariable = drupalSettings.sandHero.heroNodeIDs;
      console.log("outside Once");
      $('#hero-bg-image', context).once('heroBgImage').each(function () {
        console.log(myVariable);
        $(this).append("<script>console.log('Hello from Hero Rotation!')</script>");
      });
    }
  };
})(jQuery, Drupal);