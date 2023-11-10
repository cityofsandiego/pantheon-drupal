//config should be the name of this file
var config="councilresos.js";

//layout elements
var pageheader="City Council Resolutions and Ordinances";
var dropdown_label="City Attorney Legal Documents";
var colnames="Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Number.Title/Subject";
var colwidths="150.150";
var content = 'An ordinance is a law adopted by the City Council. Ordinances usually amend, repeal or supplement the Municipal Code; provide zoning specifications; or appropriate money for specific purposes. Most ordinances require two hearings: an introduction, followed later by the final adoption. A resolution is a formal expression of opinion or intention of the City Council. Resolutions usually become effective upon their adoption. ';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legaldocs/ccresos.shtml">Try another search</a>.</p>';

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


