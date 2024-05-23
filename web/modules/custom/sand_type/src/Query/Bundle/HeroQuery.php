<?php

namespace Drupal\sand_type\Query\Bundle;

use Drupal\node\Entity\Node;

class HeroQuery {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->accessCheck(FALSE)
      ->condition('status', 1)
      ->condition('type', 'hero')
      ->execute();
  }
  
}