function check()
{
  var df=document.mainform;
  if (df.q.value=='') {
    alert('Please enter search criteria.');
    return false;
  }
  return true; 
}