// Replaces default hero images. This is called in template files after the
// hero divs.  Also see module sand_hero.
function hero_put_bg_credit() {
	if (typeof hero_items !== "undefined" && hero_items.length > 0) {
		var hero_item = hero_items[Math.floor(Math.random() * hero_items.length)];
		if (typeof hero_item !== "undefined" && hero_item.length > 2) {
			var hero_img_path = "url(" + hero_item[2] + ")";
			jQuery("div.hero__bg").css("background-image", hero_img_path);
      // If the hero_item[1] is empty then remove div (e.g. no caption, no author, etc)
      if (hero_item[1] === "<span class='hero-caption'></span>") {
        jQuery("div.hero--credit").remove();
      } else {
        jQuery("div.hero--credit p").html(hero_item[1]);
      }
		}
	}
}
