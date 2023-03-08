<?php

namespace Drupal\sand_type\Query\Bundle;

use Drupal\node\Entity\Node;

class GallerySanDiegoQuery {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'gallery_san_diego')
      ->execute();
  }
  
}