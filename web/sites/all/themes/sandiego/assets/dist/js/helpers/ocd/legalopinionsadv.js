//config should be the name of this file
var config="legalopinionsadv.js";
var pageloc='legalops';
//layout elements
var pageheader="Legal Opinions";
var dropdown_label="City Attorney Legal Documents";
var colnames="Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Attorney No&#46;.Subject";
var colwidths="150.150";
var content = '<strong>Specific Field Search</strong>  - An <a href="' + url + '/city-clerk/officialdocs/legaldocs/legalopsadvanced.shtml">Advanced Search</a> provides specific field search options for Legal Opinions.</p><p>A City Attorney Legal Opinion is a response to a request or question posed by the Mayor and City Council (jointly or individually), Council Committees, Charter section 41 commissions (e.g., Civil Service Commission and Planning Commission), Retirement Board, Housing Authority, Redevelopment Agency (jointly, but not as individuals), or City Manager, Assistant City Manager, Deputy City Manager, or Department Director, that sets forth an opinion with either broad application or important implications.  <a href="http://www.sandiego.gov/city-clerk/officialdocs/legaldocs/legalopsdetails.shtml">More Details about Legal Opinions...</a></p>';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legaldocs/legalopsadvanced.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:legalopinions";
var site="documents";
var layout_type="report";
var getfields="DOC_NUM.DOC_DATE.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="attorney_section";
var pageloc="legalops";


