//config should be the name of this file
var config="citybulletin_pn.js";

//layout elements
var pageheader="City Bulletin of Public Notices";
var dropdown_label="City Bulletin of Public Notices";
var colnames="Publication Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Category.Title";
var colwidths="150.150";
var content = '<strong>Specific Field Search</strong>  - An <a href="' + url + '/city-clerk/officialdocs/notices/noticesadvanced.shtml">Advanced Search</a> provides specific field search options for City Bulletins of public Notice.</p>';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/notices/index.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="STARTED:TRUE.ENDED:FALSE.PATH:citybulletin_publicnotices";
var site="scs_publicnotices";
var layout_type="3coltitlelink";
var getfields="DOC_DATE.PN_CATEGORY.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="bulletin_section";
var pageloc="index";

