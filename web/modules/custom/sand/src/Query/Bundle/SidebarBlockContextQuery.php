<?php

namespace Drupal\sand\Query\Bundle;

use Drupal\node\Entity\Node;

class SidebarBlockContextQuery {

  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'sidebar_block_context')
      ->execute();
  }
  
}