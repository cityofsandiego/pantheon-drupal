<?php

namespace Drupal\sand_remote;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a sand_remote entity type.
 */
interface SandremoteInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
