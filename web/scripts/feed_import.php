<?php

/**
 * This starts a feed in batch (cron) via an argument of the feed-id.
 */

use Drupal\feeds\Entity\Feed;
use Drupal\feeds\FeedInterface;

if (empty($extra[0])) {
  $message = "Called feed import script with no feed id number";
  \Drupal::logger('my_module')->error($message);
  return FALSE;
} else {
  $id = $extra[0];
}

if (!is_numeric($id)) {
  $message = "Called feed import script with a non numeric feed id number";
  \Drupal::logger('my_module')->error($message);
  return FALSE;
}


$feed = Feed::load($id);
if (!$feed instanceof FeedInterface) {
  $message = "Called feed import script with numeric feed id number that does not exist: $id";
  \Drupal::logger('my_module')->error($message);
  return FALSE;
} else {
  /** @var \Drupal\feeds\Entity\Feed $feed */
  $feed->unlock();
  $feed->startCronImport();
}

