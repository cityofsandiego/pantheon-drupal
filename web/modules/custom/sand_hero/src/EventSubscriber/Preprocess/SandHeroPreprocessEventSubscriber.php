<?php

namespace Drupal\sand_hero\EventSubscriber\Preprocess;

use Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExamplePreprocessorEventSubscriber.
 *
 * Don't forget to define your class as a service and tag it as
 * an "event_subscriber":
 *
 * services:
 *  hook_event_dispatcher.example_preprocess_subscribers:
 *   class: Drupal\hook_event_dispatcher\ExamplePreprocessEventSubscribers
 *   tags:
 *     - { name: event_subscriber }
 */
final class SandHeroPreprocessEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      PagePreprocessEvent::name() => 'preprocessPage',
    ];
  }

  /**
   * Preprocess a node page to set the node title as page title.
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent $event
   *   Event.
   */
  public function preprocessPage(PagePreprocessEvent $event): void {
    /** @var \Drupal\preprocess_event_dispatcher\Variables\PageEventVariables $variables */
    $variables = $event->getVariables();
    $node = $variables->getNode();

    if ($node === NULL) {
      $variables->set('title', 'Not a node stupid');
      \Drupal::messenger()->addMessage('Not a node stupid');
      return;
    }

    $variables->set('title', $node->getTitle());
    \Drupal::messenger()->addMessage('Yea Im a node');
  }

}
