/**
 * @file
 * sand_hero.js
 *
 */
// alert("running sand_hero.js");
// alert(drupalSettings);
(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.sand_hero = {
    attach: function (context, settings) {
      console.log(context);
      if (context !== document) {
        return;
      }
      var sand_heroTimes = drupalSettings['#attached']['drupalSettings']['sandHero'];
      if (sand_heroTimes) {
        console.log(sand_heroTimes);
        // $.each(drupalSettings.sand_hero, function (i, times) {
        //   var data_selector = 'edit-' + times;
        //   console.log(data_selector)
        // })
        // $("h1").text(sand_heroTimes[0][0]);
        // $(document).load(function() {
        //   // executes when HTML-Document is loaded and DOM is ready
        //   const d = new Date();
        //   let ms = d.getMilliseconds();
        //   console.log("load document: " + ms);
        // });
      }
    }
  }
})(jQuery, Drupal, drupalSettings);
