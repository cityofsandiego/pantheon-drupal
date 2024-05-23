//config should be the name of this file
var config="agencyresosadv.js";

//layout elements
var pageheader="Agency Resolutions and Ordinances";
var dropdown_label="City Attorney Legal Documents";
var colnames="Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Number.Title/Subject";
var colwidths="150.100";
var content = 'These documents are ordinances that have been adopted by the City of San Diego and resolutions that have been adopted by one of the City of San Diego agencies (Housing Authority, Industrial Development Authority, Redevelopment Agency, or Public Facilities Financing Authority). <a href="' + url + '/city-clerk/officialdocs/legaldocs/resosdetails.shtml">More Details about Agency Resolutions and Ordinances...</a> ';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legaldocs/agencies/resos.shtml#adv">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="";
var site="documents";
var layout_type="report";
var getfields="DOC_DATE.DOC_NUM.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="attorney_section";
var pageloc="aresos";
