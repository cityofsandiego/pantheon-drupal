<?php

namespace Drupal\sand_type\Entity\Bundle\Interface;

interface ArticleInterface {
  public function getArticleType(): ?string;
}