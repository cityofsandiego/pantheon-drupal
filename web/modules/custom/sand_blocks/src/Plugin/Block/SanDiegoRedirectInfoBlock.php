<?php

namespace Drupal\sand_blocks\Plugin\Block;

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a san diego weather block.
 *
 * @Block(
 *   id = "sand_blocks_redirect_info",
 *   admin_label = @Translation("San Diego Redirects in Code"),
 *   category = @Translation("Custom")
 * )
 */
class SanDiegoRedirectInfoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {

    $redirects = \Drupal\Core\Site\Settings::get('redirects');
    return [
      '#theme' => 'sand_blocks_redirect_info',
      '#redirects' => $redirects,
    ];
  }

}
