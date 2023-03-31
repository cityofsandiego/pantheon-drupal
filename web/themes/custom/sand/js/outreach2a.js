jQuery(function(){

if (!Modernizr.touch) {
  console.log('if outreach2a')
    jQuery.stellar({
      horizontalScrolling: false,
      //responsive: true
      //verticalOffset: 50
    });
} else {
  console.log('else outreach2a')
  jQuery(".stellar-window").css({"background-attachment": "scroll", "background-position": "50% 50%"});
}
});
