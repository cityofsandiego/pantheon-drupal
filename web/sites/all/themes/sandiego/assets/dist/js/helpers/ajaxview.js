/**
 * This function is used by .ajax calls to display a view so as to bypass web page caching for time sensitive views.
 *
 * Example of HTML needed to call activate the JS-Injector that calls this.
 * <div class="ajaxview" data-display="live_upcoming" data-view="december_nights_events" id="ajaxview1">before page load</div>
 *
 * attributes:
 *   class: must be ajaxview
 *   data-view: view name
 *   data-display: view display id
 *   id: used to be replaced by the view output
 *
 * @param viewElement
 */

function CsdAjaxview(viewElement) {
  // Extract out the view-name and display-id from the element
  var view = viewElement.data("view");
  var display = viewElement.data("display");
  var id = viewElement.attr("id");

  // If the element did not have the needed data parameters and id then ignore and return.
  if (typeof view === "undefined" || typeof display === "undefined" || typeof id === "undefined") {
    return;
  }

  // This is the URL to the Drupal hook_menu in sand_tool.
  var url = "/display_view/" + view + "/" + display;

  // The actual ajax call.
  $.ajax(url,
    {
      dataType: "json",  // type of response data
      timeout: 5000,     // timeout milliseconds
      success: function (response, status, xhr) {        // success callback function
        if (response.status === 0) {
          var selector = "#" + id;
          $(selector).html(response.data);
        }
      },
      error: function (jqXhr, textStatus, errorMessage) { // error callback
        console.error(errorMessage);
      }
    });
}

