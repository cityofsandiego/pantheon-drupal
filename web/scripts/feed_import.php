<?php

/**
 * This starts a feed in batch (cron) via an argument of the feed-id.
 */

use Drupal\feeds\Entity\Feed;
use Drupal\feeds\FeedInterface;

if (empty($extra[0])) {
  \Drupal::logger('feed_import.php')->error("Called feed import script with no feed id number");
  return FALSE;
} else {
  $id = $extra[0];
}

if (!is_numeric($id)) {
  \Drupal::logger('feed_import.php')->error( "Called feed import script with a non numeric feed id number of :id", [':id' => $id]);
  return FALSE;
}


$feed = Feed::load($id);
if (!$feed instanceof FeedInterface) {
  $this->logger->notice('Sent email to %recipient', ['%recipient' => $recipient]);
  \Drupal::logger('feed_import.php')->error("Called feed import script with numeric feed id number that does not exist: :id", [':id' => $id]);
  return FALSE;
} else {
  /** @var \Drupal\feeds\Entity\Feed $feed */
  if (!$feed->isLocked()) {
    $feed->startCronImport();
  } else {
    \Drupal::logger('feed_import.php')->warning("Called feed import script for id number :id, but the feed is locked",[':id' => $id]);
  }
}

