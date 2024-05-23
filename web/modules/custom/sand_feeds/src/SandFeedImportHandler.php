<?php

namespace Drupal\sand_feeds;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\feeds\Exception\LockException;
use \Drupal\feeds\FeedImportHandler;
use Drupal\feeds\FeedInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SandFeedImportHandler extends FeedImportHandler {

  /**
   * Starts importing a feed via cron.
   *
   * @param \Drupal\feeds\FeedInterface $feed
   *   The feed to queue.
   *
   * @throws \Drupal\feeds\Exception\LockException
   *   Thrown if a feed is locked.
   */
  public function startCronImport(FeedInterface $feed) {
    if ($feed->isLocked()) {
      $args = ['@id' => $feed->bundle(), '@fid' => $feed->id()];
      throw new LockException($this->t('The feed @id / @fid is locked.', $args));
    }

    $this->getExecutable(SandFeedsQueueExecutable::class)
      ->processItem($feed, SandFeedsQueueExecutable::BEGIN);

    // Add timestamp to avoid queueing item more than once.
    $feed->setQueuedTime($this->getRequestTime());
    $feed->save();
  }

  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $container->get('event_dispatcher'),
      $container->get('database')
    );
  }

}