jQuery('.flexslider--thumbnails').flexslider({
  animation: "slide",
  slideshow: false,
  controlNav: false,
  sync: ".flexslider--thumbnails-nav"
});
jQuery('.flexslider--thumbnails-nav').flexslider({
  animation: "slide",
  itemWidth: 150,
  itemMargin: 5,
  slideshow: false,
  controlNav: false,
  asNavFor: ".flexslider--thumbnails"
});