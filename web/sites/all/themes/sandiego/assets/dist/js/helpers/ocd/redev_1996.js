//config should be the name of this file
var config="redev_1996.js";

//layout elements
var pageheader="1996 Redevelopment Agency Agendas, Minutes &amp; Reports";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Meeting Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Report No&#46;.Title";
var colwidths="150.150";
content = '<strong>Specific Field Search</strong> - An <a href="' + url + '/city-clerk/officialdocs/legisdocs/redevadvanced.shtml">Advanced Search</a> provides specific field search options for Redevelopment Agency).</p><p>The Redevelopment Agency usually meets in City Council Chambers of the City Administration Building, 202 C Street, 12th floor, in downtown San Diego. <a href="http://www.sandiego.gov/city-clerk/pdf/legiscal.pdf">An annual Legislative Calendar</a> is available to view scheduled meetings.  A <a href="' + url + '/redevelopment-agency/pdf/tentativeschedule.pdf">Tentative Schedule</a> (PDF: 29K) is also available to view planned meetings and items. Although the Redevelopment Agency is a separate, legal entity, the City Council serves as its legislative body. The City Council President chairs the Agency, the Mayor is the Executive Director, the City Attorney serves as general counsel, and the City\'s Redevelopment Division serves as staff to the agency.  <a href="' + url + '/city-clerk/officialdocs/legisdocs/aboutredev.shtml">More Details about the Redevelopment Agency Agendas, Minutes and Reports…</a></p><p>Return to the <a href="' + url + '/city-clerk/officialdocs/legisdocs/agencycommmeetings.shtml">City Agency and Commission Meetings</a> page.</p>';
var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&proxyreload=1&num=100&requiredfields=YEAR%3A1996&layout_type=report&getfields=DOC_DATE.DOC_NUM.TITLE&sort=date%3AD%3AS%3Ad1&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_redevelopment&config=redev_1996.js&proxystylesheet=scs_ocd&q=">Try another search</a>.</p>';
var previousyears = '';

//hidden parameters used in the search form
var sort='<input type="hidden" name="sort" value="">';
var requiredfields="YEAR:1996";
var site="scs_redevelopment";
var layout_type="report";
// getfields specifies the metadata to display, plus any other needed metadata
var getfields="DOC_DATE.DOC_NUM.TITLE.SORTORDER";
var default_query = "City";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
date_based_rows=true;
daterange_search=false;
var loc="legislative_section";
var pageloc="x";
