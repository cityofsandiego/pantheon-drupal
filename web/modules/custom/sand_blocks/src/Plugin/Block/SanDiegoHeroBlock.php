<?php

namespace Drupal\sand_blocks\Plugin\Block;

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a san diego block.
 *
 * @Block(
 *   id = "heroblock",
 *   admin_label = @Translation("San Diego Hero"),
 *   category = @Translation("Custom")
 * )
 */
class SanDiegoHeroBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build(): array {

        $x = ['/sites/default/files/pools-header.jpg', '/sites/default/files/police-.jpg'];
        return [
            '#theme' => 'heroblock',
            '#text' => $x[rand(0,1)],
            '#cache' => [
                'max-age' => 60
            ],
        ];
    }
}
