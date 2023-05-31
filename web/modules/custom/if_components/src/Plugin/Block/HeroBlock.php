<?php

namespace Drupal\if_components\Plugin\Block;

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a san diego weather block.
 *
 * @Block(
 *   id = "hero_block",
 *   admin_label = @Translation("San Diego Hero Block"),
 *   category = @Translation("Custom")
 * )
 */
class HeroBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#markup' => "",
      '#allowed_tags' => ['script'],
    ];
  }

}
