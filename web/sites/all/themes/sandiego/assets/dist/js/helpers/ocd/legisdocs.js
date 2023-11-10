//config should be the name of this file
var config="legisdocs.js";

//layout elements
var pageheader="City Clerk Legislative Documents";
var dropdown_label="All City Clerk Legislative Documents";
var colnames="Date.Number.Document Type.Title";
var colwidths="100.150.150";
var content = '';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legisdocs/index.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="";
var site="scs_legislative_docs";
var layout_type="full";
var getfields="DOC_DATE.DOC_NUM.DOC_SET.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";
var pageloc = 'legisdocs';


