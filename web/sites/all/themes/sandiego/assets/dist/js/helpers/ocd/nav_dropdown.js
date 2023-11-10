var loc;
if (loc == null || loc.length == 0) {loc = "x";}

//nav_dropdown is dependent on the same "loc" variable used to control the header

//utility function to make sure the var we are testing exists and has a value
//I was unable to get the dropdown to work in the dynamic and static pages at the
//same time without this convoluted get_page function and without adding the following:
//PLEASE confirm var pageloc; is present in the javascript of each dropdown.html file:

//var pageloc;

//It can't be uncommented in this js file or it breaks the dropdown in google
//I still think I'm missing something and that it could be coded more simply

function get_page()
{
 var localpage;
 if(pageloc==null || pageloc.length==0)
{
  localpage="x";
}
else
{
  localpage=pageloc;
}
  return localpage;
}

//function build_dropdown is called by the dynamic xslt file. 
//It determines what type of page you are building and calls the appropriate function.
//If you are adding a dropdown for static pages, dropdown.html should call their appropriate function directly.
//
//To add a dropdown to dynamic pages in another area, such as public notices
//copy the implementation here for attorney_section.
//You should be able to find the value for "loc" around line 45, in the header
//section of a static page. For notices it is "bulletin_section".


function build_dropdown()
{


 if(loc == "attorney_section")
 {
   build_legal_dropdown();
 }
 if(loc=="legislative_section")
 {
   build_legis_dropdown();
 }
  if(loc=="bulletin_section")
 {
   build_bulletin_dropdown();
 }
 if(loc == "x")
 {
   
document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/legisdocs/" selected>Unimplemented Feature</option>');
 }
}


//function build_legis_dropdown is called directly by /city-clerk/officialdocs/legisdocs/includes/dropdown.html

function build_legis_dropdown()
{
		var localpage=get_page();
document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/legisdocs/" selected>Find other Legislative Documents</option>');

if(localpage != 'charter')
{ 
document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/legisdocs/charter.shtml">City Charter</option>');
}

if(localpage != 'municode')
{ 	
document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/legisdocs/muni.shtml">Municipal Code</option>');
}

if(localpage != 'councilmeetings') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&proxyreload=1&num=100&requiredfields=PATH%3Acouncildockets%7CPATH%3Acouncilminutes%7CPATH%3Acouncilresults&getfields=DOCUMENT_URL.DOC_DATE.TITLE.SORTORDER&sort=date%3AD%3AS%3Ad1&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=sirecouncilmeetings.js&proxystylesheet=sirefrontend&q=Council+inmeta:DOC_DATE_NUM%3A20160101..20170101">City Council Meetings</option>');
}

if(localpage != 'councilreports')
{ 
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3A2014&layout_type=3colnumlink&getfields=DOCUMENT_URL.DOC_NUM.DOC_DATE.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=scs_reportstocouncil&config=reportstocouncil.js&proxystylesheet=scs_ocd">Reports to City Council</option>');
}

if(localpage != 'councilpolicies')
{ 
document.write('<option value="https://google.sannet.gov/search?entqr=0&access=p&getfields=DOCUMENT_URL.DOC_NUM.TITLE&sort=date%3AA%3AR%3Ad1&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&q=&requiredfields=PATH%3Acouncilpolicies&num=100&filter=0&config=councilpolicies.js&ud=1&site=documents&oe=UTF-8&proxystylesheet=scs_ocd&ip=10.9.4.130&=&layout_type=numberlink&start=0l">City Council Policies</option>');
}

if(localpage != 'councilcommtgs')
{ 
document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/legisdocs/cccmeetings.shtml">City Council Committee Meetings</option>');
}

if(localpage != 'cacm')
{ 
document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/legisdocs/agencycommmeetings.shtml">City Agency &amp; Commission Meetings</option>');	
}

}


//function build_legal_dropdown demonstrates how to complete the dropdown
//but only mol, legalops, and careports are complete.
//To complete the rest:
//1. If any of the others needs to be a link to a dynamic page,
//   a. change the link to the correct link
//   b. add a value for pageloc to the config.js for the page. 
//      For example, legalopinions.js has the line 
//      var pageloc='legalops';
//      By setting that value, the legalops link isn't displayed when you
//      are already on the legalops page
//   c. step "b" is not necessary when the dropdown is on a static page. 
//   d. when dropdown is on a static page, add the var pageloc on the static page.
//      For example, on /city-clerk/officialdocs/legisdocs/charter.shtml, add
//      <script type="text/javascript">var pageloc = "charter";</script> on the
//      line above <!--#include virtual="includes/dropdown.html"-->
//      


//2. careports is an example of how to implement a static page
//   If careports needs to be dynamic, change it as above, but use the current
//   example for any static page.
//   the links are already present in build_legal_dropdown, but to prevent the link to careports.html
//   from displaying when you are already on that page, this line was added to javascript in careports.html:
//   var pageloc="careports";
//   careports matches the value below, so when already on the careports page, the link 
//   to itself won't display
//   The ca advanced page should not have pageloc set, since its dropdown should allow
//   the user to navigate back to the full text search page



function build_legal_dropdown()
{
	var localpage=get_page();

document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/legaldocs/" selected>Find other Legal Documents</option>');
if(localpage != 'ccresos') 
{

document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/legaldocs/ccresos.shtml">City Council Resolutions and Ordinances</option>');
}
if(localpage != 'aresos') 
{
document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/legaldocs/aresos.shtml">Agency Resolutions and Ordinances</option>');
}
if(localpage != 'mol') 
{
  document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Amemooflaw&layout_type=3colnumlink&getfields=DOCUMENT_URL.DOC_NUM.DOC_DATE.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=memooflaw.js&proxystylesheet=scs_ocd&q=+inmeta:DOC_DATE_NUM%3A20160101..20170101">Memorandum of Law</option>');
}
if(localpage != 'legalops') 
{
  document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Alegalopinions&&layout_type=report&getfields=DOCUMENT_URL.DOC_NUM.DOC_DATE.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=legalopinions.js&proxystylesheet=scs_ocd&q=+inmeta:DOC_DATE_NUM%3A20160101..20170101">Legal Opinions</option>');
}
if(localpage != "careports") 
{
  document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH%3Acityattorneyreports&layout_type=full&getfields=DOCUMENT_URL.DOC_NUM.DOC_DATE.DOC_SET.TITLE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=cityattorneyreports.js&proxystylesheet=scs_ocd&q=+inmeta:DOC_DATE_NUM%3A20160101..20170101">City Attorney Reports</option>');
}
  document.write('<option value="http://www.sandiego.gov/city-clerk/councilcomm/closedsess/index.shtml">City Attorney Closed Session Meeting Reports</option>');

  document.write('<option value="http://www.sandiego.gov/cityattorney/index.shtml">City Attorney&rsquo;s Office</option>');


}

//function build_bulletin_dropdown is called directly by /city-clerk/officialdocs/notices/includes/dropdown.html
//This is not complete. Will need to add the link urls once the screens have been created.

function build_bulletin_dropdown()
{
	var localpage=get_page();

document.write('<option value="http://www.sandiego.gov/city-clerk/officialdocs/notices/" selected>Find other Public Notices</option>');

if(localpage != 'hearings') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:PublicHearings&layout_type=datetitlelink&getfields=DOCUMENT_URL.TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=publichearings.js&proxystylesheet=scs_ocd&q=">Public Hearings</option>');
}

if(localpage != 'ceqadocs') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:CEQA&layout_type=datetitlelink&getfields=DOCUEMENT_URL.TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=ceqa.js&proxystylesheet=scs_ocd&q=">CEQA Notices &amp; Documents</option>');
}

if(localpage != 'ceqarights') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:CEQA_appeal&layout_type=datetitlelink&getfields=DOCUMENT_URL.TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=ceqaappeal.js&proxystylesheet=scs_ocd&q=">CEQA Notices of Rights to Appeal Environmental Determinations</option>');
}

if(localpage != 'construction') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:Construction&layout_type=datetitlelink&getfields=DOCUMENT_URL.TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=construction.js&proxystylesheet=scs_ocd&q=">Construction</option>');
}

if(localpage != 'consultants') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:Consultants&layout_type=datetitlelink&getfields=DOCUMENT_URL.TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=consultants.js&proxystylesheet=scs_ocd&q=">Consultants</option>');
}

if(localpage != 'lud') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:LandUseAndDevelopment&layout_type=datetitlelink&getfields=DOCUMENT_URL.TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=lud.js&proxystylesheet=scs_ocd&q=">Land Use and Development</option>');
}

if(localpage != 'mes') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:MaterialsEquipmentServices&layout_type=datetitlelink&getfields=DOCUMENT_URL.TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=mes.js&proxystylesheet=scs_ocd&q=">Materials/Equipment/Services</option>');
}

if(localpage != 'misc') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=STARTED:TRUE.ENDED:FALSE.PATH:Miscellaneous&layout_type=datetitlelink&getfields=DOCUMENT_URL.TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=misc.js&proxystylesheet=scs_ocd&q=">Miscellaneous</option>');
}

if(localpage != 'rando') 
{
document.write('<option value="https://google.sannet.gov/search?partialfields=&sort=date%3AD%3AS%3Ad1&proxyreload=1&num=100&requiredfields=PATH:Ordinances-Resolutions&layout_type=datetitlelink&getfields=DOCUMENT_URL.TITLE.DOC_DATE&output=xml_no_dtd&ie=UTF-8&client=scs_ocd&filter=0&site=documents&config=resos.js&proxystylesheet=scs_ocd&q=">Resolutions/Ordinances</option>');
}

}