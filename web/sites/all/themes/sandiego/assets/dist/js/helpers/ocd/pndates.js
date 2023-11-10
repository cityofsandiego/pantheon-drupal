
format_error = "Please enter date in this format: YYYY/MM/DD";
function getPNdatenumber(raw)
{
//alert(raw);
  var tovals=new Array();
  var rawdate =massage_date(raw);
  tovals= rawdate.split("\-"); 
        if(tovals.length != 3)
        {
          alert(format_error);
          return -1;
        }
 var datenum=""+tovals[0]+tovals[1]+tovals[2];
//document.write("requested date: " +datenum);
return datenum;
}

function gettwodigitnumber(num)
{

  //alert(num)
  var basenum="0";

  if(num<10)
  {
    basenum=basenum + num;
  }
  else
  {
    basenum=num;
  }
//alert(basenum);
  return basenum;

}

function getNowNum()
{
var now=new Date();
charmonth=gettwodigitnumber(now.getMonth()+1);
chardate=gettwodigitnumber(now.getDate());
nownum=""+now.getFullYear()+charmonth+chardate;
//alert("today's date in number format:" + nownum);
return nownum;
}


function inmetaRangeInFuture(req)
{
 var end=getPNdatenumber(req);
 if(end=="")
 {
   alert(format_error);
 }
 var now=getNowNum();
 if(now>end)
 {
   alert("to search for current notices, enter an end date in the future, or leave end date blank");
 }
}

function inmetaRange(req, expired)
{
 //alert("inmeta");

 var param="";
 var now=getNowNum();
 if(req == null || req=="")
 {
   if(expired==true)
   {
     return("inmeta:PN_END_DATE:.." + now);
   }
   else return("inmeta:PN_END_DATE:" + now + "..");
 }
 var end=getPNdatenumber(req);

 if(end==-1)
 {
   return end;
 }

 if(expired==true)
 {
   if(now<end)
   {
   alert("to search for past notices, enter an end date in the year prior to today, or leave end date blank");

   return -1;

   }
   return("inmeta:PN_END_DATE:.." + end);
 }
 if(expired==false && now>end)
 {
   alert("to search for current notices, enter an end date in the future, or leave end date blank");
   return -1;
 }
 return("inmeta:PN_END_DATE:" + now + ".." + end);

}


function checkpn()
{
  var expired=false;
  if(document.forms["query"].elements["expired"].value =="true")
  {
    expired=true;
  }

  var throughparam = inmetaRange(document.forms["query"].elements["through"].value, expired);
  if(throughparam == -1)
  {
  return false;
  }
  //alert("through: " +throughparam);

  document.forms["mainform"].elements["q"].value = "Public Notices " + throughparam;
  default_query= "Public Notices " + throughparam;

  document.forms["query"].submit();
  return false;
}