daterange_search=false;
range_backdate=0;

function numberrange()
{
   format_error = "Please enter date in this format: YYYY/MM/DD";
   document.forms["mainform"].elements["startdate"].value = "";
   document.forms["mainform"].elements["enddate"].value = "";
// alert("daterangequery");
  var daterangeparam ="";
  var tostring="";
  var fromstring="";
  var fromdate_is_empty = true;
  var todate_is_empty = true;
  var tovals=new Array();
  var fromvals=new Array();
  var searchmessage ="";
  var todatenum="";
  var fromnum="";
  if((document.forms["daterangeform"].elements["through"].value !=null) && (document.forms["daterangeform"].elements["through"].value.length > 0))
   {
     //alert("through date set: "+ document.forms["daterangeform"].elements["through"].value);
     todate_is_empty=false;
   }

   if((document.forms["daterangeform"].elements["from"].value !=null) && (document.forms["daterangeform"].elements["from"].value.length > 0))
   {
    // alert(" from date set: "+ document.forms["daterangeform"].elements["from"].value);
     fromdate_is_empty=false;
   }

   if((todate_is_empty==true)&&(fromdate_is_empty==true))
   {
     return "";
   }
    if(fromdate_is_empty==false)
     {
        
   document.forms["mainform"].elements["startdate"].value = document.forms["daterangeform"].elements["from"].value;
     }
     if(todate_is_empty==false)
     {
   document.forms["mainform"].elements["enddate"].value = document.forms["daterangeform"].elements["through"].value;
     }   
   if(todate_is_empty == false)
   {
        raw_date=document.forms["daterangeform"].elements["through"].value;

        tostring=massage_date(raw_date);

        tovals= tostring.split("\-"); 
        if(tovals.length != 3)
        {
          alert(format_error);
          return "";
        }
   todatenum=""+tovals[0]+tovals[1]+tovals[2];
   }


   if(fromdate_is_empty == false)
   {
//alert("checking from date");
        raw_date=document.forms["daterangeform"].elements["from"].value;
//alert(document.forms["daterangeform"].elements["from"].value);
        fromstring=massage_date(raw_date);
        fromvals= fromstring.split("\-"); 
        if(fromvals.length != 3)
        {
          alert(format_error);
          return "";
        }
   fromnum=""+fromvals[0]+fromvals[1]+fromvals[2];
   }

  //alert("numberrange");
          date_order_error = "Error: 'from' date must be an earlier date than 'to' date";
         // alert("a-ok to right here");
   if(fromstring!="" && tostring!="")
   {
          if(fromnum> todatenum) 
            {
              alert(date_order_error);
              return "";
            }
   }


          inmetadateparam = " inmeta:DOC_DATE_NUM:" + fromnum+ ".." + todatenum;

//alert("returning: " + inmetadateparam);
 return(inmetadateparam);
}

function daterangequery()
{
  //alert("range_backdate=" );
   format_error = "Please enter date in this format: YYYY/MM/DD";
   document.forms["mainform"].elements["startdate"].value = "";
   document.forms["mainform"].elements["enddate"].value = "";
// alert("daterangequery");
  var daterangeparam ="";
  var tostring="";
  var fromstring="";
  var fromdate_is_empty = true;
  var todate_is_empty = true;
  var tovals=new Array();
  var fromvals=new Array();
  var searchmessage ="";

  if((document.forms["daterangeform"].elements["through"].value !=null) && (document.forms["daterangeform"].elements["through"].value.length > 0))
   {
     //alert("through date set: "+ document.forms["daterangeform"].elements["through"].value);
     todate_is_empty=false;
   }

   if((document.forms["daterangeform"].elements["from"].value !=null) && (document.forms["daterangeform"].elements["from"].value.length > 0))
   {
    // alert(" from date set: "+ document.forms["daterangeform"].elements["from"].value);
     fromdate_is_empty=false;
   }

   if((todate_is_empty==true)&&(fromdate_is_empty==true))
   {
     return "";
   }
    if(fromdate_is_empty==false)
     {
        
   document.forms["mainform"].elements["startdate"].value = document.forms["daterangeform"].elements["from"].value;
     }
     if(todate_is_empty==false)
     {
   document.forms["mainform"].elements["enddate"].value = document.forms["daterangeform"].elements["through"].value;
     }   
   
  // alert(searchmessage);
   //document.forms["mainform"].elements["daterangefields"].value = searchmessage;
   if(todate_is_empty == false)
   {
        raw_date=document.forms["daterangeform"].elements["through"].value;

        tostring=massage_date(raw_date);

        tovals= tostring.split("\-"); 
        if(tovals.length != 3)
        {
          alert(format_error);
          return "";
        }

   }
   else
   {
     tostring="";
   }

   if(fromdate_is_empty == false)
   {
//alert("checking from date");
        raw_date=document.forms["daterangeform"].elements["from"].value;
//alert(document.forms["daterangeform"].elements["from"].value);
        fromstring=massage_date(raw_date);
        fromvals= fromstring.split("\-"); 
        if(fromvals.length != 3)
        {
          alert(format_error);
          return "";
        }

   }
   else
   {
     fromstring="";
   }
          date_order_error = "Error: 'from' date must be an earlier date than 'to' date";
         // alert("a-ok to right here");

          if(fromvals[0] > tovals[0]) //if from year > to year, incorrect data
            {
              alert(date_order_error);
              return "";
            }

          if(fromvals[0] == tovals[0]) //if from year == to year, then:
            {
              if(fromvals[1] > tovals[1]) //if from month > to month, incorrect data
              {
              alert(date_order_error);
                return "";              
              }
              if(fromvals[1] == tovals[1]) //if from month == to month, then:
              {
                if(fromvals[2] > tovals[2]) //if from date > to date, incorrect data
                {
                alert(date_order_error); 
                 return "";              
                }             
              }
           
            } 
           if(range_backdate >0)
		   {
			  if(tostring != "")
			  {
				  tostring=backdate(tostring);
			  }
			  if(fromstring != "")
			  {
				  fromstring=backdate(fromstring);
			  }
			   
		   }
          daterangeparam = " daterange:" + fromstring+ ".." + tostring;

//alert("returning: " + daterangeparam);
 return(daterangeparam);

}

function backdate(todate)
{

subtract= range_backdate;
//todate = "2000-03-10";


//alert(todate);
tovals= todate.split(/[^\d]/); 
year = tovals[0] /1;
month = tovals[1] /1;
day = tovals[2] /1;

monthtext=tovals[1];
newday = day - subtract;
//alert(newday);
if(newday <1)
{
  month=month -1;

  if(month==0)
  {
    year=year-1;
    month=12;
    newday = 31 + newday;
  }
  else if(month == 9 || month == 4 || month == 6 || month == 11)
  {
    newday = 30 + newday;
  }
  else if(month == 2)
  {
   if(year % 4 == 0)
   {
      newday = 29 + newday;
   }
   else
   {
      newday = 28 + newday;
   }
  }else
  {
      newday = 31 + newday;    
  }
  if(newday <1)
  {
    newday=31 + newday;
    month=month -1;
  }
  if(month <10)
  {
    monthtext ="0"+month;
  }
  else
  {
    monthtext = ""+month;
  }
}

if(newday <10)
{
      newday = "0"+newday;
}

convdate=""+year+"-"+monthtext+"-"+newday;
return(convdate);
}


function getStringLength(datenumber)
{
  var element = "" + datenumber +"";
  return element.length;
}

function pad(datenumber)
{
  var element = "" + datenumber +"";
  if(element.length ==1)
  {
    element = "0" + datenumber;
  }
  return element;
}

function massage_date(thestring)
{
  //alert("massaging date");
 tostring="";
 toarrayraw=thestring.split(/[^\d]/);
  toarray= new Array();
  resultsarray= new Array();

  num_nums=0;
  for(i=0; i<toarrayraw.length && num_nums <3; i++)
  {
	date_element=toarrayraw[i].match(/^\d+$/);
        if(date_element !=null)
        {
          if(date_element <1)
          {
            return tostring;
          }
          toarray[num_nums]=date_element;
          num_nums++;
        }

  }

  //alert("num nums: " + num_nums + "toarray.length: " + toarray.length);
  //alert("length of array of numbers: " + toarray.length);

 if(toarray.length <2)
 {
   return("");
 }
 if(toarray.length == 2) //if only month and year entered, add date as the first of the month
 {
   toarray[2]=1;
   if(getStringLength(toarray[1])==4)
   {
     month=toarray[0];
     toarray[0]=toarray[1];
     toarray[1]=month;
   }

 }
 
/* if(toarray[0]>12 && toarray[0]<32 && toarray[1]<13 && toarray[2]>1900) //convert from date first order
 {
     //alert("converting month-first date");
     //switch to month first
     date=toarray[0];
     toarray[0]=toarray[2];
     toarray[2]=date;
 }
*/
 if(toarray[2]>1900) //move year to first element
 {
     //alert("moving year to front");
     year=toarray[2];
     toarray[2]=toarray[1];
     toarray[1]=toarray[0];
     toarray[0] = year;
 }
 if(getStringLength(toarray[0])!=4 || toarray[1]>12 || toarray[2] > 31)
 {
    return "";
 }
 if(toarray[1]==2)
 {
   //alert("February");
   if(toarray[0] % 4 == 0)
   {
     //alert("leap year");
     if(toarray[2] > 29)
     {
       alert("In leap years, February has only 29 days");
       return "";
     }
   }
   else
   {
     if(toarray[2] > 28)
     {
      alert("In non-leap years, February has only 28 days");
       return "";
     }
   }
 }
 else
 {
   if(toarray[1]==9 || toarray[1]==4 ||toarray[1]==6 ||toarray[1]==11)
   {
     //alert("30-day month");
     if(toarray[2] > 30)
     {
       alert("September, April, June and November have only 30 days");
       return "";
     }
   }
   else
   {
     if(toarray[2] >31)
     {
       alert("Date of month cannot be more than 31");
       return "";
     }
   }

   
 }
 
 //alert("raw data: [0]: " + toarray[0] + " [1]: " + toarray[1] + " [2]: " + toarray[2]);
 month = pad(toarray[1]);
 date  = pad(toarray[2]);
 querystring = toarray[0] + "-" + month + "-" + date;
 //alert("querystring: " + querystring);
 return querystring;
 }
   
