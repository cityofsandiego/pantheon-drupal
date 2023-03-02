<?php

/**
 * This is an example of a Bundle Class. 
 * For an explanation see 
 *   https://www.hashbangcode.com/article/drupal-9-entity-bundle-classes 
 * 
 * Basically we can put all the business logic associated with a content type
 * in one place and have it easily available elsewhere with little pain and 
 * without having to wrap the "Node" class in another class before we use it.
 */

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