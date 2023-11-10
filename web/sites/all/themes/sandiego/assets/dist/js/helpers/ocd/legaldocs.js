//config should be the name of this file
var config="legaldocs.js";

//layout elements
var pageheader="City Attorney Legal Documents";
var dropdown_label="";
var colnames="Date.Number.Document Type.Title/Subject";
var colwidths="100,200";
var content = '';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legaldocs/ca/index.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="";
var site="documents";
var layout_type="report";
var getfields="DOC_DATE.DOC_NUM.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="attorney_section";


