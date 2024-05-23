var config="checkboxresults_sire.js";
var sort="";
var header="<h2>Search results</h2>";
var pageheader="Official City Documents";
var site="sire_scs_council";
//var site="documents";
date_based_rows=false;
var getfields="DOCUMENT_URL.DOC_DATE.DOC_NUM.DOC_SET.TITLE";
var colnames="Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.Number.Document Type.Subject";
var colwidths="150.100.200";
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/index.shtml">Try another search</a>.</p>';

fulltext_search = false;
meta_search = false;
var requiredfields="";
content = " ";
daterange_search=false;
var orderfields=new Array();
orderfields[0]="DOC_DATE";
orderfields[1]="DOC_NUM";
orderfields[2]="DOC_SET";
orderfields[3]="TITLE";
var linkfield="TITLE";
var loc="home_section";

