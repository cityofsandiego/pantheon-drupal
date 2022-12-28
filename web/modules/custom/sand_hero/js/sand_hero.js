Drupal.behaviors.sandHero = {
  attach: function (context, settings) {
    y = JSON.stringify(drupalSettings.sandHero.count);
    alert(y);
    x = 1;
  }
}