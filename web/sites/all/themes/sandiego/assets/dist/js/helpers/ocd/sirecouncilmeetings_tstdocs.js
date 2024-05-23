//config should be the name of this file
var config="sirecouncilmeetings_tstdocs.js";

//layout elements
var pageheader='City Council Meetings';
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.City Council Meeting Documents";
var colwidths="150";
content = '<p>The Council meeting minutes will be posted on the web after being approved by the City Council. Please check the City Council Results sheet for a summary of the meeting.</p><p>City Council meetings are held Monday and Tuesday of every week except during scheduled Legislative Recesses.  The meetings can be watched on <a href="http://www.sandiego.gov/citytv/">CityTV</a> - Channel 24 on Cox Communications and Time Warner Cable within the San Diego City limits or via <a href="http://www.sandiego.gov/citytv/webstreaming/index.shtml">live webcast</a>.  Below you will find links to <a href="' + url + '/city-clerk/officialdocs/legisdocs/councildocuments.shtml">City Council meeting documents</a>, published for each meeting.  <a href="http://www.sandiego.gov/city-clerk/councilcomm/closedsess/index.shtml">Closed Session Reports</a> are also available for download.</p><a name="legiscal"></a><h4>Annual Legislative Calendar</h4><p><a href="http://www.sandiego.gov/city-clerk/pdf/legiscal.pdf">2011 Legislative Calendar</a><br><a href="http://www.sandiego.gov/city-clerk/pdf/legiscal2012.pdf">2012 Legislative Calendar</a></p><h4>Council Meeting Access and How to Address the Council</h4><p>View <a href="http://www.sandiego.gov/city-clerk/pdf/councilmtgaccess.pdf">information on accessing the City Council meetings and addressing the council</a>, including assistance for the disabled, “Dial-A-Council” and accessing meetings on television and online.</p><p>If you are interested in expressing your interest or comments about an item to be discussed by the City Council in an upcoming meeting, please feel free to complete our <a href="'+ url + '/city-clerk/officialdocs/docketcomment.shtml">Public Comment Form</a>.</p>';
var newsearch = '<p><a href="https://google.sannet.gov/search?partialfields=&proxyreload=1&num=100&requiredfields=PATH%3Acouncildockets%7CPATH%3Acouncilminutes%7CPATH%3Acouncilresults&getfields=DOCUMENT_URL.DOC_DATE.TITLE.SORTORDER&sort=date%3AD%3AS%3Ad1&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=sirecouncilmeetings.js&proxystylesheet=sirefrontend&q=Council+inmeta:DOC_DATE_NUM%3A20110101..20120101">Try another search</a>.</p>';
var previousyears = '<p><a name="dockets"></a><a href="' + url + '/city-clerk/officialdocs/legisdocs/previous.shtml">View Previous Years\' Listings</a></p>';

//hidden parameters used in the search form
var sort='<input type="hidden" name="sort" value="">';
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

