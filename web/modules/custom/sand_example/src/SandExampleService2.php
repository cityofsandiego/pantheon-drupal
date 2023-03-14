<?php

namespace Drupal\sand_example;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Service description.
 */
class SandExampleService2 implements SandExampleServiceInterface {

  /**
   * The container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected ContainerInterface $container;

  /**
   * Constructs a SandExampleService1 object.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   */
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  /**
   * Sample Method.
   */
  public function doSomething(): string {
    return 'TWO: This is text from the method doSomething() from SandExampleService2';
  }

}
