<?php

namespace Drupal\sand\Query\Bundle;

use Drupal\node\Entity\Node;

class MayoralArtifactsQuery {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'mayoral_artifacts')
      ->execute();
  }
  
}