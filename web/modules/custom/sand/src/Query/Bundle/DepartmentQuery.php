<?php

namespace Drupal\sand\Query\Bundle;

use Drupal\node\Entity\Node;

class DepartmentQuery {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'department')
      ->execute();
  }
  
}