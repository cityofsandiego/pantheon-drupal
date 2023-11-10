 //config should be the name of this file
var config="audit.js";

//layout elements
var pageheader="Audit Committee";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Meeting Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Title";
var colwidths="150.";
content = '<p>Return to the <a href="' + url + '/city-clerk/officialdocs/legisdocs/cccmeetings.shtml">City Council Committee Meetings</a> page.';
var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&proxyreload=1&num=100&requiredfields=PATH%3Accaction_audit%7CPATH%3Accagenda_audit&layout_type=date_subsort&getfields=DOCUMENT_URL.DOC_DATE.TITLE.SORTORDER&sort=date%3AD%3AS%3Ad1&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=audit.js&proxystylesheet=scs_ocd&q=">Try another search</a><br></p>';
//var previousyears = '';
var previousyears = '<p><strong>IMPORTANT NOTICE:</strong><a href="' + url + 'city-clerk/boards-commissions/audit">City Seeking Applications for Audit Committee Public Member</a></p>';

//hidden parameters used in the search form
var sort="date%3AD%3AS%3Ad1&output";
var requiredfields="PATH:ccaction_audit|PATH:ccagenda_audit";
var site="onbase_documents_test";
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
