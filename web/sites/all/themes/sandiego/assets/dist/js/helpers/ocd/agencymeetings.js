//config should be the name of this file
var config="agencymeetings.js";

//layout elements
var pageheader="City Agency &amp; Commission Meetings";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Meeting Date.Title";
var colwidths=".";
content = '';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legisdocs/agencycommmeetings.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort='<input type="hidden" name="sort" value="">';
var requiredfields="";
var site="scs_redevelopment";
var layout_type="date_subsort";
// getfields specifies the metadata to display, plus any other needed metadata
var getfields="DOC_DATE.TITLE.SORTORDER";
var default_query = "City";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
date_based_rows=true;
daterange_search=false;
var loc="legislative_section";

