var config="legalopinions.js";
var default_query = "Legal Opinions";
var sort="";
var requiredfields="PATH:legalopinions";
var layout_type="full";
var pageheader="Municipal Code";
var dropdown_label="City Clerk Legislative Documents";
var site="documents";
var path="legalopinions";
var page="legalopinions";
var getfields="DOC_NUM.DOC_DATE.DOC_SET.TITLE";
var colnames="Date.Number.Document Type.Subject";
var colwidths="100.150.200";
fulltext_search = true;
meta_search = false;
var content = '<strong>Specific Field Search</strong>  - An <a href="legalopsadvanced.shtml">Advanced Search</a> provides specific field search options for Legal Opinions.</p><p>A City Attorney Legal Opinion is a response to a request or question posed by the Mayor and City Council (jointly or individually), Council Committees, Charter section 41 commissions (e.g., Civil Service Commission and Planning Commission), Retirement Board, Housing Authority, Redevelopment Agency (jointly, but not as individuals), or City Manager, Assistant City Manager, Deputy City Manager, or Department Director, that sets forth an opinion with either broad application or important implications.  <a href="http://www.sandiego.gov/city-clerk/officialdocs/legaldocs/legalopsdetails.shtml">More Details about Legal Opinions...</a></p>';
daterange_search=false;
date_based_rows=false;
metafields="Title.TITLE.Opinion Number.DOC_NUM";
var orderfields=new Array();
orderfields[0]="DOC_DATE";
orderfields[1]="DOC_NUM";
orderfields[2]="TITLE";
var linkfield="TITLE";
var loc="attorney_section";

function getformat()
{
  //alert("ho");
  document.write(path);
}

search_page_query="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Alegalopinions&getfields=DOC_NUM.DOC_DATE.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_generic&filter=0&site=documents&config=legalopinions.js&proxystylesheet=scs_prod&q=Legal+Opinions";
default_query="Legal Opinions";

