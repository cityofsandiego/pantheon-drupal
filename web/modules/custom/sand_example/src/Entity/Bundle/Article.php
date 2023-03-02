<?php

namespace Drupal\sand_example\Entity\Bundle;

use Drupal\node\Entity\Node;

class Article extends Node implements NodeArticleInterface, DepartmentInterface {
  
  use DepartmentTraits;
  
  public function getArticleType(): ?string {
    //return $this->get('field_article_type')->getValue()[0]['value'];
    return $this->get('field_article_type')->value;
  }


}
