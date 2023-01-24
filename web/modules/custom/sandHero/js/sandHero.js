/**
 * @file
 * sand_hero.js
 *
 */
// alert("running sand_hero.js");
// alert(drupalSettings);
(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.sandHero = {
    attach: function (context, settings) {
      console.log(context);
      if (context !== document) {
        return;
      }
      var sandHeroTimes = drupalSettings['#attached']['drupalSettings']['sandHero'];
      if (sandHeroTimes) {
        console.log(sandHeroTimes);
        // $.each(drupalSettings.sandHero, function (i, times) {
        //   var data_selector = 'edit-' + times;
        //   console.log(data_selector)
        // })
        $("h1").text(sandHeroTimes[0]);
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
