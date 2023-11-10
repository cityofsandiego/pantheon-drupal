//config should be the name of this file
var config="dockets_attach.js";

//layout elements
var pageheader="City Council Meeting Docket (Agenda) Attachments";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Title";
var colwidths="";
var content =  '<b><i><font color="red">This list of attachments is for internal reference only.</font></i></b><p>'
               + 'Below is a list of files uploaded to Documentum for linking as attachments to '
               + 'City Council Meeting Dockets. To embed the URL of one of these attachments in a document, '
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
               + '<ul><li><nobr><b>Copy and paste the base path:</b> http://docs.sandiego.gov/councildockets_attach/</nobr>' 
               + '<li><b>Add the Documentum subfolder, for example:</b> 2007/April/'
               + '<li><b>Add the file name, for example:</b> 04-23-2007 Item 203 Part 1 of 2'
               + '<li><b>Add the PDF suffix:</b> .pdf</ul><p>'
               + '<nobr><b>The example steps above would create the following URL for embedding in the document:</b></nobr> '
               + '<nobr>http://docs.sandiego.gov/councildockets_attach/2007/April/04-23-2007 Item 203 Part 1 of 2.pdf</nobr><p>';

var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Acouncildockets_attach&layout_type=list&getfields=TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_docketattach&config=dockets_att.js&proxystylesheet=scs_ocd&q=">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:councildockets_attach";
var site="scs_docketattach";
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


