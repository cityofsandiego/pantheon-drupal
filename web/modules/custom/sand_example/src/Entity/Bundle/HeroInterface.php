<?php

namespace Drupal\sand_example\Entity\Bundle;

use Drupal\Core\Entity\EntityStorageInterface;

interface HeroInterface {

  public function postSave(EntityStorageInterface $storage, $update = TRUE);
  
}