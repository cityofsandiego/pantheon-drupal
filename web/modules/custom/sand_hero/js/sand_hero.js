/**
 * @file
 * sand_hero.js
 *
 */
const heroURLs = drupalSettings.sandHero;

if (typeof heroURLs !== 'undefined' && heroURLs.length >= 2) {
  const randomIndex = Math.floor(Math.random() * heroURLs.length);
  const heroURL = heroURLs[randomIndex];
  console.log('Available Hero Images: ' + heroURLs);
  console.log('Random Hero Image: ' + heroURL);
  jQuery("#hero-bg-image").css("background-image", "url(" + heroURL + ")");
} else {
  console.log('Only one Hero Image Available');
  // can put a default image here
}