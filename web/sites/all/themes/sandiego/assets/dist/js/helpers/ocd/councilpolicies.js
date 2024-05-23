//config should be the name of this file
var config="councilpolicies.js";

//layout elements
var pageheader="City Council Policies";
var dropdown_label="City Clerk Legal Documents";
var colnames="Policy No&#46;.Title";
var colwidths="150";
var content = '<p>City of San Diego Council Policy contains all City policy statements adopted by resolution of the City Council. Each policy statement includes: a) a brief background description; b) the purpose of the policy; c) the policy statements; d) other criteria or procedural sections as required; and e) cross reference notations as to appropriate provisions in the City Charter, Municipal Code, Administrative Regulations, etc. The Council Policy is organized into policy subject classifications. By selecting the Council Policy Classification Guide, these policy subject classifications can be displayed and specific policies can be selected for viewing. </p><!--p><a href="http://docs.sandiego.gov/councilpolicies/Table of Contents.pdf">Table of Contents</a></p-->';
var newsearch = '<p><a href="https://google.sannet.gov/search?entqr=0&access=p&getfields=DOC_NUM.TITLE&sort=date%3AA%3AR%3Ad1&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&q=&requiredfields=PATH%3Acouncilpolicies&num=100&filter=0&config=councilpolicies.js&ud=1&site=documents&oe=UTF-8&proxystylesheet=scs_ocd&ip=10.9.4.130&=&layout_type=numberlink&start=0l">Try another search</a>.</p>';
var previousyears = '';

//hidden parameters used in the search form
var sort="";
var requiredfields="PATH:councilpolicies";
var site="documents";
var layout_type="numberlink";
var getfields="DOC_NUM.TITLE";
var default_query = "";

//parameters to tell javascript what type of page this is
fulltext_search = true;
meta_search = false;
daterange_search=false;
date_based_rows=false;
var linkfield="DOC_NUM";
var loc="legislative_section";
var pageloc="councilpolicies";


