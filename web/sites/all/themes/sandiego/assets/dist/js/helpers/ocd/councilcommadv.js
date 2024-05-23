//config should be the name of this file
var config="councilcommadv.js";

//layout elements
var pageheader="City Council Committee Meetings";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date.Title";
var colwidths="150";
var content = '<strong>Specific Field Search</strong> - An <a href="' + url + '/city-clerk/officialdocs/legisdocs/cccmeetingsadvanced.shtml">Advanced Search</a> provides specific field search options for all City Council Committee Meeting documents.</p>';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legisdocs/cccmeetings/advanced.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="";
var site="documents";
var layout_type="titlelink";
var getfields="DOC_DATE.TITLE.SORTORDER";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=true;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";


