<?php

namespace Drupal\sand_example\Entity\Bundle;

use Drupal\node\Entity\Node;

class Hero extends Node implements DepartmentInterface {

  use DepartmentTraits;

  public function getTimeOfDay(): string {
    return $this->get('field_hero_time_of_day')->value;
  }

}