//config should be the name of this file
var config="resos.js";

//layout elements
var pageheader="Resolutions and Ordinances";
var dropdown_label="City Bulletin of Public Notices";
var colnames="Publication Date.Title";
var colwidths="200";
var content = '<strong>Specific Field Search</strong>  - An <a href="' + url + '/city-clerk/officialdocs/notices/noticesadvanced.shtml">Advanced Search</a> provides specific field search options for all City Bulletin of Public Notices.</p> <p>Noticing to concerned citizens, and interested persons of City Council Resolutions and Ordinances. </p> ';
var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:Ordinances-Resolutions&layout_type=datetitlelink&getfields=TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=resos.js&proxystylesheet=scs_ocd&q=">Try another search</a>.</p>';
var previousyears = '';

//hidden parameters used in the search form
var sort="";
var requiredfields="STARTED:TRUE.ENDED:FALSE.PATH:Ordinances-Resolutions";
var site="documents";
var layout_type="datetitlelink";
var getfields="TITLE.DOC_DATE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="OBJECT_NAME";
var loc="bulletin_section";
var pageloc="rando";


