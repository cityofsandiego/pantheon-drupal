var loc;
var url; 
if (loc == null || loc.length == 0) {loc = "x";}

if (loc == "clerk_index") {document.write("<td><img src=\"" + url + "city-clerk/officialdocs/graphics/navhomeon.gif\" id=\"topNavClerkImg\" width=\"61\" height=\"24\" border=\"0\" alt=\"City Clerk Home\"></td>");}
else if (loc == "clerk_section") {document.write("<td><a href=\"" + url + "city-clerk/index.shtml\" id=\"topNavClerk\" ><img src=\"" + url + "city-clerk/officialdocs/graphics/navhomeon.gif\" id=\"topNavClerkImg\" width=\"61\" height=\"24\" border=\"0\" alt=\"City Clerk Home\"></a></td>");}
else {document.write("<td><a href=\"" + url + "city-clerk/index.shtml\" id=\"topNavClerk\"><img src=\"" + url + "city-clerk/officialdocs/graphics/navhomeoff.gif\" id=\"topNavClerkImg\" width=\"61\" height=\"24\" border=\"0\" alt=\"City Clerk Home\"></a></td>");}

if (loc == "home_index") {document.write("<td><img src=\"" + url + "city-clerk/officialdocs/graphics/navcitydocson.gif\" id=\"topNavHomeImg\" width=\"94\" height=\"24\" border=\"0\" alt=\"Official City Documents Home\"></td>");}
else if (loc == "home_section") {document.write("<td><a href=\"" + url + "city-clerk/officialdocs/index.shtml\" id=\"topNavHome\" ><img src=\"" + url + "city-clerk/officialdocs/graphics/navcitydocson.gif\" id=\"topNavHomeImg\" width=\"94\" height=\"24\" border=\"0\" alt=\"Official City Documents Home\"></a></td>");}
else {document.write("<td><a href=\"" + url + "city-clerk/officialdocs/index.shtml\" id=\"topNavHome\"><img src=\"" + url + "city-clerk/officialdocs/graphics/navcitydocsoff.gif\" id=\"topNavHomeImg\" width=\"94\" height=\"24\" border=\"0\" alt=\"Official City Docs Home\"></a></td>");}

if (loc == "legislative_index") {document.write("<td><img src=\"" + url + "city-clerk/officialdocs/graphics/navlegisdocson.gif\" id=\"topNavLegislativeImg\" width=\"119\" height=\"24\" border=\"0\" alt=\"City Clerk Legislative Documents\"></td>");}
else if (loc == "legislative_section") {document.write("<td><a href=\"" + url + "city-clerk/officialdocs/legisdocs/index.shtml\" id=\"topNavLegislative\"><img src=\"" + url + "city-clerk/officialdocs/graphics/navlegisdocson.gif\" id=\"topNavLegislativeImg\" width=\"119\" height=\"24\" border=\"0\" alt=\"City Clerk Legislative Documents\"></a></td>");}
else {document.write("<td><a href=\"" + url + "city-clerk/officialdocs/legisdocs/index.shtml\" id=\"topNavLegislative\"><img src=\"" + url + "city-clerk/officialdocs/graphics/navlegisdocsoff.gif\" id=\"topNavLegislativeImg\" width=\"119\" height=\"24\" border=\"0\" alt=\"City Clerk Legislative Documents\"></a></td>");}

if (loc == "attorney_index") {document.write("<td><img src=\"" + url + "city-clerk/officialdocs/graphics/navlegaldocson.gif\" id=\"topNavAttorneyImg\" width=\"96\" height=\"24\" border=\"0\" alt=\"City Attorney Legal Documents\"></td>");}
else if (loc == "attorney_section") {document.write("<td><a href=\"" + url + "city-clerk/officialdocs/legaldocs/index.shtml\" id=\"topNavAttorney\"><img src=\"" + url + "city-clerk/officialdocs/graphics/navlegaldocson.gif\" id=\"topNavAttorneyImg\" width=\"96\" height=\"24\" border=\"0\" alt=\"City Attorney Legal Documents\"></a></td>");}
else {document.write("<td><a href=\"" + url + "city-clerk/officialdocs/legaldocs/index.shtml\" id=\"topNavAttorney\"><img src=\"" + url + "city-clerk/officialdocs/graphics/navlegaldocsoff.gif\" id=\"topNavAttorneyImg\" width=\"96\" height=\"24\" border=\"0\" alt=\"City Attorney Legal Documents\"></a></td>");}

if (loc == "bulletin_index") {document.write("<td><img src=\"" + url + "city-clerk/officialdocs/graphics/navnoticeson.gif\" id=\"topNavBulletinImg\" width=\"118\" height=\"24\" border=\"0\" alt=\"City Bulletin of Official Public Notices\"0></td>");}
else if (loc == "bulletin_section") {document.write("<td><a href=\"" + url + "city-clerk/officialdocs/notices/index.shtml\" id=\"topNavBulletin\"><img src=\"" + url + "city-clerk/officialdocs/graphics/navnoticeson.gif\" id=\"topNavBulletinImg\" width=\"118\" height=\"24\" border=\"0\" alt=\"City Bulletin of Official Public Notices\"0></a></td>");}
else {document.write("<td><a href=\"" + url + "city-clerk/officialdocs/notices/index.shtml\" id=\"topNavBulletin\"><img src=\"" + url + "city-clerk/officialdocs/graphics/navnoticesoff.gif\" id=\"topNavBulletinImg\" width=\"118\" height=\"24\" border=\"0\" alt=\"City Bulletin of Official Public Notices\"0></a></td>");}
