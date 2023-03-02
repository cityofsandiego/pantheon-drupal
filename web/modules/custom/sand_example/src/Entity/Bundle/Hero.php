<?php

namespace Drupal\sand_example\Entity\Bundle;

use Drupal\node\Entity\Node;
use Drupal\Core\Entity\EntityStorageInterface;

class Hero extends Node implements DepartmentInterface, HeroInterface {

  use DepartmentTraits;

  public function getTimeOfDay(): string {
    return $this->get('field_hero_time_of_day')->value;
  }

  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    if ($update == FALSE) {
      \Drupal::messenger()->addStatus(t('Thank you for adding the new hero @title.', ['@title' => $this->toLink()->toString()]));
    }
    parent::postSave($storage, $update);
  } 

}