### MODULE: sand_weather

### INTRODUCTION
This gets the weather from
https://forecast.weather.gov/MapClick.php?lat=32.718814&lon=-117.162222 
and formats it for use in our header.
URL entered in the CONFIGURATION

### INSTALLATION
Enable module.

### CONFIGURATION
See Configure link in <a href="/admin/config/webteam/settings/weather">/admin/config/webteam/settings/weather</a>
If the URL is changed or if parts of this page change:
#### PARSER
SandWeatherQueue.php:322 & 332
Change the class in the HTML parser. Or build a xml parser if changing to xml for source.
$temp_node = $crawler->filter('#current_conditions-summary .myforecast-current-lrg');
$weather_node = $crawler->filter('#current_conditions-summary .myforecast-current');

### TODO
See individual files. Format: @todo ...

### STATUS
Fully upgraded to D9. Note that the output name was changed to a more module specific.
To get the output use the block provided "sand_weather" or: 
- $text = \Drupal::state()->get('sand_weather.text');
- $icon = \Drupal::state()->get('sand_weather.icon');
- $temp = \Drupal::state()->get('sand_weather.temp');
- $wurl = \Drupal::state()->get('sand_weather.wurl');

The variables will contain thing like: 
- text: "Partly Cloudy"
- icon: "icon-cloud-sun"
- temp: "77"
- wurl: "https://forecast.weather.gov/MapClick.php?lat=32.718814&lon=-117.162222"

---

### DRUPAL
Basic logic is the same but the module was named sand_if_weather.

