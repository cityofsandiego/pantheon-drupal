//config should be the name of this file
var config="dockets_att_all.js";

//layout elements
var pageheader="2010 City Council Meeting Docket (Agenda) Attachments";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Title";
var colwidths="";
var content =  '<b><i><font color="red">This list of attachments is for internal reference only.</font></i></b><p>';

var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Acouncildockets_attach&layout_type=list&getfields=TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_docketattach_2010&config=dockets_att_all.js&proxystylesheet=scs_ocd&q=">Try another search</a>.</p>';
var previousyears = '';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:councildockets_attach";
var site="scs_docketattach_2010";
var layout_type="list";
var getfields="TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";
var pageloc="docket_attachments";


