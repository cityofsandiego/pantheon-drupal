function onsiteLoaded() {
  // load the form and store status (true/false) in neb_status
  var neb_status = KAMPYLE_ONSITE_SDK.loadForm(2078);
  if (neb_status === true) {
    // If form is loaded
    // set CSS attribute display to inherit so button can be seen
    document.getElementById("mdFormButton").style.display = "inherit"
  }
  else {
    console.log("Could not load Medallia Form");
  }
}

if (window.KAMPYLE_ONSITE_SDK) { //If Medallia code has been loaded
  onsiteLoaded(); //your custom function
}
else { // On the neb_OnsiteLoaded event, call onsiteLoaded function
  window.addEventListener('neb_OnsiteLoaded', onsiteLoaded);
}


