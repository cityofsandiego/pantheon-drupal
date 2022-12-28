<?php

namespace Drupal\sandremote;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a sandremote entity type.
 */
interface SandremoteInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
