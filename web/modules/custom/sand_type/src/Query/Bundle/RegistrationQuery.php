<?php

namespace Drupal\sand_type\Query\Bundle;

use Drupal\node\Entity\Node;

class RegistrationQuery {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'registration')
      ->execute();
  }
  
}