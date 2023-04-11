<?php

namespace Drupal\sand_feeds\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Drupal\feeds\Event\FeedsEvents;
use Drupal\feeds\Event\ParseEvent;

/**
 * Sand feeds event subscriber.
 */
class SandFeedsSubscriber implements EventSubscriberInterface {

  /**
   * Subscriber to Feeds events.
   *
   * This happens after parsing and before going
   * into processing.
   */
  public static function getSubscribedEvents() {
    $events[FeedsEvents::PARSE][] = ['afterParse', FeedsEvents::AFTER];
    return $events;
  }

  /**
   * Before inserting item.
   */
  public function afterParse(ParseEvent $event) {

    /** @var \Drupal\feeds\FeedInterface $feed */
    $feed = $event->getFeed();
    $feed_bundle_name = $feed->bundle();

    // Only alter a particular feed
    if (strpos($feed_bundle_name, "sand_remote") === 0) {



      /** @var \Drupal\feeds\Result\ParserResultInterface $result */
      $result = $event->getParserResult();

      for ($i = 0; $i < $result->count(); $i++) {
        if (!$result->offsetExists($i)) {
          break;
        }

        /** @var \Drupal\feeds\Feeds\Item\ItemInterface $item */
        $item = $result->offsetGet($i);

        if ($feed->hasField('field_source_name')) {
          $item->set('tamper_source_name', $feed->field_source_name->value);
        }
        
        if ($feed->hasField('field_sort1')) {
          $item->set('tamper_sort1', $feed->field_sort1->value);
        }
        
      }
    }
  }

}
