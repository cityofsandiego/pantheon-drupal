var $ = jQuery.noConflict();

$(document).ready(function () {
    $('.gallery-menu li i.toggle').click(function () {
        //var myId = $(this).prop('id');
        //var itemStatus = sessionStorage.getItem(myId);
        $(this).parent().find('ul').slideToggle('fast', function() {
            //var rightNow = Date.now();
            //sessionStorage.setItem(myId, rightNow);
            $(this).parent().find('i').toggleClass('icon-chevron-right icon-chevron-down');
        });
    });
});
