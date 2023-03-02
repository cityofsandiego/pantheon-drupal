<?php

namespace Drupal\sand\Query\Bundle;

use Drupal\node\Entity\Node;

class OutreachArticle2Query {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'outreach_article2')
      ->execute();
  }
  
}