<?php

namespace Drupal\sand_type;

use Drupal\Core\DependencyInjection\ContainerNotInitializedException;
use Symfony\Component\DependencyInjection\ContainerInterface;


class SandType {

  /**
   * The currently active container object, or NULL if not initialized yet.
   *
   * @var \Drupal\Component\DependencyInjection\ContainerInterface|null
   */
  protected static $container;

  /**
   * Sets a new global container.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   A new container instance to replace the current.
   */
  public static function setContainer(ContainerInterface $container) {
    static::$container = $container;
  }

  /**
   * Returns the currently active global container.
   *
   * @return \Drupal\Component\DependencyInjection\ContainerInterface
   *
   * @throws \Drupal\Core\DependencyInjection\ContainerNotInitializedException
   */
  public static function getContainer() {
    if (static::$container === NULL) {
      throw new ContainerNotInitializedException('\Drupal::$container is not initialized yet. \Drupal::setContainer() must be called with a real container.');
    }
    return static::$container;
  }

}