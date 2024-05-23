//config should be the name of this file
var config="muni_ch07.js";

//layout elements
var pageheader="Municipal Code Chapter 07, Public Utilities and Transportation";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Title";
var colwidths="";
var content = '';
var previousyears = '';
var newsearch = '<p><a href="https://google.sannet.gov/search?site=scs_municode_ch7&partialfields=&requiredfields=PATH%3Amunicode&client=scs_ocd&filter=0&config=muni_ch07.js&layout_type=title&getfields=DOC_NUM.TITLE&proxystylesheet=scs_ocd&output=xml_no_dtd&proxyreload=1&num=100">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="DOC_NUM";
var requiredfields="PATH:municode";
var site="scs_municode_ch7";
var layout_type="title";
var getfields="DOC_NUM.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";
var pageloc = "x";