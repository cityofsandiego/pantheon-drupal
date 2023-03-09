<?php

namespace Drupal\if_components\EventSubscriber\Preprocess\Paragraph;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Preprocess paragraph: amenities_restrictions
 *
 * @package Drupal\if_components\EventSubscriber\Preprocess
 */
final class AmenitiesRestrictions implements EventSubscriberInterface {

  /**
   * Entity type manager interface.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new Section.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      ParagraphPreprocessEvent::name('amenities_restrictions') => 'preprocessAmenitiesRestrictions',
    ];
  }

  /**
   * Implements hook_preprocess_paragraph() for amenities_restrictions.
   *
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent $event
   *   Paragraph event.
   */
  public function preprocessAmenitiesRestrictions(ParagraphPreprocessEvent $event): void {

    $variables = $event->getVariables();

    $paragraph = $variables->getParagraph();

    $node = $paragraph->getParentEntity();

    // Preprocess Restrictions to change class names
    if (!$node->field_restrictions->isEmpty()) {
      $variables->set('restrictions', $node->field_restrictions->getValue()[0]['value']);
    }
  }
}