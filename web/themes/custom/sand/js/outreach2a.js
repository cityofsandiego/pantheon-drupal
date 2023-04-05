jQuery(function(){

if (!Modernizr.touch) {
    jQuery.stellar({
      horizontalScrolling: false,
      //responsive: true
      //verticalOffset: 50
    });
} else {
  jQuery(".stellar-window").css({"background-attachment": "scroll", "background-position": "50% 50%"});
}
});
