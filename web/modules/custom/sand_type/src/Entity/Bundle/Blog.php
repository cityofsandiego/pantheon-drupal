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

use Drupal\sand_type\Entity\Bundle\Interface\DepartmentInterface;
use Drupal\sand_type\Entity\Bundle\Traits\DepartmentTraits;

class Blog extends Node implements DepartmentInterface {

  use DepartmentTraits;

  /**
   * Get the processed form of the URL.
   * 
   * Basically processes the 'internal:'  and 'entity:' schemas. Initially used
   * for the node--blog.html.twig template.
   * 
   * @return string
   */
  public function getWebSiteURL(): string {
    $website_url = $this->get('field_website')->getString('uri') ?? '';
    if (str_starts_with($website_url, 'internal:')) {
      return str_replace('internal:', '', $website_url);
    }
    elseif (str_starts_with($website_url, 'entity:')) {
      return str_replace('entity:', '/', $website_url);
    } 
    else {
      return $website_url;
    }
  }
}