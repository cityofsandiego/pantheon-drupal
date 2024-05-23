<?php

namespace Drupal\sand_example\Entity\Decorator;

/**
 * Class EntityDecorator.
 */
class EntityDecorator extends Decorator {

  /**
   * @var array
   */
  protected $entities;

  /**
   * @return mixed
   */
  public function getEntities() {
    return $this->entities;
  }

}
