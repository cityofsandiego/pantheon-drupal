<?php

namespace Drupal\sand\Query\Bundle;

use Drupal\node\Entity\Node;

class BlogQuery {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'blog')
      ->execute();
  }
  
}