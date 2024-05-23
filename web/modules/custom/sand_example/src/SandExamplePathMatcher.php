<?php

namespace Drupal\sand_example;

use Drupal\Core\Path\PathMatcher;
use Drupal\Core\Path\PathMatcherInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Provides a path matcher Decorator.
 */
class SandExamplePathMatcher implements PathMatcherInterface {
  
  protected PathMatcher $innerService;

  public function __construct(PathMatcher $inner_service, ConfigFactoryInterface $config_factory, RouteMatchInterface $route_match) {
    $this->innerService = $inner_service;
    $this->innerService->__construct($config_factory, $route_match);
  }

//  public function __call($method, $args) {
//    return call_user_func_array(array($this->innerService, $method), $args);
//  }
    
  /**
   * @inheritDoc
   */
  public function matchPath($path, $patterns): bool {
    return $this->innerService->matchPath($path, $patterns);
  }

  /**
   * @inheritDoc
   */
  public function isFrontPage(): bool {
    return $this->innerService->isFrontPage();
  }
  
  public function isAdmin(): bool {
    if (\Drupal::service('router.admin_context')->isAdminRoute()) {
      return true;
    } else {
      return false;
    }
  }

}