<?php

namespace Drupal\sand_weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;


/**
 * Provides a san diego weather block.
 *
 * @Block(
 *   id = "sand_weather",
 *   admin_label = @Translation("San Diego Weather"),
 *   category = @Translation("Custom")
 * )
 */
class SanDiegoWeatherBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {

    $weather_text = \Drupal::state()->get('sand_weather.text');
    $weather_icon = \Drupal::state()->get('sand_weather.icon');
    $weather_temp = \Drupal::state()->get('sand_weather.temp');
    $weather_wurl = \Drupal::state()->get('sand_weather.wurl');

    return [
      '#theme' => 'sand_weather',
      '#text' => $weather_text,
      '#icon' => $weather_icon,
      '#temp' => $weather_temp,
      '#wurl' => $weather_wurl,
      '#cache' => [
        'tags' => ['sand_weather'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), ['sand_weather']);
  }
}
