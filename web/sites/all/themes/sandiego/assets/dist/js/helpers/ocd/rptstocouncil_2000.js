//config should be the name of this file
var config="rptstocouncil_2000.js";

//layout elements
var pageheader="2000 Reports to the City Council";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date.Report No&#46;.Title/Subject";
var colwidths="100.150";
var content = '';
var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH:2000&layout_type=3colnumlink&getfields=DOC_NUM.DOC_DATE.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_reportstocouncil&config=rptstocouncil_2000.js&proxystylesheet=scs_ocd">Try another search</a>.</p>';
var previousyears = '';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:2000";
var site="scs_reportstocouncil";
var layout_type="3colnumlink";
var getfields="DOC_NUM.DOC_DATE.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="DOC_NUM";
var loc="legislative_section";
var pageloc="reportstocouncil";


