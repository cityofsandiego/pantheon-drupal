//config should be the name of this file
var config="sirecouncilmeetings.js";

//layout elements
var pageheader='City Council Meetings';
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date.City Council Meeting Documents";
var colwidths="150";

content = '';


var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&proxyreload=1&num=100&requiredfields=PATH%3Acouncildockets%7CPATH%3Acouncilminutes%7CPATH%3Acouncilresults&getfields=DOCUMENT_URL.DOC_DATE.TITLE.SORTORDER&sort=date%3AD%3AS%3Ad1&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=sirecouncilmeetings.js&proxystylesheet=sirefrontend&q=Council+inmeta:DOC_DATE_NUM%3A20170101..20180101">Try another search</a>.</p>';
var previousyears = '<p><a name="dockets"></a><a href="' + url + '/city-clerk/officialdocs/legisdocs/previous">View Previous Years\' Listings</a>';

//hidden parameters used in the search form

var sort="date%3AD%3AS%3Ad1";
var requiredfields="PATH:councildockets|PATH:councilminutes|PATH:councilresults";
var site="sire_scs_council";
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
var pageloc="councilmeetings";

