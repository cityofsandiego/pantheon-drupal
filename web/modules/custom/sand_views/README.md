### MODULE: sand_views`

### INTRODUCTION 
This module was developed in D7 by the original IF developers. Basically view hooks to set number of lines in a
specific view/display. Later a generalized feature was added by glen. If view argument = "list=25", this will set the output
number of lines to 25 or whatever you list.

### INSTALLATION
Enable module.

### CONFIGURATION
No configuration.

### TODO
See individual files. Format: @todo ...

### STATUS
Fully upgraded to D9. We may want to put this in with sand_views for things view related.

---

### DRUPAL7

Sets number of lines for two different views:
- "department_notifications" && $view_display === "block_2"
- $view_name == "attractions_list" && $view_display == "location_type"
