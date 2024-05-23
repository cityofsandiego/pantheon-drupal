//config should be the name of this file
var config="citycharter.js";

//layout elements
var pageheader="City Charter";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Article.Title";
var colwidths="";
var content = 'The City Charter of the City of San Diego, California, was approved by voters on April 7, 1931, adopted by the State Legislature on April 15, 1931 and filed with the Secretary of State April 24, 1931. This edition includes amendments through the municipal election of November 2006. </p>';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legisdocs/charter.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:citycharter";
var site="documents";
var layout_type="titlelink";
var getfields="DOC_NUM.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";


