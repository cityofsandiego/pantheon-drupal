//config should be the name of this file
var config="sirepdf.js";

//layout elements
var pageheader='<p><img src="http://www.sandiego.gov/graphics/citysealbw.gif" width="72" height="72" border="0" align="left">CITY OF SAN DIEGO<br>COUNCIL MEETING DOCUMENTS</p><p>Printable Version</p>';
var dropdown_label="City Clerk Legislative Documents";
var colnames="Date<!--br><span style=font-weight:normal;>(yyyy-mm-dd)</span-->.City Council Meeting Documents";
var colwidths="150";
content = '<p align="right"><input type="button" value="Close all windows after printing" onClick="javascript:window.close();"></a></p>';
var newsearch = '';
var previousyears = '';

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

