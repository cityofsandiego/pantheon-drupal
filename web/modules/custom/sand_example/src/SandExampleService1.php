<?php

namespace Drupal\sand_example;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;

/**
 * Service description.
 */
class SandExampleService1 implements SandExampleServiceInterface {

  /**
   * The container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected ContainerInterface $container;
  protected AccountProxy $current_user;

  /**
   * Constructs a SandExampleService1 object.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   */
  public function __construct(ContainerInterface $container, AccountProxy $current_user) {
    $this->container = $container;
    $this->current_user = $current_user;
  }

  /**
   * Example Method.
   */
  public function doSomething(): string {
    $userName = $this->current_user->getDisplayName();
    return 'ONE: This is text from the method doSomething() from SandExampleService1, presented to you: ' . $userName . ' (name courtesy of injected current_user service)';
  }

}
