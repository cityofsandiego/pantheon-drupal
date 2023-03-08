<?php

declare(strict_types=1);

namespace Drupal\sand_weather\Plugin\QueueWorker;

use Drupal\Core\Annotation\QueueWorker;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('database'),
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
    $this->refreshWeather();
  }

  /**
   * Refresh the Weather information config for use in the header.
   */
  protected function refreshWeather(): void {
    $url = \Drupal::config('sand_weather.settings')->get('weather_url');

    try {
      // @todo Fix dependency with Dependency Injection Container.
      $client = \Drupal::httpClient();
      $response = $client->get($url);
      
      if ($response->getStatusCode() == 200) {
        $body = (string) $response->getBody();
        $xml = simplexml_load_string($body);
        if (isset($xml->temp_f)) {
          // Do not show .0 in the temperature in the header.
          $weather_temp = str_replace('.0', '', (string) $xml->temp_f);
          \Drupal::state()->set('sand_weather.temp', $weather_temp);
        }
        if (isset($xml->weather)) {
          $weather_text = (string) $xml->weather;
          $weather_icon = $this->getWeatherIcon($weather_text);
          \Drupal::state()->set('sand_weather.text', $weather_text);
          \Drupal::state()->set('sand_weather.icon', $weather_icon);
        }
      }
    } catch (\Exception $exception) {
      watchdog_exception('sand_weather', $exception);
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

    if (in_array($val, ICON_SUN)) {
      return 'icon-sun';
    }
    if (in_array($val, ICON_CLOUD_SUN)) {
      return 'icon-cloud-sun';
    }
    if (in_array($val, ICON_CLOUD)) {
      return 'icon-cloud';
    }
    if (in_array($val, ICON_RAIN)) {
      return 'icon-rain';
    }
    if (in_array($val, ICON_CLOUD_LIGHTNING)) {
      return 'icon-cloud-lightning';
    }
    if (in_array($val, ICON_SNOW2)) {
      return 'icon-snow2';
    }

    if (in_array($val, ICON_CLOUD_HAILSTONES)) {
      return 'icon-cloud-hailstones';
    }

    \Drupal::logger('sand_weather')
      ->error('Weather type: %val not found from weather.gov', ['%val' => $val]);
    return '';
  }

}
