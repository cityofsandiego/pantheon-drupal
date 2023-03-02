<?php

namespace Drupal\sand\Query\Bundle;

use Drupal\node\Entity\Node;

class ArticleQuery {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'article')
      ->execute();
  }
  
}