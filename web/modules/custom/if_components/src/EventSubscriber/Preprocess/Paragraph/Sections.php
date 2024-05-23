<?php

namespace Drupal\if_components\EventSubscriber\Preprocess\Paragraph;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\file\Entity\File;
use Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Preprocess paragraph: Sections Outreach
 *
 * @package Drupal\if_components\EventSubscriber\Preprocess
 */
final class Sections implements EventSubscriberInterface {

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
      ParagraphPreprocessEvent::name('sections') => 'preprocessSections',
    ];
  }

  /**
   * Implements hook_preprocess_paragraph() for the section Outreach.
   *
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent $event
   *   Paragraph event.
   */
  public function preprocessSections(ParagraphPreprocessEvent $event): void {
    $variables = $event->getVariables();

    $paragraph = $variables->getParagraph();

    // Preprocess image to get URL
    if (!$paragraph->field_image->isEmpty()) {
      $field_image = $paragraph->field_image->getValue();

      $image = $this->entityTypeManager->getStorage('media')->load( $paragraph->get('field_image')->getValue()[0]['target_id']);
      $fid = $image->getSource()->getSourceFieldValue($image);
      $image_file = File::load($fid);
      $url = $image_file->createFileUrl();
      $variables->set('image_url', $url);
    }

    //Set values for image attributes in Twig template.
    $horizontal = '0';
    $variables->set('percent_horizontal', $horizontal);

    $vertical = '0';
    $variables->set('percent_vertical', $vertical);

    $vertical_offset = '';
    $variables->set('vertical_offset', $vertical_offset);

    $field_minimum_height = $paragraph->field_minimum_height->value;
    $min_height  = $field_minimum_height ? $field_minimum_height . 'px' : '300px';
    $variables->set('min_height', $min_height);
    
    $adjustment_width  = '';
    $variables->set('adjustment_width', $adjustment_width);
    
    $adjustment_height = '';
    $variables->set('adjustment_height', $adjustment_height);
    
    $background_size = '';
    $variables->set('background_size', $background_size);

    $field_bg_color = $paragraph->field_bg_color->value;
    $background_color = $field_bg_color ? '#' . $field_bg_color : '#FFF';
    $variables->set('bg_color', $background_color);

    $field_image_scroll_ratio = $paragraph->field_image_scroll_ratio->value;
    $variables->set('scroll_ratio', $field_image_scroll_ratio);

    $field_full_width_mobile = $paragraph->field_full_width_mobile->value;
    $full_width_mobile =  $field_full_width_mobile ? 'background-size: 100% auto' : '';
    $variables->set('full_width_mobile', $full_width_mobile);

    //Set text styles
    if ($paragraph->field_centered->value) {
      $variables->set('text_center', 'text-center');
    }
  }
}