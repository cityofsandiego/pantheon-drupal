
function check_year_search(year)
{
  //alert(year);
 var df=document.mainform;
  if (df.q.value=='') {
    alert('Please enter search criteria.');
    return false;
  }
  var query = df.q.value; 
  df.basequery.value = query;
//  alert(query);

if(year!=undefined)
{
 // alert("defined");
  daterangeparm="+inmeta:DOC_DATE_NUM:" + year + "0101.." + (year-0+1) + "0101";
  query=query + daterangeparm;
  df.startdate.value="01/01/" + year;
  df.enddate.value="01/01/" + (year-0+1);
 // alert(query);
  document.forms["mainform"].elements["q"].value = query;
}
 // alert("returning true");
  return true; 
}

