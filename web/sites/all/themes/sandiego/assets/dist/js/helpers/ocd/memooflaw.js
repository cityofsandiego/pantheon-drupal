//config should be the name of this file
var config="memooflaw.js";

//layout elements
var pageheader="Memorandum of Law";
var dropdown_label="City Attorney Legal Documents";
var colnames="Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Attorney No&#46;.Subject";
var colwidths="150.150";
var content = '<strong>Specific Field Search</strong>  - An <a href="' + url + '/city-clerk/officialdocs/legaldocs/ca/mol/advanced.shtml">Advanced Search</a> provides specific field search options for Memoranda of Law.</p><p>A Memorandum of Law issued by the City Attorney&rsquo;s Office is a response to a request or question typically posed by the Mayor, City Council (jointly or separately), any full commission, board, committee, or agency (whether or not Charter based), through that entity\'s executive director or City liaison, City Manager, Assistant City Manager, Deputy City Manager, or Department Director, which narrowly applies the interpretation of the current law to a particular problem or situation.   <a href="' + url + '/city-clerk/officialdocs/legaldocs/ca/mol/details.shtml">More Details about Memoranda of Law...</a></p>';
var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Amemooflaw&layout_type=3colnumlink&getfields=DOC_NUM.DOC_DATE.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=memooflaw.js&proxystylesheet=scs_ocd&q=">Try another search</a>.</p>';
var previousyears = '<p><a href="' + url + '/city-clerk/officialdocs/legaldocs/previousmol.shtml">View Previous Years\' Listings</a></p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:memooflaw";
var site="documents";
var layout_type="3colnumlink";
var getfields="DOCUMENT_URL.DOC_NUM.DOC_DATE.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="DOC_NUM";
var loc="attorney_section";
var pageloc="mol";

