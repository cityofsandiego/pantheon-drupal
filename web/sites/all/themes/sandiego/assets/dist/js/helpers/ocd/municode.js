//config should be the name of this file
var config="municode.js";

//layout elements
var pageheader="Municipal Code";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Title";
var colwidths="";
var content = 'The City of San Diego Municipal Code contains all ordinances for the City of San Diego. The Municipal Code is organized by Division. A Table of Contents is provided to facilitate location of specific divisions. The Municipal Code is updated as new ordinances are adopted by the City Council Municipal Code Chapters. </p>';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legisdocs/muni.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:municode";
var site="documents";
var layout_type="title";
var getfields="DOCUMENT_URL.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";



