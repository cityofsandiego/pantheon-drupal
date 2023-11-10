//config should be the name of this file
var config="councilcomm_att.js";

//layout elements
var pageheader="2016 City Council Committee Meeting Attachments";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date.Title";
var colwidths="150";
var content =  '<b><i><font color="red">This list of attachments is for internal reference only.</font></i></b><p>'
               + 'Below is a list of files uploaded to Documentum for linking as attachments to '
               + 'City Council Committee meeting documents. To embed the URL of one of these attachments in a document, '
               + 'simply click on the link to open the file in your browser, select and copy the URL, '
               + 'and paste the URL into the document. <p>'  
               + '<b>Please note the following information on uploading the attachments:</b> '
               + 'Documentum now feeds the uploaded files through the IDS server into the Google Search Appliance. '
               + 'This process requires incremental batch feeds to move the files live. '
               + 'The batch feeds are performed by the system several times daily.<p>'
               + '<b>If the uploaded attachment is not yet available on this page, it is not yet live.</b></p>'  
               + 'You can embed the attachment URL before it is available by anticipating what the URL will be. '
               + 'Below are steps to help you create the correct URL in advance and embed it in the document '
               + 'so you can upload the document and its attachment at the same time.'
               + '<ul><li><nobr><b>Copy and paste the base path:</b> http://docs.sandiego.gov/councilcomm_agendas_attach/</nobr>' 
               + '<li><b>Add the Documentum subfolder, for example:</b> 2011/'
               + '<li><b>Add the file name, for example:</b> Audit 110107-1'
               + '<li><b>Add the PDF suffix:</b> .pdf</ul><p>'
               + '<b>The example steps above would create the following URL for embedding in the document:</b> '
               + '<nobr>http://docs.sandiego.gov/councilcomm_agendas_attach/2011/Audit 110107-1.pdf</nobr><p>'
               + '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Acouncilcomm_agendas_attach&layout_type=datetitlelink&getfields=DOC_DATE.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_cccmeetings_attach_2015&config=councilcomm_att_all.js&proxystylesheet=scs_ocd&q=">Prior year\'s attachments</a>.</p>';

var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Acouncilcomm_agendas_attach&layout_type=datetitlelink&getfields=DOC_DATE.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_cccmeetings_attach&config=councilcomm_att.js&proxystylesheet=scs_ocd&q=">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:councilcomm_agendas_attach";
var site="scs_cccmeetings_attach";
var layout_type="datetitlelink";
var getfields="DOC_DATE.TITLE";
var default_query = "";
var previousyears = '';

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";
var pageloc="comm_attachments";


