<?php

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\feeds\Entity\Feed;
use Drupal\feeds\FeedInterface;


class SandFeeds extends Feed {

  public function importFeed($fid) {

    $feed = $this->getFeed($fid);

    // Check if the feed we got is valid.
    if ($feed instanceof FeedInterface) {
      // Only import feed if it is either active, or the user specifically wants
      // to import the feed regardless of its active state.
      if (!$feed->isActive()) {
        return;
      }

      if (!$feed->isLocked()) {
        return;
      }

      // start import!
      try {
        $feed->import();
      } catch (Exception $e) {
      }

    }
  }
  
  private function getFeed($fid) {
    try {
      // Load the feed entity.
      return $this->entityTypeManager
        ->getStorage('feeds_feed')
        ->load($fid);
    }
    catch (InvalidPluginDefinitionException $e) {
      $this->logger()->error($e->getMessage());
    }
    catch (PluginNotFoundException $e) {
      $this->logger()->error($e->getMessage());
    }
    // An error seems to have occurred when getting here, return null.
    return NULL;
  }

}