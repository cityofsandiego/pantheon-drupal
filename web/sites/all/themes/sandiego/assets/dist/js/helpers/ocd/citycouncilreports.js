//config should be the name of this file
var config="citycouncilreports.js";

//layout elements
var pageheader="Reports to the City Council";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date.Report No&#46;.Title/Subject";
var colwidths="100.150";
var content = '<strong>Specific Field Search</strong>  - An <a href="' + url + '/city-clerk/officialdocs/legisdocs/councilreportsadvanced.shtml">Advanced Search</a> provides specific field search options for Reports to the City Council.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:reportstocouncil/2007";
var site="documents";
var layout_type="full";
var getfields="DOC_DATE.OBJECT_NAME.DOC_SET.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="OBJECT_NAME";
var loc="legislative_section";


