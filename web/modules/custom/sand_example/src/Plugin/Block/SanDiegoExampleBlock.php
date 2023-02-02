<?php

namespace Drupal\sand_example\Plugin\Block;

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a san diego weather block.
 *
 * @Block(
 *   id = "sand_example",
 *   admin_label = @Translation("San Diego Example"),
 *   category = @Translation("Custom")
 * )
 */
class SanDiegoExampleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    // This is a contrived example of decorating the service path.matcher.
    // The method isAdmin was added to the decorator class SandExamplePathMatcher 
    $isAdmin = \Drupal::service('path.matcher')->isAdmin();
    if ($isAdmin) {
      $text = 'Admin Page';
    }
    else {
      $text = 'NOT Admin Page';
    }

    return [
      '#theme' => 'sand_example',
      '#text' => $text,
    ];
  }

}
