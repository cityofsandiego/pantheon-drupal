//config should be the name of this file
var config="redevadv.js";

//layout elements
var pageheader="Redevelopment Agency Agendas, Minutes &amp; Reports";
var dropdown_label="City Clerk Legislative Documents";
var colnames="Meeting Date<br><span style=font-weight:normal;>(yyyy-mm-dd)</span>.Report No&#46;.Title";
var colwidths="150.150";
content = '';
var newsearch = '<p><a href="' + url + '/city-clerk/officialdocs/legisdocs/redevadvanced.shtml">Try another search</a>.</p>';

//hidden parameters used in the search form
var sort='';
var requiredfields="";
var site="scs_redevelopment";
var layout_type="report";
// getfields specifies the metadata to display, plus any other needed metadata
var getfields="DOC_DATE.DOC_NUM.TITLE.SORTORDER";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
date_based_rows=false;
daterange_search=true;
var loc="legislative_section";
var pageloc="x";
