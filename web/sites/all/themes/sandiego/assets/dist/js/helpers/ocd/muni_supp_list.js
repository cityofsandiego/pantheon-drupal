//config should be the name of this file
var config="muni_supp_list.js";
var pageheader="Municipal Code Supplemental";
var dropdown_label="City Clerk Legislative Documents";
var colnames="";
var colwidths="";
var content = 'The Municipal Code is periodically updated as new ordinances are adopted by the City Council. These updates are put together in the form of a Municipal Code Supplement. The supplements are individually numbered in sequential order as they are issued. Municipal Code subscribers and manual owners can print out the pages from each of the supplements and place the revised pages into their manuals. An insert/remove sheet indicating the changes will be included with each supplement, along with the revised pages. <h4>Keeping Municipal Code Updates Current</h4>Use these updates to keep hard copies of the San Diego Municipal Code current. Each update builds on the previous one so it is imperative to complete each update (in its entirety) in chronological order. For additional information, please call (619) 533-4400.';
var previousyears = "";
//hidden parameters used in the search form
var sort="";
var requiredfields="";
var site="default_collection";
var layout_type="munisupp";
var getfields="";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="TITLE";
var loc="legislative_section";
var pageloc="muni_supp_list";
var q="MUNIPATH";
var count=0;

function extract_supp_num(astring)
{
var toarrayraw=astring.split(/[^\d]/);
var boilerplate = "<a href='https://google.sannet.gov/search?proxyreload=1&num=100&layout_type=title&getfields=DOCUMENT_URL.OBJECT_NAME.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_municode_supp&config=municode_supp.js&proxyreload=1&proxystylesheet=scs_ocd&q=&sort=date:A:S:d1&";
  for(i=0; i<toarrayraw.length; i++)
  {
       supplemental_set=toarrayraw[i].match(/^\d+$/);
       if(supplemental_set !=null)
        {
          document.write(boilerplate +"requiredfields=PATH:" + supplemental_set + "&municode_subset=" + supplemental_set + "'>" + supplemental_set + "</a>");
          count++;
          break;
        }

   }
}

function start_column_as_needed()
{
  if(count>15)
  {
    document.write("</ul></td>");
    count=0;
    document.write("<td valign='top'><ul>");
  }
}


//extract_supp_num("Database Result. <b>MUNIPATH</b>. 771. ");


