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
use Symfony\Component\DomCrawler\Crawler;


const ICON_SNOW2 = [
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
  'Rain Snow',
  'Light Rain Snow',
  'Heavy Rain Snow',
  'Snow Rain',
  'Light Snow Rain',
  'Heavy Snow Rain',
  'Drizzle Snow',
  'Light Drizzle Snow',
  'Heavy Drizzle Snow',
  'Snow Drizzle',
  'Light Snow Drizzle',
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
  'Showers in Vicinity',
  'Showers in Vicinity Fog/Mist',
  'Showers in Vicinity Fog',
  'Showers in Vicinity Haze',
  'Freezing Rain Rain',
  'Light Freezing Rain Rain',
  'Heavy Freezing Rain Rain',
  'Rain Freezing Rain',
  'Light Rain Freezing Rain',
  'Heavy Rain Freezing Rain',
  'Freezing Drizzle Rain',
  'Light Freezing Drizzle Rain',
  'Heavy Freezing Drizzle Rain',
  'Rain Freezing Drizzle',
  'Light Rain Freezing Drizzle',
  'Heavy Rain Freezing Drizzle',
  'Light Rain',
  'Drizzle',
  'Light Drizzle',
  'Heavy Drizzle',
  'Light Rain Fog/Mist',
  'Drizzle Fog/Mist',
  'Light Drizzle Fog/Mist',
  'Heavy Drizzle Fog/Mist',
  'Light Rain Fog',
  'Drizzle Fog',
  'Light Drizzle Fog',
  'Heavy Drizzle Fog',
  'Rain',
  'Heavy Rain',
  'Rain Fog/Mist',
  'Heavy Rain Fog/Mist',
  'Rain Fog',
  'Heavy Rain Fog',
];

const ICON_SUN = [
  'Fair',
  'Clear',
  'Haze',
  'haze',
  'Fair with Haze',
  'Clear with Haze',
  'Fair and Breezy',
  'Clear and Breezy',
  'A Few Clouds',
  'A Few Clouds with Haze',
  'A Few Clouds and Breezy',
];

const ICON_CLOUD_LIGHTNING = [
  'Thunderstorm Ice Pellets',
  'Thunderstorm in Vicinity',
  'Thunderstorm in Vicinity Fog',
  'Thunderstorm in Vicinity Haze',
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
  'Thunderstorm Light Rain Haze',
  'Thunderstorm Heavy Rain Haze',
  'Thunderstorm Light Rain Fog',
  'Thunderstorm Heavy Rain Fog',
  'Thunderstorm Hail',
  'Light Thunderstorm Rain Hail',
  'Heavy Thunderstorm Rain Hail',
  'Light Thunderstorm Rain Hail Fog/Mist',
  'Heavy Thunderstorm Rain Hail Fog/Hail',
  'Thunderstorm Showers in Vicinity Hail',
  'Light Thunderstorm Rain Hail Haze',
  'Heavy Thunderstorm Rain Hail Haze',
  'Light Thunderstorm Rain Hail Fog',
  'Heavy Thunderstorm Rain Hail Fog',
  'Thunderstorm Light Rain Hail',
  'Thunderstorm Heavy Rain Hail',
  'Thunderstorm Rain Hail Fog/Mist',
  'Thunderstorm Light Rain Hail Fog/Mist',
  'Thunderstorm Heavy Rain Hail Fog/Mist',
  'Thunderstorm in Vicinity Hail',
  'Thunderstorm in Vicinity Hail Haze',
  'Thunderstorm Haze in Vicinity Hail',
  'Thunderstorm Light Rain Hail Haze',
  'Thunderstorm Heavy Rain Hail Haze',
  'Thunderstorm Hail Fog',
  'Thunderstorm Light Rain Hail Fog',
  'Thunderstorm Heavy Rain Hail Fog',
];

const ICON_CLOUD_HAILSTONES = [
  'Ice Pellets',
  'Light Ice Pellets',
  'Heavy Ice Pellets',
  'Ice Pellets in Vicinity',
  'Showers Ice Pellets',
  'Ice Crystals',
  'Hail',
  'Rain Ice Pellets',
  'Light Rain Ice Pellets',
  'Heavy Rain Ice Pellets',
  'Drizzle Ice Pellets',
  'Light Drizzle Ice Pellets',
  'Heavy Drizzle Ice Pellets',
  'Ice Pellets Rain',
  'Light Ice Pellets Rain',
  'Heavy Ice Pellets Rain',
  'Ice Pellets Drizzle',
  'Light Ice Pellets Drizzle',
  'Heavy Ice Pellets Drizzle',
  'Thunderstorm Small Hail/Snow Pellets',
  'Thunderstorm Rain Small Hail/Snow Pellets',
  'Light Thunderstorm Rain Small Hail/Snow Pellets',
  'Heavy Thunderstorm Rain Small Hail/Snow Pellets',
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
  'Mostly Clear',
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
];


/**
 * SandWeatherQueue Queue Worker.
 *
 * @QueueWorker(
 *   id = "sand_weather_queue",
 *   title = @Translation("Sand Weather Queue"),
 *   cron = {"time" = 60}
 * )
 */
class SandWeatherQueue extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
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
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Database\Connection $database
   *   The connection to the database.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, Connection $database) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->database = $database;
  }

  /**
   * Used to grab functionality from the container.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
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
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    /** @var \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager */
    $entity_type_manager = $container->get('entity_type.manager');
    /** @var \Drupal\Core\Database\Connection $database */
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
  public function processItem($data) {
    // Processing of queue items.
    \Drupal::logger('sand_weather')->error('Just entered processItem method.');
    $this->refreshWeather();
    \Drupal::logger('sand_weather')->error('Just ending processItem method.');
  }

    /**
     * Refresh the Weather information config for use in the header.
     */
    protected function refreshWeather(): void
    {
        $config = \Drupal::config('sand_weather.settings');
        $url = $config->get('weather_url');
        $api_url = "https://api.openweathermap.org/data/2.5/weather?lat=32.7157&lon=-117.1611&appid=edaf79b9a16c8b57ffe7910ff6a618f3&units=imperial";
        $enable_logging = $config->get('enable_logging');
        \Drupal::logger('sand_weather')->info('Just entered refreshWeather method. Logging enabled: {message}', ['message' => $enable_logging]);
        $weather_temp_old = \Drupal::state()->get('sand_weather.temp');

        try {
            $client = \Drupal::httpClient();
            $response = $client->get($api_url);

            if ($response->getStatusCode() == 200) {
                $body = (string)$response->getBody();
                $data = json_decode($body, true);

                // Extract the weather data from the JSON response
                $weather_temp = round($data['main']['temp']);
                $weather_text = $data['weather'][0]['description'];

                // Get the correct weather icon based on the text
                $weather_icon = $this->getWeatherIcon($weather_text);

                // Log the fetched values if logging is enabled
                if ($enable_logging) {
                    \Drupal::logger('sand_weather')->info('Fetched weather data: temp={temp}, text={text}, icon={icon}', [
                        'temp' => $weather_temp,
                        'text' => $weather_text,
                        'icon' => $weather_icon,
                    ]);
                }

                // Set the state variables
                \Drupal::state()->set('sand_weather.temp', $weather_temp);
                \Drupal::state()->set('sand_weather.icon', $weather_icon);
                \Drupal::state()->set('sand_weather.text', $weather_text);
                \Drupal::state()->set('sand_weather.wurl', (string)$url);

                // Log the updated state if logging is enabled
                if ($enable_logging) {
                    \Drupal::logger('sand_weather')->info('Updated state variables.');
                }

                // Clear the cache tags if the temp has changed. This tag is used in the block render array.
                if ($weather_temp !== $weather_temp_old) {
                    Cache::invalidateTags(['sand_weather']);
                }
            } else {
                if ($enable_logging) {
                    \Drupal::logger('sand_weather')->error('Failed to fetch weather data. Status code: {status}', ['status' => $response->getStatusCode()]);
                }
            }
        } catch (\Exception $exception) {
            if ($enable_logging) {
                \Drupal::logger('sand_weather')->error('Exception during weather update: {message}', ['message' => $exception->getMessage()]);
            }
        } catch (GuzzleException $e) {
        }
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
  protected function getWeatherIcon(string $val): string {
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

    // First, check for an exact match.
    foreach ($icon_mappings as $icon => $descriptions) {
      if (in_array($val, $descriptions)) {
        return $icon;
      }
    }

    // If no exact match found, proceed with case-insensitive substring search.
    $val_lower = strtolower($val);
    $matches = [];

    foreach ($icon_mappings as $icon => $descriptions) {
      $count = 0;
      foreach ($descriptions as $description) {
        if (strpos(strtolower($description), $val_lower) !== false) {
          $count++;
        }
      }
      $matches[$icon] = $count;
    }

    // Find the icon with the highest match count.
    arsort($matches);
    $best_match = key($matches);
    $best_match_count = reset($matches);

    if ($best_match_count > 0) {
      return $best_match;
    }

    // If no matches are found, try searching with the last word in the string.
    $words = explode(' ', $val_lower);
    if (count($words) > 1) {
      $last_word = end($words);
      $matches = [];

      foreach ($icon_mappings as $icon => $descriptions) {
        $count = 0;
        foreach ($descriptions as $description) {
          if (strpos(strtolower($description), $last_word) !== false) {
            $count++;
          }
        }
        $matches[$icon] = $count;
      }

      // Find the icon with the highest match count.
      arsort($matches);
      $best_match = key($matches);
      $best_match_count = reset($matches);

      if ($best_match_count > 0) {
        return $best_match;
      }
    }

    // Log an error if no match found.
    \Drupal::logger('sand_weather')
      ->error('Weather type: %val not found from weather.gov', ['%val' => $val]);

    return '';
  }

}
