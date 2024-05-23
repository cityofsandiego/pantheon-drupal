//config should be the name of this file
var config="mchistory.js";

//layout elements
var pageheader="Municipal Code History Table";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Title";
var colwidths="";
var content = '<p>The City of San Diego Municipal Code History Tables contains the history of each section of the Municipal Code and is organized by Chapter. The History Tables are updated, as needed, as new ordinances are adopted by the City Council.</p>';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legisdocs/munihistory.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:municode_history";
var site="scs_municode_history";
var layout_type="title";
var getfields="TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";


