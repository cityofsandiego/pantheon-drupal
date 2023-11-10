//config should be the name of this file
var config="councilmtgsprev.js";

//layout elements
var pageheader="City Council Meetings";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date.City Council Meeting Documents";
var colwidths="100";
var content="<h3>Previous Years&rsquo; Listing</h3>";
//hidden parameters used in the search form
var sort='<input type="hidden" name="sort" value="">';
var requiredfields="PATH:councildockets|PATH:councilminutes|PATH:councilresults";
var site="scs_council";
var layout_type="date_subsort";
// getfields specifies the metadata to display, plus any other needed metadata
var getfields="DOC_DATE.TITLE.SORTORDER";
var default_query="City";


//parameters to tell javascript what type of page this is
fulltext_search = false;
meta_search = false;
date_based_rows=true;
daterange_search=false;
var loc="legislative_section";
var pageloc='x';
