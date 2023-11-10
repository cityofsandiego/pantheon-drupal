//config should be the name of this file
var config="speakerslips.js";

//layout elements
var pageheader='Meeting Speaker Slips';
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date.Item";
var colwidths="350";
content = '<p>Speaker Slips is a group of forms used by the public to request an opportunity to speak to City Council.  Depending on the individual&#39;s opinion, there are separate forms for "In Favor", and "In Opposition".  There are also "Non-Agenda Public Comment Speaker Slips" for subjects that are not on the docket but are within the jurisdiction of the City Council.  Completed Speaker Slips are made available here by the date of the Council meeting (including Closed Session Meetings, Special City Council Meetings, Redevelopment Agency Meetings and Housing Authority Meetings).</p>';
var newsearch = '';
var previousyears = ''; 
//var previousyears = '<p><a href="https://google.sannet.gov/search?partialfields=&proxyreload=1&num=100&requiredfields=PATH%3Aspeakerslips&getfields=DOC_DATE.DAY.TITLE&sort=date%3AD%3AS%3Ad1&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&layout_type=daydate_subsort&filter=0&site=speakerslips&config=speakerslips.js&proxystylesheet=scs_ocd&fulltext_search=false&q=">Prior years\' attachments</a></p>';

//hidden parameters used in the search form
var sort='<input type="hidden" name="sort" value="">';
var requiredfields="PATH:speakerslips";
var site="speakerslips";
var layout_type="daydate_subsort";
// getfields specifies the metadata to display, plus any other needed metadata
var getfields='DOC_DATE.DAY.TITLE.SORTORDER';
var default_query = "City";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
date_based_rows=true;
daterange_search=false;
var loc="legislative_section";
var pageloc="x";

