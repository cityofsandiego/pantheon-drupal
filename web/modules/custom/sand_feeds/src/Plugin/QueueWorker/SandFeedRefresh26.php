<?php

namespace Drupal\sand_feeds\Plugin\QueueWorker;

use Drupal\Core\Annotation\QueueWorker;
use Drupal\feeds\Plugin\QueueWorker\FeedRefresh;
use Drupal\sand_feeds\SandFeedsQueueExecutable;

/**
 * A queue worker for importing feeds.
 *
 * @QueueWorker(
 *   id = "sand_feeds_feed_refresh_id:26",
 *   title = @Translation("Sand Feed Refresh ID:26 - Doc scs_ccagenda_edir"),
 *   cron = {"time" = 321},
 * )
 */
class SandFeedRefresh26 extends FeedRefresh {

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

