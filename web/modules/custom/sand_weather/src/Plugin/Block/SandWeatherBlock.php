<?php

namespace Drupal\sand_weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a sand weather block.
 *
 * @Block(
 *   id = "sand_weather",
 *   admin_label = @Translation("Sand Weather"),
 *   category = @Translation("Custom")
 * )
 */
class SandWeatherBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
