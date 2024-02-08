<?php

namespace Drupal\sand_feeds;

use Drupal\feeds\FeedInterface;
use Drupal\feeds\FeedsQueueExecutable;

class SandFeedsQueueExecutable extends FeedsQueueExecutable {
  /**
   * {@inheritdoc}
   */
  protected function createBatch(FeedInterface $feed, $stage) {
    return new SandFeedsQueueBatch($this, $feed, $stage, $this->queueFactory);
  }
}