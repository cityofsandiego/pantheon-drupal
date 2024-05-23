/*
 * Change background image size based on the image and the width of the window.
 *
 * The logic:
 * 1. On Small screen background size: "auto 100%"
 * 2. On Large screen background size: "100% auto" unless they added override
 * 3. Override says when screen is < adjWidth but larger than small screen size use the given adjustments.
 */

function resizedw(label) {
  $(".stellar-windows").each(function () {
    var divWidth = $(this).width();
    var javaScriptSelector = $(this).attr("id");
    var selector = "#" + $(this).attr("id");

    // The default size for larger screens and no overrides.
    var background_size = "cover";
    var min_height = "300px";

    // See if there are any overrides on this image for min-height.
    var minHeight = $(selector).attr("data-sand-min-height");
    if (minHeight) {
      min_height = minHeight;
    }

    // if we are on a larger screen
    var backSize = $(selector).attr("data-sand-background-size");
    if (backSize) {
      background_size = backSize;
    }
    if (window.matchMedia("(min-width: 48em)").matches) {
      var adjWidth = $(selector).attr("data-sand-adjustment-width");
      if (adjWidth && (divWidth < adjWidth)) {
        // If on this image they put in an overrides for a smaller width.
        /*var backSize = $(selector).attr("data-sand-background-size");
        if (backSize) {
          background_size = backSize;
        }*/
        // Set min-height for smaller width (used to really fine tune)
        var adjHeight = $(selector).attr("data-sand-adjustment-height");
        if (adjHeight) {
          min_height = adjHeight + "px";
        }
      }
    }
    else {
      // We are on a smaller screen
      min_height = "200px";
      background_size = "auto 100%";
      // If they have entered a full width on mobile use that other wise auto 100%.
      var fullWidthOnMobile = $(selector).attr("data-sand-full-width-on-mobile");
      if (fullWidthOnMobile) {
        background_size = fullWidthOnMobile;
      }
    }

    // Now actually set the style on the image with the variables set in the above logic.
    $(selector).css("background-size", background_size);
    $(selector).css("min-height", min_height);

    // // Debugging logs
    // var d = new Date();
    // var fd = d.toLocaleTimeString();
    // var ratio = $(selector).attr("data-stellar-background-ratio");
    // console.log(fd + " " + label + ": in img.onload for id: " + selector + ". min-height: " + min_height + ". size: " + background_size + ". Ratio: " + ratio);

  });
}

var resizeIt = true;
jQuery(function () {
  // Just resize for non-mobile every 200ms so that we don't fire while dragging.
  if (!Modernizr.touch) {
    resizedw("page-load");
    window.onresize = function () {
      if (resizeIt) {
        resizeIt = false;
        setTimeout(function () {
          resizeIt = true;
          resizedw("resize");
        }, 200);
      }
    };

  }
});

// jQuery(document).ready(function() {
//   function headerAlert() {
//     var headerHeight = jQuery("div#header-alert").height();
//     var menuToggle = jQuery("div#header-alert").height() + 15;
//     if (jQuery(window).width() >= 768) {
//       jQuery("div#outer-wrap").css("margin-top",headerHeight+"px");
//       jQuery(".menu-toggle").css("top","1em");
//     } else {
//       jQuery("div#outer-wrap").css("margin-top","0px");
//       jQuery(".menu-toggle").css("top",menuToggle+"px");
//     }
//   }
//   headerAlert();
//   jQuery(window).resize(headerAlert);
// });

// function getPosition ( element ) { v... by Brabon, Daniel Boone
//
//   function getPosition(element) {
//     var xPosition = 0;
//     var yPosition = 0;
//
//     while(element) {
//       xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
//       yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
//       element = element.offsetParent;
//     }
//
//     return { x: xPosition, y: yPosition };
//   }

