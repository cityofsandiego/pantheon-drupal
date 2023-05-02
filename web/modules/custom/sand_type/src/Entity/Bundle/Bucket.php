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

namespace Drupal\sand_type\Entity\Bundle;

use Drupal\node\Entity\Node;

class Bucket extends Node {

}