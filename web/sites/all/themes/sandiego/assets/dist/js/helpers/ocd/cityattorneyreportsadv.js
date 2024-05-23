//config should be the name of this file
var config="cityattorneyreportsadv.js";

//layout elements
var pageheader="City Attorney Reports";
var dropdown_label="City Attorney Legal Documents";
var colnames="Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Number.Document Type.Subject";
var colwidths="150.150.150";
var content = '<strong>Specific Field Search</strong>  - An <a href="' + url + '/city-clerk/officialdocs/legaldocs/careportsadvanced.shtml">Advanced Search</a> provides specific field search options for Legal Opinions.</p><p>A City Attorney Report is issued by the City Attorney’s Office in response to a request from the Mayor and City Council (jointly), Council Committees, City Manager, Charter-based Commissions, Boards, or Agencies, for a report on the status of the law in any given area, or prepared upon the initiative of the City Attorney or staff when a matter of importance comes to the attention of this Office.  <a href="' + url + '/city-clerk/officialdocs/legaldocs/legalopsdetails.shtml">More Details about City Attorney Reports...</a></p>';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legaldocs/ca/reports/advanced.shtml">Try another search</a>.</p>'; 
//var newsearch = '<p><a href="http://www.sandiego.gov/city-clerk/officialdocs/legaldocs/careportsadvanced.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:cityattorneyreports";
var site="documents";
var layout_type="full";
var getfields="DOC_NUM.DOC_DATE.DOC_SET.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="attorney_section";
var pageloc="careports";

