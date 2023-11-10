
  curDate=new Date();
  nochange=-1;
  a = new Array();
  a[0] = "January";
  a[1] = "February";
  a[2] = "March";
  a[3] = "April";
  a[4] = "May";
  a[5] = "June";
  a[6] = "July";
  a[7] = "August";
  a[8] = "September";
  a[9] = "October";
  a[10] = "November";
  a[11] = "December";

var curmonth = "";
var date_based_rows=false;

curDateInitialized=false;

function check_date_change(datenum)
{
  changed=-1;
  //alert(datenum);
  date_fields = datenum.split("-");
  newDate = new Date();
  var rawMonth = date_fields[1];
  var newMonth = rawMonth - 1;
  
  //alert("raw month: " + rawMonth + " correctmonth: " + newMonth);
  curmonth=a[newMonth];
  //alert(curmonth);
  newDate.setMonth(newMonth);
  //alert("set month for newDate: " + newDate.getMonth());
  newDate.setDate(date_fields[2]);
  newDate.setFullYear(date_fields[0]);
  //alert("year:" + newDate.getFullYear() + "month: " + newDate.getMonth() + "date: " + newDate.getDate());
  if(curDateInitialized==false)
  {
    //alert("initializing");
    curDateInitialized=true;
    curDate = newDate;
    changed=2;
  }else
  {
    if(newDate.getFullYear() != curDate.getFullYear())
    {
      changed=2;
    }else
    {
     if(newDate.getMonth() != curDate.getMonth())
     {
       changed=1;
     }else
     {
     if(newDate.getDate() != curDate.getDate())
       {
       changed=0;
       }
     }
    }
   }
    curDate=newDate;
    //alert(curDate);
    return changed;
}
var rows_initialized=false;

function initialize_date_based_rows()
{
//alert("init rows");
  if(date_based_rows==true)
  {
    document.write('<tr><td><table width="100%" bgcolor=red border=1>');
  }
}
var pdfs_by_type=new Array();
var olddate = "null";
var outstring = "";
var num_doc_types=3;


function build_date_row(date, label, url, sort)
{
  change=check_date_change(date);
  //alert(change);
  var dateval ="";
  if(change>-1)
  { 
    dateval=date;

    if(changed>0)
    {
      
       newMonth=curDate.getMonth();
       //alert("month: " + newMonth);
       //month=a[newMonth];
       month=curmonth;
   //    alert("creating row for month label: " + month);
       //year=curDate.getYear();
    document.write('<tr><td colspan="2">' + month + '</td></tr>');
     }
  }
  //alert(dateval);
  document.write('<tr><td>'+dateval+'</td><td><a href="'+url + '">' + label + '</a></td></tr>');
}


function reformat_date(googldate)
{

datearray = googldate.split("\-");
if(datearray.length==3)
{
  if(datearray[0]=="0000")
  {
    googldate="";
  }
  else
  {
    googldate=datearray[1] + "/" + datearray[2] + "/" + datearray[0];
  }
}
else
{
googldate="";
}

return googldate;
}

function write_reformat_date(gdate)
{
writedate = reformat_date(gdate);
document.write(writedate);
}

function build_date_cell(date)
{
  change=check_date_change(date);
  //alert(change);
  var dateval ="";
  if(change>-1)
  { 
    dateval=date;
    document.write('<td colspan="2">&nbsp;</td></tr><tr>');
    if(change>0)
    {
      
       newMonth=curDate.getMonth();
       //alert("month: " + newMonth + ", " +  curDate.getFullYear() );
       month=a[newMonth];
   //    alert("creating row for month label: " + month);
       //year=curDate.getYear();
    document.write('<td colspan="2"><b>' + curmonth + ', ' + curDate.getFullYear() +'</b></td></tr><tr>');
     }
  prettydate = reformat_date(dateval);
  document.write('<td>'+prettydate+'</td>');
  }
  else
  {
  //alert(dateval);
  document.write('<td></td>');
  }
}

function build_daydate_cell(date, DAY)
{
  change=check_date_change(date);
  //alert(change);
  var dateval ="";
  if(change>-1)
  { 
    dateval=date;
    document.write('<td colspan="2">&nbsp;</td></tr><tr>');
    if(change>0)
    {
      
       newMonth=curDate.getMonth();
       //alert("month: " + newMonth + ", " +  curDate.getFullYear() );
       month=a[newMonth];
   //    alert("creating row for month label: " + month);
       //year=curDate.getYear();
    document.write('<td colspan="2"><b>' + curmonth + ', ' + curDate.getFullYear() +'</b></td></tr><tr>');
     }
  //prettydate = DAY;
  //document.write('<td>'+prettydate+'</td>');
  }
  else
  {
  //alert(dateval);
  document.write('<td></td>');
  }
}



function old_build_date_row(date, label, url, sort)
{

  change=check_date_change(date);
  if(changed>-1)
  {

    if(olddate != "null")
    {

       outstring="<tr><td>" + olddate + "</td><td>"; 
       for(i=0; i<pdfs_by_type.length; i++)
       {
         outstring = outstring + pdfs_by_type[i];
       }
       outstring= outstring + "</td></tr>";
       document.write(outstring);
       pdfs_by_type=new Array();
    }
    if(pdfs_by_type.length=0)
    {
       for(j=0;j<num_doc_types;j++)
       {
          pdfs_by_type[0] = "";
       }
    }
   olddate=date;
  }
  if(pdfs_by_type[sort] == null || pdfs_by_type[sort] == "undefined" || pdfs_by_type[sort].length <1)
  {
    //alert("don't go there" +sort);
    pdfs_by_type[sort] ="";
  }
  holder=pdfs_by_type[sort];
  pdfs_by_type[sort]= holder + '<a href="' + url + '">' + label + '</a><br></br>';
  
}
var displaycode=new Array();

function newdate_newrow(date, label, url, sort)
{

  change=check_date_change(date);
// alert("newdate_newrow change value " + changed);
 

  if(changed>-1)
  {
       outstring="<tr><td>" + date + "</td><td>";
     //alert("rows initialized?" + rows_initialized);
     if(rows_initialized==false)
     {
       rows_initialized=true;

     }
     else
     {
//document.write("<tr><td>date</td><td>Meeting Label </td></tr>");
      var outstring="";
     // alert("length of displaycode array " +displaycode.length);
      for(i=0;i<displaycode.length;i++)
      {
      if(displaycode[i] != null && displaycode[i] != "undefined" && displaycode[i].length >0)
       {
        //alert(i + ". " +outstring + " plus " + displaycode[i]);
        outstring= outstring + displaycode[i];
       // alert("result: " + outstring);
       }
      displaycode[i]="";
      }
      displaycode[0]="<tr><td>" + date + "</td><td>";
   //   alert("closing table cell with documents: ");
      //alert(outstring);
      document.write(outstring + "</td></tr>");
      displaycode=new Array();
      }



    if(changed>0)
    {
      
       newMonth=curDate.getMonth();
       month=a[newMonth];
   //    alert("creating row for month label: " + month);
       //year=curDate.getYear();
   //    document.write('<tr><td colspan="2">' + month + '</td></tr>');
    }

   // document.write("<tr><td>" + date + "</td><td>");

  }

      //alert(displaycode[sort])
      if(displaycode[sort] == null || displaycode[sort] == undefined || displaycode.length <1)
      {
    //   alert("create array field " +sort + " for row");
        displaycode[sort]="";
      }
     // alert("adding " + label + " to field " + sort);
      displaycode[sort]= displaycode[sort] + '<a href="' + url + '">' + label + "</a><br></br>";
  
}

function finalize_date_based_rows()
{

  if(date_based_rows==true)
  {
   outstring="";
   if(displaycode.length !=0)
   {
      for(i=0;i<displaycode.length;i++)
      {
        if(displaycode[i] != null && displaycode[i] != "undefined" && displaycode[i].length >0)
        outstring+=displaycode[i];
        displaycode[i]="";
      }

        document.write(outstring + "</td></tr></table></td></tr>");
    }

  }

}