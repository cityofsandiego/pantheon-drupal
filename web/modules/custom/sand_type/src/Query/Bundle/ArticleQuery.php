<?php

namespace Drupal\sand_type\Query\Bundle;

use Drupal\node\Entity\Node;

class ArticleQuery {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('status', 1)
      ->condition('type', 'article')
      ->execute();
  }
  
}