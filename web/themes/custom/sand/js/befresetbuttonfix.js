/**
 * Addresses open Drupal core issue that impacts BEF module.
 * Clear search with custom text does not work on view blocks embedded on node pages.
 * Code snippet from comment 73: https://www.drupal.org/project/better_exposed_filters/issues/2996297
 */

(function (Drupal, $) {
  $(document).on("ajaxComplete", function() {
    $('input#edit-reset').on('click keypress', function (event) {
      event.preventDefault();
      $(this).closest('form').find("input[type=text], textarea").val("");
      $(this).closest('form').find('select').val('');
      $(this).closest('form').find('input[type=radio]').prop('checked', false);
      $(this).closest('form').find('input[type=checkbox]').prop('checked', false);

      $(this).closest('form').find('[id^="edit-submit-"]').click();
    });
  });
})(Drupal, jQuery);
