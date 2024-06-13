<?php

namespace Drupal\sand_weather\Plugin\Block;

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;

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

    if (empty($weather_text) || empty($weather_icon) || empty($weather_temp)) {
      return [
        '#theme' => 'sand_weather',
        '#text' => "",
        '#icon' => "",
        '#temp' => "",
        '#wurl' => $weather_wurl,
      ];
    } else {
      return [
        '#theme' => 'sand_weather',
        '#text' => $weather_text,
        '#icon' => $weather_icon,
        '#temp' => $weather_temp,
        '#wurl' => $weather_wurl,
      ];
    }

  }
}
