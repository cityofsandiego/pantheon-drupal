<?php

namespace Drupal\glen\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example2 block.
 *
 * @Block(
 *   id = "glen_example2",
 *   admin_label = @Translation("Example2"),
 *   category = @Translation("Custom")
 * )
 */
class Example2Block extends BlockBase {

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
