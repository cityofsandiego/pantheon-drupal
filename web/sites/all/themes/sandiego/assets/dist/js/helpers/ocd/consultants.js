//config should be the name of this file
var config="consultants.js";

//layout elements
var pageheader="Consultants";
var dropdown_label="City Bulletin of Public Notices";
var colnames="Publication Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Title";
var colwidths="200";
var content = '<strong>Specific Field Search</strong>  - An <a href="' + url + '/city-clerk/officialdocs/notices/advanced.shtml">Advanced Search</a> provides specific field search options for all City Bulletin of Public Notices.</p> <p>Noticing interested persons of Request for Proposals or Submittal of Qualifications for various consultant or professional services required throughout the City of San Diego. </p> ';
var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:Consultants&layout_type=datetitlelink&getfields=TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=consultants.js&proxystylesheet=scs_ocd&q=">Try another search</a>.</p>';
var previousyears = '';

//hidden parameters used in the search form
var sort="";
var requiredfields="STARTED:TRUE.ENDED:FALSE.PATH:Consultants";
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
var pageloc="consultants";


