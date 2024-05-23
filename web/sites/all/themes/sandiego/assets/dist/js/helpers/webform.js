// Map [Enter] key to work like the [Tab] key
// Daniel P. Clark 2014

// Catch the keydown for the entire document
jQuery(document).keydown(function (e) {
    // Set self as the current item in focus
    var
        self = jQuery(':focus'),
        // Set the form by the current item in focus
        form = self.parents('form:eq(0)'),
        focusable;

    // Array of Indexable/Tab-able items
    focusable = form.find('input,a,select,button,textarea,div[contenteditable=true]').filter(':visible');

    function enterKeyFilter(){
        jQuery(':focus').parents('form:eq(0)').each(function(){
            if(enterKeyFilterList.indexOf(this.id) == -1){enterKey();} // >=0 if in list
            return true;
        });
    }

    function enterKey() {
        if (e.which === 13 && !self.is('textarea,div[contenteditable=true],input.form-submit')) { // [Enter] key

            // If not a regular hyperlink/button/textarea
            if (jQuery.inArray(self, focusable) && (!self.is('a,button'))) {
                // Then prevent the default [Enter] key behaviour from submitting the form
                e.preventDefault();
            } // Otherwise follow the link/button as by design, or put new line in textarea

            // Focus on the next item (either previous or next depending on shift)
            focusable.eq(focusable.index(self) + (e.shiftKey ? -1 : 1)).focus();
            return false;
        }
    }

    // We need to capture the [Shift] key and check the [Enter] key either way.
    if (e.shiftKey) {
        enterKeyFilter();
    } else {
        enterKeyFilter();
    }
});

