<?php

namespace Drupal\sand_feeds;

use Drupal\feeds\FeedsQueueBatch;

class SandFeedsQueueBatch extends FeedsQueueBatch {
  public function run() {
    // Queue all operations now.
    foreach ($this->operations as $operation) {
      $id = sprintf('%02d', $this->feed->id());
      $this->queueFactory->get('sand_feeds_feed_refresh_id:' . $id)
        ->createItem([
          $this->feed->id(),
          $operation['stage'],
          $operation['params'],
        ]);
    }
  }
}