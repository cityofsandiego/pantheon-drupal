<?php

namespace Drupal\sand\Entity\Bundle\Interface;

interface ArticleInterface {
  public function getArticleType(): ?string;
}