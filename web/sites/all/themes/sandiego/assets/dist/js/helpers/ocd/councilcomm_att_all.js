//config should be the name of this file
var config="councilcomm_att.js";

//layout elements
var pageheader="2015 City Council Committee Meeting Attachments";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date.Title";
var colwidths="150";
var content =  '<b><i><font color="red">This list of attachments is for internal reference only.</font></i></b><p>'                              

var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Acouncilcomm_agendas_attach&layout_type=datetitlelink&getfields=DOC_DATE.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_cccmeetings_attach&config=councilcomm_att_all.js&proxystylesheet=scs_ocd&q=">Try another search</a>.</p>';
var previousyears = '';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:councilcomm_agendas_attach";
var site="scs_cccmeetings_attach";
var layout_type="datetitlelink";
var getfields="DOC_DATE.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";
var pageloc="comm_attachments";


