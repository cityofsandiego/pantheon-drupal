//config should be the name of this file
var config="bge.js";

//layout elements
var pageheader="Budget and Government Efficiency  Committee";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Meeting Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Title";
var colwidths="150.";
content = '<p>Return to the <a href="' + url + '/city-clerk/officialdocs/legisdocs/cccmeetings.shtml">City Council Committee Meetings</a> page.';
var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&proxyreload=1&num=100&requiredfields=PATH%3Accaction_bge%7CPATH%3Accagenda_bge&layout_type=date_subsort&getfields=DOCUMENT_URL.DOC_DATE.TITLE.SORTORDER&sort=date%3AD%3AS%3Ad1&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=bge.js&proxystylesheet=scs_ocd&q=">Try another search</a>.<br><strong>2015 documents will display when available.</strong></p>';
var previousyears = '';

//hidden parameters used in the search form
var sort='<input type="hidden" name="sort" value="">';
var requiredfields="PATH:ccaction_bge|PATH:ccagenda_bge";
var site="documents";
var layout_type="date_subsort";
// getfields specifies the metadata to display, plus any other needed metadata
var getfields="DOCUMENT_URL.DOC_DATE.TITLE.SORTORDER";
var default_query = "City";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
date_based_rows=true;
daterange_search=false;
var loc="legislative_section";
var pageloc="x";
