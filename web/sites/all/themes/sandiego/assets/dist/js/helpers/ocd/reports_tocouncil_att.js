//config should be the name of this file
var config="reports_tocouncil_att.js";

//layout elements
var pageheader="2015 Reports to City Council Attachments";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date.Title";
var colwidths="150";
var content =  '<b><i><font color="red">This list of attachments is for internal reference only.</font></i></b><p>'
               + 'Below is a list of files uploaded to Documentum for linking as attachments to '
               + 'Reports to City Council documents. To embed the URL of one of these attachments in a document, '
               + 'simply click on the link to open the file in your browser, select and copy the URL, '
               + 'and paste the URL into the document. <p>'  
               + '<b>Please note the following information on uploading the attachments:</b> '
               + 'Documentum now feeds the uploaded files through the Sitecaching server into the Google Appliance. '
               + 'This process requires incremental batch feeds to move the files live. '
               + 'The batch feeds are performed by the system several times daily.<p>'
               + '<b>If the uploaded attachment is not yet available on this page, it is not yet live.</b></p>'  
               + 'You can embed the attachment URL before it is available by anticipating what the URL will be. '
               + 'Below are steps to help you create the correct URL in advance and embed it in the document '
               + 'so you can upload the document and its attachment at the same time.'
               + '<ul><li><nobr><b>Copy and paste the base path:</b>  http://docs.sandiego.gov/reportstocouncil_attach/</nobr>' 
               + '<li><b>Add the Documentum subfolder, for example:</b>  2016/'
               + '<li><b>Add the file name, for example:</b> 11-134att7'
               + '<li><b>Add the PDF suffix:</b> .pdf</ul><p>'
               + '<nobr><b>The example steps above would create the following URL for embedding in the document:</b></nobr> '
               + '<nobr> http://docs.sandiego.gov/reportstocouncil_attach/2011/11-134att7.pdf</nobr><p>'               
               + '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH:reportstocouncil_attach&layout_type=dateobjnamelink&getfields=DOC_DATE.OBJECT_NAME&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_rptstocouncil_attach_2010&config=reports_tocouncil_att_all.js&proxystylesheet=scs_ocd&q=">Prior year\'s attachments</a><br>2015 documents will display when available.</p>';

var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH:reportstocouncil_attach&layout_type=dateobjnamelink&getfields=DOC_DATE.OBJECT_NAME&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_rptstocouncil_attach&config=reports_tocouncil_att.js&proxystylesheet=scs_ocd&q=">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:reportstocouncil_attach";
var site="scs_rptstocouncil_attach";
var layout_type="dateobjnamelink";
var getfields="DOC_DATE.OBJECT_NAME";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="OBJECT_NAME";
var loc="legislative_section";
var pageloc="reports_attachments";


