### MODULE: sand_weather

### INTRODUCTION
Originally done in D7 from what I assume is IF. This gets the weather from 
http://w1.weather.gov/xml/current_obs/KSAN.xml and formats it for use in our header

### INSTALLATION
Enable module.

### CONFIGURATION
See Configure link in <a href="/admin/modules">/admin/modules</a>

### TODO
See individual files. Format: @todo ...

### STATUS
Fully upgraded to D9. Note that the output name was changed to a more module specific.
To get the output use the block provided "sand_weather" or: 
- $text = \Drupal::state()->get('sand_weather.text');
- $icon = \Drupal::state()->get('sand_weather.icon');
- $temp = \Drupal::state()->get('sand_weather.temp');

The variables will contain thing like: 
- text: "Partly Cloudy"
- icon: "icon-cloud-sun"
- temp: "77"

---

### DRUPAL7
Basic logic is the same but the module was named sand_if_weather.
