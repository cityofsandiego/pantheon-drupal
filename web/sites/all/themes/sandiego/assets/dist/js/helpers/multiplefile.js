Drupal.behaviors.WebformUploadButton = {
  attach: function (context, settings) {

    // Do not show the "Show row weights" link
    jQuery("fieldset.type-of-multiple_file .tabledrag-toggle-weight-wrapper").css("display","none");

    // Table of uploaded files
    jQuery("fieldset.type-of-multiple_file table.sticky-enabled").width("100%");
    jQuery("fieldset.type-of-multiple_file table.sticky-enabled thead tr th:first-child").html("Added Files");

    // Start a grid row
    jQuery("div.webform-component-multiple-file .file-widget.form-managed-file").addClass("row");

    // The Browse file element
    jQuery("div.webform-component-multiple-file input[type='file']").addClass("nine column l-margin-mobile-bs");

    // The Upload file button
    jQuery("div.webform-component-multiple-file input[type='submit']").prop("value", "Upload File").css("padding","12px");
    jQuery("div.webform-component-multiple-file input[type='submit']").addClass("btn btn--tertiary three column l-margin-desktop-ld");

  }
};
