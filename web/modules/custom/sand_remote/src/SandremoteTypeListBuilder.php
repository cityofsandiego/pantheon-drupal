<?php

namespace Drupal\sand_remote;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of sand_remote type entities.
 *
 * @see \Drupal\sand_remote\Entity\SandremoteType
 */
class SandremoteTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['title'] = $this->t('Label');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['title'] = [
      'data' => $entity->label(),
      'class' => ['menu-label'],
    ];

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No sand_remote types available. <a href=":link">Add sand_remote type</a>.',
      [':link' => Url::fromRoute('entity.sand_remote_type.add_form')->toString()]
    );

    return $build;
  }

}
