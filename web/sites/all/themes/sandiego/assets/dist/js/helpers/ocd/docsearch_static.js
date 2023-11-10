var default_query="";
var metafields_set=false;
var datenumrange=false;

function pick_docsets()
{

param="";
setSelected=false;
 for(j=0; j<document.forms["docsets"].elements.length; j++)
 {
   if(document.forms["docsets"].elements[j].checked)
   {
     if(setSelected==true)
     {
       param+="|";
     }
     param+="path:";
     param+=document.forms["docsets"].elements[j].name;
     setSelected=true;
   }
 }
 if(setSelected==true)
 {

 document.forms["googleSearch"].requiredfields.value=param;
 }

}


function pick_required()
{
//alert("picking now");
param="";
userfriendly="";
   document.forms["mainform"].partialfields.value="";
setSelected=false;
 for(j=0; j<document.forms["filter"].elements.length; j++)
 {
   if((document.forms["filter"].elements[j].value !=null) && (document.forms["filter"].elements[j].value.length > 0))
   {
     if(setSelected==true)
     {
       param+=".";
       userfriendly+=" ";
     }
     metafields_set = true;
     param+=document.forms["filter"].elements[j].name;
     param+=":";
     param+=document.forms["filter"].elements[j].value;

     userfriendly+=document.forms["filter"].elements[j].id + ":";
     userfriendly+="'"+document.forms["filter"].elements[j].value+"'";
//clear the input field
     //document.forms["filter"].elements[j].value=""; 
     setSelected=true;
   }
 }
 if(setSelected==true)
 {

   //alert(param);
   document.forms["mainform"].partialfields.value=param;
   document.forms["mainform"].advancedfields.value=userfriendly;
 }
//document.forms["mainform"].submit();

}

function checkqueryparams()
{
  //alert("checking");

  query="";
  param="";
  if(document.forms["mainform"].elements["q"].value !=null)
  {
    query=document.forms["mainform"].elements["q"].value;
  }

  //alert("query " + query);
  if(datenumrange==true)
  {
    //alert("formatting numberrange");
    param=numberrange();
  }
  else
  {
   if(daterange_search==true)
   { 
     param=daterangequery();
   }
  }
  //alert("param " + param);
  if(param != null && param != "")
  {
    if((query=="")&&(default_query !=""))
    {
      query=default_query;
    }
   fullquery = query + param;
 //  alert("1" +fullquery);
  document.forms["mainform"].elements["q"].value = fullquery;
  document.forms["mainform"].elements["sort"].value = "date:D:S:d1";
  return fullquery;
  }
  return query;


}

function clear_advanced_form()
{

   document.forms["filter"].reset();
   document.forms["daterangeform"].reset();
   document.forms["mainform"].elements["startdate"].value = "";
   document.forms["mainform"].elements["enddate"].value = "";  
   document.forms["mainform"].partialfields.value="";
  document.forms["mainform"].elements["sort"].value = "";
   document.forms["mainform"].advancedfields.value="";
   return false;
}

function checkpnqueryparams()
{
 if(meta_search==true)
 {
document.forms["mainform"].q.value="";
  //alert("qualified to pick");
  pick_required();
 }
//alert("calling check");
var query=checkqueryparams();
//alert(query);
 if((query !="")||(metafields_set==true))
 {
  //alert("submitting form");
  return true;
 }

return false;
}

function checkthequeryparams()
{

 if(meta_search==true)
 {
document.forms["mainform"].q.value="";
  //alert("qualified to pick");
  pick_required();
 }
//alert("calling check");
var query=checkqueryparams();
//alert(query);
 if((query !="")||(metafields_set==true))
 {
  //alert("submitting form");
  document.forms["mainform"].submit();
 }

return false;
}
