<?php

namespace Drupal\sand_type\Query\Bundle;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Service description.
 */
class DateQuery {

  /**
   * The container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected $container;

  /**
   * Constructs a QueryDate object.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   */
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  /**
   * Method description.
   */
  public static function getIds(): array {
    return \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('status', 1)
      ->condition('type', 'date')
      ->execute();
  }

  /**
   * Get all the Date nodes given dates and department Tids.
   * 
   * @param $days
   * @param $tids
   * @param $include_empty_tids
   *
   * @return array|int
   */
  public static function getDates(array $days, array $tids, bool $include_empty_tids = TRUE): array {
    $query = \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('type', 'date')
      ->condition('field_date_date', $days, 'IN')
      ->accessCheck(FALSE);

    // Allow for null/empty tids or not.
    if ($include_empty_tids) {
      $or = $query->orConditionGroup();
      $or->notExists('field_department');
      $or->condition('field_department', $tids, 'IN');
      $query->condition($or);
    }
    else {
      $query->condition('field_department', $tids, 'IN');
    }

    return $query->execute();
  }

}