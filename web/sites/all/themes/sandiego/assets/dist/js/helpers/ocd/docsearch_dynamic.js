var default_query="";
var pageheader="";
var dropdown_label="Documents";
function order_fields(fields, link)
{

  //alert(fields);
 //document.write("<td>" + fields + "</td>");
 var fieldsarray=fields.split("`~`");
//alert("fieldsarray.length: " + fieldsarray.length);
 googledate = fieldsarray[fieldsarray.length-1];
//alert("orderfields length: " + orderfields.length);


   if(date_based_rows==true)
   {
//alert("date based rows");

  var daterangeparams=new Array();
daterangeparams[0]=googledate;
daterangeparams[2]=link;
foundtitle=false;
foundsort=false;

   for(j=0; j<fieldsarray.length-2; j+=2)
    {
      if(fieldsarray[j]=="TITLE")
      {
        foundtitle=true;
        daterangeparams[1]=fieldsarray[j+1];
      }
   
      if(fieldsarray[j]=="SORTORDER")
      {
        foundsort=true;
        daterangeparams[3]=fieldsarray[j+1];
      }
    }
if(foundtitle && foundsort)
{
/*
  document.write("<tr><td>" + daterangeparams[0] +"<br></br>");
  document.write(daterangeparams[1] +"<br></br>");
  document.write(daterangeparams[2] +"<br></br>");
  document.write(daterangeparams[3] +"</td></tr>");

alert(daterangeparams[0] + " " + daterangeparams[1] + " " +  daterangeparams[2] + " " + daterangeparams[3]);
*/
 build_date_row(daterangeparams[0], daterangeparams[1], daterangeparams[2], daterangeparams[3]);
}

  }
 else
 {

 for(i=0; i<orderfields.length; i++)
 {
   found = 0;
   if(orderfields[i]=="date")
   {
     //alert("date match");
     document.write("<td>" + googledate + "</td>");
     found=1;
   }
   else
   {
     for(j=0; j<fieldsarray.length-2; j+=2)
     {
       if(orderfields[i] == fieldsarray[j])
       {
         found=1;
         if((orderfields[i]==linkfield) && (link!=null))
         {
           document.write('<td><a href="' + link + '">' + fieldsarray[j+1] + '</a></td>');
         }
         else
         {
         document.write("<td>" + fieldsarray[j+1] + "</td>");
         }
       }
     }
     if(found==0)
     {    
       //alert("field not found: " + orderfields[i]);
       document.write("<td></td>");
     }
   }
 }

  }

}



function columnheads()
{

  var labelsarray=colnames.split(".");
  var widthsarray=colwidths.split(".");

  for(i=0; i<labelsarray.length; i++)
  {
    if( i < widthsarray.length)
    {
      //alert(widthsarray[i]);
    document.write('<th align="left" width=' + widthsarray[i] + '><strong><nobr>' + labelsarray[i] +'</nobr></strong></th>');
    }
    else
    {
      //alert("final header");
    document.write('<th align="left"><strong><nobr>' + labelsarray[i] +'</nobr></strong></th>');
    }
  }
  return labelsarray.length;
 
}


function return_text()
{
if(meta_search == false)
{
  return "";
}
 // alert(types);
 // document.forms["mainform"].scsfields.value="test";
  var typesarray=metafields.split(".");
//alert(typesarray.length);
  document.write("<table>");
  for(i=0; i<typesarray.length; i+=2)
  {
 //   if(typesarray[i]=="Title")
  //  {
 //     document.write("<tr><td><nobr>" +typesarray[i] + "</td><td><input size='50' name='" + typesarray[i+1] + "'/></nobr></td></tr>");
   // }
   // else
      document.write("<tr><td><nobr>" +typesarray[i] + "</td><td><input size='50' name='" + typesarray[i+1] + "'/></nobr></td></tr>");
  }
  document.write("</table>");
}

function initialize_layout()
{
   if(date_based_rows==true)
   {
     initialize_date_based_rows();
   }
   else
   {
     columnheads();
   }
}

