<?php

namespace Drupal\if_sand_customphp\EventSubscriber\Theme;

use Drupal\core_event_dispatcher\Event\Theme\ThemeEvent;
use Drupal\core_event_dispatcher\ThemeHookEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Add in additional templates for controller based pages.
 */
class CustomBlockTemplates implements EventSubscriberInterface {

  /**
   * Add twig templates.
   */
  public function theme(ThemeEvent $event): void {
    $themes = [
      'customer_bill_calculator' => [
        'path' => 'modules/custom/if_sand_customphp/templates',
        'template' => 'customer-bill-calculator',
      ],
    ];
    $event->addNewThemes($themes);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      ThemeHookEvents::THEME => 'theme',
    ];
  }

}
