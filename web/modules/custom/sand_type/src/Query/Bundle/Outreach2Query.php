<?php

namespace Drupal\sand_type\Query\Bundle;

use Drupal\node\Entity\Node;

class Outreach2Query {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('status', 1)
      ->condition('type', 'outreach2')
      ->execute();
  }
  
}