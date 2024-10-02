<?php

declare(strict_types=1);

namespace Drupal\sand_weather\Plugin\QueueWorker;

use Drupal\Core\Annotation\QueueWorker;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DependencyInjection\ContainerInterface;

const ICON_SNOW2 = [
  'Snow',
  'Light Snow',
  'Heavy Snow',
  'Snow Showers',
  'Light Snow Showers',
  'Heavy Snow Showers',
  'Showers Snow',
  'Light Showers Snow',
  'Heavy Showers Snow',
  'Snow Fog/Mist',
  'Light Snow Fog/Mist',
  'Heavy Snow Fog/Mist',
  'Snow Showers Fog/Mist',
  'Light Snow Showers Fog/Mist',
  'Heavy Snow Showers Fog/Mist',
  'Showers Snow Fog/Mist',
  'Light Showers Snow Fog/Mist',
  'Heavy Showers Snow Fog/Mist',
  'Snow Fog',
  'Light Snow Fog',
  'Heavy Snow Fog',
  'Snow Showers Fog',
  'Light Snow Showers Fog',
  'Heavy Snow Showers Fog',
  'Heavy Snow Showers Fog',
  'Showers in Vicinity Snow',
  'Snow Showers in Vicinity',
  'Snow Showers in Vicinity Fog/Mist',
  'Snow Showers in Vicinity Fog',
  'Low Drifting Snow',
  'Blowing Snow',
  'Snow Low Drifting Snow',
  'Snow Blowing Snow',
  'Light Snow Low Drifting Snow',
  'Light Snow Blowing Snow',
  'Light Snow Blowing Snow Fog/Mist',
  'Heavy Snow Low Drifting Snow',
  'Heavy Snow Blowing Snow',
  'Thunderstorm Snow',
  'Light Thunderstorm Snow',
  'Heavy Thunderstorm Snow',
  'Snow Grains',
  'Light Snow Grains',
  'Heavy Snow Grains',
  'Heavy Blowing Snow',
  'Blowing Snow in Vicinity',
  'Freezing Rain Snow',
  'Light Freezing Rain Snow',
  'Heavy Freezing Rain Snow',
  'Freezing Drizzle Snow',
  'Light Freezing Drizzle Snow',
  'Heavy Freezing Drizzle Snow',
  'Snow Freezing Rain',
  'Light Snow Freezing Rain',
  'Heavy Snow Freezing Rain',
  'Snow Freezing Drizzle',
  'Light Snow Freezing Drizzle',
  'Heavy Snow Freezing Drizzle',
];

const ICON_RAIN = [
  'Rain',
  'Light Rain',
  'Heavy Rain',
  'Rain Showers',
  'Light Rain Showers',
  'Light Rain and Breezy',
  'Heavy Rain Showers',
  'Rain Showers in Vicinity',
  'Light Showers Rain',
  'Heavy Showers Rain',
  'Showers Rain',
  'Showers Rain in Vicinity',
  'Rain Showers Fog/Mist',
  'Light Rain Showers Fog/Mist',
  'Heavy Rain Showers Fog/Mist',
  'Rain Showers in Vicinity Fog/Mist',
  'Light Showers Rain Fog/Mist',
  'Heavy Showers Rain Fog/Mist',
  'Showers Rain Fog/Mist',
  'Showers Rain in Vicinity Fog/Mist',
  'Rain Showers in Vicinity Fog',
  'Showers in Vicinity',
  'Showers in Vicinity Fog/Mist',
  'Showers in Vicinity Fog',
  'Showers in Vicinity Haze',
  'Rain Fog/Mist',
  'Heavy Rain Fog/Mist',
  'Rain Fog',
  'Heavy Rain Fog',
  'Light Rain Fog/Mist',
  'Drizzle',
  'Light Drizzle',
  'Heavy Drizzle',
  'Light Drizzle Fog/Mist',
  'Drizzle Fog/Mist',
  'Heavy Drizzle Fog/Mist',
  'Drizzle Ice Pellets',
  'Light Drizzle Ice Pellets',
  'Heavy Drizzle Ice Pellets',
  'Rain Ice Pellets',
  'Light Rain Ice Pellets',
  'Heavy Rain Ice Pellets',
  'Rain Freezing Rain',
  'Light Rain Freezing Rain',
  'Heavy Rain Freezing Rain',
  'Freezing Drizzle Rain',
  'Light Freezing Drizzle Rain',
  'Heavy Freezing Drizzle Rain',
  'Rain Freezing Drizzle',
  'Light Rain Freezing Drizzle',
  'Heavy Rain Freezing Drizzle',
  'Hurricane Warning',
  'Hurricane Watch',
  'Tropical Storm Warning',
  'Tropical Storm Watch',
  'Tropical Storm Conditions presently exist w/Hurricane Warning in effect',
];

const ICON_SUN = [
  'Fair',
  'Clear',
  'Fair with Haze',
  'Clear with Haze',
  'Fair and Breezy',
  'Clear and Breezy',
];

const ICON_CLOUD_LIGHTNING = [
  'Thunderstorm',
  'Thunderstorm Rain',
  'Light Thunderstorm Rain',
  'Heavy Thunderstorm Rain',
  'Thunderstorm Rain Fog/Mist',
  'Light Thunderstorm Rain Fog/Mist',
  'Heavy Thunderstorm Rain Fog and Windy',
  'Heavy Thunderstorm Rain Fog/Mist',
  'Thunderstorm Showers in Vicinity',
  'Light Thunderstorm Rain Haze',
  'Heavy Thunderstorm Rain Haze',
  'Thunderstorm Fog',
  'Light Thunderstorm Rain Fog',
  'Heavy Thunderstorm Rain Fog',
  'Thunderstorm Light Rain',
  'Thunderstorm Heavy Rain',
  'Thunderstorm Light Rain Fog/Mist',
  'Thunderstorm Heavy Rain Fog/Mist',
  'Thunderstorm in Vicinity Fog/Mist',
  'Thunderstorm Haze in Vicinity',
  'Thunderstorm in Vicinity Haze',
  'Thunderstorm Hail',
  'Light Thunderstorm Rain Hail',
  'Heavy Thunderstorm Rain Hail',
  'Thunderstorm Rain Hail Fog/Mist',
  'Light Thunderstorm Rain Hail Fog/Mist',
  'Heavy Thunderstorm Rain Hail Fog/Mist',
  'Thunderstorm in Vicinity Hail',
  'Thunderstorm Light Rain Hail Haze',
  'Thunderstorm Heavy Rain Hail Haze',
  'Thunderstorm Hail Fog',
  'Thunderstorm Light Rain Hail Fog',
  'Thunderstorm Heavy Rain Hail Fog',
  'Thunderstorm Light Rain Hail',
  'Thunderstorm Heavy Rain Hail',
  'Thunderstorm Rain Small Hail/Snow Pellets',
  'Light Thunderstorm Rain Small Hail/Snow Pellets',
  'Heavy Thunderstorm Rain Small Hail/Snow Pellets',
];

const ICON_CLOUD_HAILSTONES = [
  'Ice Pellets',
  'Light Ice Pellets',
  'Heavy Ice Pellets',
  'Ice Pellets in Vicinity',
  'Showers Ice Pellets',
  'Ice Crystals',
  'Hail',
  'Small Hail/Snow Pellets',
  'Light Small Hail/Snow Pellets',
  'Heavy small Hail/Snow Pellets',
  'Showers Hail',
  'Hail Showers',
];

const ICON_CLOUD_SUN = [
  'Partly Cloudy',
  'Partly Cloudy with Haze',
  'Partly Cloudy and Breezy',
  'A Few Clouds',
  'A Few Clouds with Haze',
  'A Few Clouds and Breezy',
];

const ICON_CLOUD = [
  'Mostly Cloudy',
  'Mostly Cloudy with Haze',
  'Mostly Cloudy and Breezy',
  'Overcast',
  'Overcast with Haze',
  'Overcast and Breezy',
  'Fog/Mist',
  'Fog',
  'Freezing Fog',
  'Shallow Fog',
  'Partial Fog',
  'Patches of Fog',
  'Fog in Vicinity',
  'Freezing Fog in Vicinity',
  'Shallow Fog in Vicinity',
  'Partial Fog in Vicinity',
  'Patches of Fog in Vicinity',
  'Showers in Vicinity Fog',
  'Light Freezing Fog',
  'Heavy Freezing Fog',
  'Smoke',
  'Dust',
  'Low Drifting Dust',
  'Blowing Dust',
  'Sand',
  'Blowing Sand',
  'Low Drifting Sand',
  'Dust/Sand Whirls',
  'Dust/Sand Whirls in Vicinity',
  'Dust Storm',
  'Heavy Dust Storm',
  'Dust Storm in Vicinity',
  'Sand Storm',
  'Heavy Sand Storm',
  'Sand Storm in Vicinity',
];


/**
 * SandWeatherQueue Queue Worker.
 *
 * @QueueWorker(
 *   id = "sand_weather_queue",
 *   title = @Translation("Sand Weather Queue"),
 *   cron = {"time" = 300}
 * )
 */
class SandWeatherQueue extends QueueWorkerBase implements ContainerFactoryPluginInterface
{

    /**
     * The entity type manager.
     *
     * @var EntityTypeManagerInterface
     */
    protected EntityTypeManagerInterface $entityTypeManager;

    /**
     * The database connection.
     *
     * @var Connection
     */
    protected Connection $database;

    /**
     * Main constructor.
     *
     * @param array $configuration
     *   Configuration array.
     * @param mixed $plugin_id
     *   The plugin id.
     * @param mixed $plugin_definition
     *   The plugin definition.
     * @param EntityTypeManagerInterface $entity_type_manager
     *   The entity type manager.
     * @param Connection $database
     *   The connection to the database.
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, Connection $database)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->entityTypeManager = $entity_type_manager;
        $this->database = $database;
    }

    /**
     * Used to grab functionality from the container.
     *
     * @param ContainerInterface $container
     *   The container.
     * @param array $configuration
     *   Configuration array.
     * @param mixed $plugin_id
     *   The plugin id.
     * @param mixed $plugin_definition
     *   The plugin definition.
     *
     * @return static
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): static
    {
        /** @var EntityTypeManagerInterface $entity_type_manager */
        $entity_type_manager = $container->get('entity_type.manager');
        /** @var Connection $database */
        $database = $container->get('database');

        if (!$entity_type_manager) {
            \Drupal::logger('sand_weather')->error('EntityTypeManager service not found');
        }
        if (!$database) {
            \Drupal::logger('sand_weather')->error('Database service not found');
        }

        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $entity_type_manager,
            $database
        );
    }


    /**
     * Processes an item in the queue.
     *
     * @param mixed $data
     *   The queue item data.
     *
     * @throws \Exception
     */
    public function processItem($data): void
    {
        $this->refreshWeather();
    }

  /**
   * Set a weather icon name based on the text of the weather retrieved.
   *
   * @param string $val
   *   The weather description that needs to be mapped.
   *
   * @return string
   *   The name of the icon to display.
   */
  protected function getWeatherIcon(string $val): string
  {
    // Define all icon mappings.
    $icon_mappings = [
      'icon-sun' => ICON_SUN,
      'icon-cloud-sun' => ICON_CLOUD_SUN,
      'icon-cloud' => ICON_CLOUD,
      'icon-rain' => ICON_RAIN,
      'icon-cloud-lightning' => ICON_CLOUD_LIGHTNING,
      'icon-snow2' => ICON_SNOW2,
      'icon-cloud-hailstones' => ICON_CLOUD_HAILSTONES,
    ];

    // Clean up the input value.
    $val_clean = strtolower(trim($val));

    // First, check for an exact match (case-insensitive).
    foreach ($icon_mappings as $icon => $descriptions) {
      foreach ($descriptions as $description) {
        if (strtolower($description) === $val_clean) {
          return $icon;
        }
      }
    }

    // If no exact match found, proceed with substring search.
    foreach ($icon_mappings as $icon => $descriptions) {
      foreach ($descriptions as $description) {
        if (strpos(strtolower($description), $val_clean) !== false) {
          return $icon;
        }
      }
    }

    // If still no match, try searching with the last word in the string.
    $words = explode(' ', $val_clean);
    $last_word = end($words);

    foreach ($icon_mappings as $icon => $descriptions) {
      foreach ($descriptions as $description) {
        if (strpos(strtolower($description), $last_word) !== false) {
          return $icon;
        }
      }
    }

    // Log an error if no match found.
    \Drupal::logger('sand_weather')
      ->error('Weather type: %val not found.', ['%val' => $val]);

    return '';
  }

  /**
   * Refresh the Weather information config for use in the header.
   */
  protected function refreshWeather(): void
  {
    $config = \Drupal::config('sand_weather.settings');
    $url = 'https://forecast.weather.gov/MapClick.php?lat=32.718814&lon=-117.162222';
    $enable_logging = $config->get('enable_logging');

    if ($enable_logging) {
      \Drupal::logger('sand_weather')->info('Just entered refreshWeather method.');
    }

    // Get the current time and the last run time.
    $current_time = \Drupal::time()->getCurrentTime();
    $last_run_time = \Drupal::state()->get('sand_weather.last_run_time', 0);

    // Check if the function was run less than 4 minutes ago.
    if (($current_time - $last_run_time) < 240) {
      if ($enable_logging) {
        \Drupal::logger('sand_weather')->info('refreshWeather() was called but skipped because it was run less than 4 minutes ago.');
      }
      return;
    }

    // Update the last run time.
    \Drupal::state()->set('sand_weather.last_run_time', $current_time);

    // Store the old temperature and last update time for comparison.
    $weather_temp_old = \Drupal::state()->get('sand_weather.temp');
    $last_update_old = \Drupal::state()->get('sand_weather.last_update');

    try {
      $client = \Drupal::httpClient();
      $response = $client->get($url);

      if ($response->getStatusCode() == 200) {
        $html = (string) $response->getBody();

        // Load the HTML into DOMDocument.
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress warnings due to malformed HTML.
        $dom->loadHTML($html);
        libxml_clear_errors();

        // Create a new XPath object.
        $xpath = new \DOMXPath($dom);

        // Extract temperature.
        $tempNode = $xpath->query("//p[@class='myforecast-current-lrg']");
        if ($tempNode->length > 0) {
          $weather_temp = trim($tempNode->item(0)->nodeValue);
          // Remove the degree symbol and 'F'.
          $weather_temp = intval(str_replace(['°F', '°', 'F'], '', $weather_temp));
        } else {
          throw new \Exception('Temperature not found in the HTML.');
        }

        // Extract weather condition text.
        $conditionNode = $xpath->query("//p[@class='myforecast-current']");
        if ($conditionNode->length > 0) {
          $weather_text = trim($conditionNode->item(0)->nodeValue);
        } else {
          throw new \Exception('Weather condition not found in the HTML.');
        }

        // Extract Last update timestamp.
        $lastUpdateNode = $xpath->query("//td[b[text()='Last update']]/following-sibling::td");
        if ($lastUpdateNode->length > 0) {
          $last_update = trim($lastUpdateNode->item(0)->nodeValue);
        } else {
          throw new \Exception('Last update time not found in the HTML.');
        }

        // Check if the Last update timestamp has changed.
        if ($last_update === $last_update_old) {
          if ($enable_logging) {
            \Drupal::logger('sand_weather')->info('Last update timestamp has not changed. Exiting.');
          }
          return;
        }

        // Get the correct weather icon based on the text.
        $weather_icon = $this->getWeatherIcon($weather_text);

        // Log the fetched values if logging is enabled.
        if ($enable_logging) {
          \Drupal::logger('sand_weather')->info('Fetched weather data: temp={temp}, text={text}, icon={icon}, last_update={last_update}', [
            'temp' => $weather_temp,
            'text' => $weather_text,
            'icon' => $weather_icon,
            'last_update' => $last_update,
          ]);
        }

        // Set the state variables.
        \Drupal::state()->set('sand_weather.temp', $weather_temp);
        \Drupal::state()->set('sand_weather.icon', $weather_icon);
        \Drupal::state()->set('sand_weather.text', $weather_text);
        \Drupal::state()->set('sand_weather.last_update', $last_update);
        \Drupal::state()->set('sand_weather.wurl', $url);

        // Clear the cache tags if the temp has changed.
        if ($weather_temp !== $weather_temp_old) {
          Cache::invalidateTags(['sand_weather']);
          if ($enable_logging) {
            \Drupal::logger('sand_weather')->info('Cleared sand_weather block cache because temp changed.');
          }
        }
      } else {
        if ($enable_logging) {
          \Drupal::logger('sand_weather')->error('Failed to fetch weather data. Status code: {status}', ['status' => $response->getStatusCode()]);
        }
      }
    } catch (\Exception $exception) {
      \Drupal::logger('sand_weather')->error('Exception during weather update: {message}', ['message' => $exception->getMessage()]);
    }
  }

}
