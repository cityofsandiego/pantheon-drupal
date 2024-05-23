//config should be the name of this file
var config="reportstocounciladv.js";

//layout elements
var pageheader="Reports to the City Council";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date<!-- <br><span style=font-weight:normal;>(yyyy-mm-dd)</span> -->.Report No&#46;.Title/Subject";
var colwidths="150.150";
var content = '<p><strong>Specific Field Search</strong>  - An <a href="' + url + '/city-clerk/officialdocs/legisdocs/councilreportsadvanced.shtml">Advanced Search</a> provides specific field search options for Reports to the City Council.</p><p>Reports to the City Council are significant City government documents that transmit information and recommendations to the City Council or to City Council standing committees.  <a href="' + url + '/city-clerk/officialdocs/legisdocs/aboutreports.shtml">More Details about Reports to the City Council</a>...</p>';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legisdocs/councilreportsadvanced.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="";
var site="scs_reportstocouncil";
var layout_type="3colnumlink";
var getfields="DOC_DATE.DOC_NUM.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="DOC_NUM";
var loc="legislative_section";
var pageloc="councilreports";


