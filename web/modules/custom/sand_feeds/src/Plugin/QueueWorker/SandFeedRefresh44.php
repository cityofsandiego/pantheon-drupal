<?php

namespace Drupal\sand_feeds\Plugin\QueueWorker;

use Drupal\Core\Annotation\QueueWorker;
use Drupal\feeds\Plugin\QueueWorker\FeedRefresh;
use Drupal\sand_feeds\SandFeedsQueueExecutable;

/**
 * A queue worker for importing feeds.
 *
 * @QueueWorker(
 *   id = "sand_feeds_feed_refresh_id:44",
 *   title = @Translation("Sand Feed Refresh ID:44 - Doc scs_council_reso_ordinance 2016_current"),
 *   cron = {"time" = 321},
 * )
 */
class SandFeedRefresh44 extends FeedRefresh {

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

