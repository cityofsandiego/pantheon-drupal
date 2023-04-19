<?php

namespace Drupal\sand_tamper\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Drupal\feeds\Event\FeedsEvents;
use Drupal\feeds\Event\ParseEvent;

/**
 * Sand feeds event subscriber.
 */
class SandTamperSubscriber implements EventSubscriberInterface {

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

  public function afterParse(ParseEvent $event): void {

    /** @var \Drupal\feeds\FeedInterface $feed */
    $feed = $event->getFeed();
    $fields = $feed->getFieldDefinitions();
    $result = $event->getParserResult();

    for ($i = 0; $i < $result->count(); $i++) {
      if (!$result->offsetExists($i)) {
        break;
      }

      /** @var \Drupal\feeds\Feeds\Item\ItemInterface $item */
      $item = $result->offsetGet($i);

      /**
       * If this feed has any fields That we have created they will start with 
       * field_ . If that is the case Then set Fields on the item Starting with 
       * custom_module_ To the value from the feed field.
       */
      foreach ($fields as $field) {
        $name = $field->getName();
        if (str_starts_with($name, 'field_') && !empty($feed->{$name}->value)) {
          $base_name = str_replace('field_', '', $name);
          $item->set('sand_tamper_set_' . $base_name, $feed->{$name}->value);
        }

      }

    }
  }

}