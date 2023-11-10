var loc;
if (loc == null || loc.length == 0) {loc = "x";}


if (loc == "clerk_index") {document.write("| City Clerk Home ");}
else {document.write("| <a href=\""+ url+ "city-clerk/index.shtml\" id=\"bottomNavClerk\" class=\"bottomNav\">City Clerk Home</a> ");}

if (loc == "home_index") {document.write("| Official City Documents Home ");}
else {document.write("| <a href=\""+ url+ "city-clerk/officialdocs/index.shtml\" id=\"bottomNavHome\" class=\"bottomNav\">Official City Documents Home</a> ");}

if (loc == "legislative_index") {document.write("| City Clerk Legislative Documents ");}
else {document.write("| <a href=\""+ url+ "city-clerk/officialdocs/legisdocs/index.shtml\" id=\"bottomNavLegislative\" class=\"bottomNav\">City Clerk Legislative Documents</a> ");}

document.write("| <a href=\"#VeryTop\" id=\"bottomNavTopPage\" class=\"bottomNav\">Top of Page</a> |<br>");

if (loc == "attorney_index") {document.write("| City Attorney Legal Documents ");}
else {document.write("| <a href=\""+ url+ "city-clerk/officialdocs/legaldocs/index.shtml\" id=\"bottomNavAttorney\" class=\"bottomNav\">City Attorney Legal Documents</a> ");}

if (loc == "bulletin_index") {document.write("| City Bulletin of Official Public Notices ");}
else {document.write("| <a href=\""+ url+ "city-clerk/officialdocs/notices/index.shtml\" id=\"bottomNavBulletin\" class=\"bottomNav\">City Bulletin of Official Public Notices</a> ");}
