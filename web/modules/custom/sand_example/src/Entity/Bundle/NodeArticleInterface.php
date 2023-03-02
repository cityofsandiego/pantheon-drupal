<?php

namespace Drupal\sand_example\Entity\Bundle;

interface NodeArticleInterface {
  public function getArticleType(): ?string;
}