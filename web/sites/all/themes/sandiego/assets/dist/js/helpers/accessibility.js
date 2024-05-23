/* City of San Diego Code */
var $ = jQuery.noConflict();

/* Make sure the links are set right on the accessibility tools when it's clicked on */
$(function() {
    $('#accessibility').click(function(e) {
        var highContrastEnabled = Cookies.get('highContrastActivated');
        if (typeof highContrastEnabled === 'undefined') {
            $('#high_contrast_switcher_normal_id').addClass('disable_link');
            $('#high_contrast_switcher_high_id').removeClass('disable_link');
        }
        else if (highContrastEnabled === 'false') {
            $('#high_contrast_switcher_normal_id').addClass('disable_link');
            $('#high_contrast_switcher_high_id').removeClass('disable_link');
        }
        else {
            $('#high_contrast_switcher_normal_id').removeClass('disable_link');
            $('#high_contrast_switcher_high_id').addClass('disable_link');
        }

        $("#high_contrast_switcher_normal_id").click(function (e) {
            $('#high_contrast_switcher_normal_id').addClass('disable_link');
            $('#high_contrast_switcher_high_id').removeClass('disable_link');
        });
        $("#high_contrast_switcher_high_id").click(function (e) {
            $('#high_contrast_switcher_normal_id').removeClass('disable_link');
            $('#high_contrast_switcher_high_id').addClass('disable_link');
        });
    });
});

