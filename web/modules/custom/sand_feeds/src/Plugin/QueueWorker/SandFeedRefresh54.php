<?php

namespace Drupal\sand_feeds\Plugin\QueueWorker;

use Drupal\Core\Annotation\QueueWorker;
use Drupal\feeds\Plugin\QueueWorker\FeedRefresh;
use Drupal\sand_feeds\SandFeedsQueueExecutable;

/**
 * A queue worker for importing feeds.
 *
 * @QueueWorker(
 *   id = "sand_feeds_feed_refresh_id:54",
 *   title = @Translation("Sand Feed Refresh ID:54 - Doc scs_redevelagency_reports"),
 *   cron = {"time" = 321},
 * )
 */
class SandFeedRefresh54 extends FeedRefresh {

  /**
   * Returns Feeds executable.
   *
   * @return \Drupal\feeds\FeedsExecutableInterface
   *   A feeds executable.
   */
  protected function getExecutable() {
    return \Drupal::service('class_resolver')->getInstanceFromDefinition(SandFeedsQueueExecutable::class);
  }

}

