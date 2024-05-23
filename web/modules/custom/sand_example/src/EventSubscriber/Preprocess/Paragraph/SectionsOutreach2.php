<?php

namespace Drupal\if_components\EventSubscriber\Preprocess\Paragraph;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\file\Entity\File;
use Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Preprocess paragraph: Sections Outreach 2
 *
 * @package Drupal\if_components\EventSubscriber\Preprocess
 */
final class SectionsOutreach2 implements EventSubscriberInterface {

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
      ParagraphPreprocessEvent::name('sections_outreach2') => 'preprocessSectionsOutreach2',
    ];
  }

  /**
   * Implements hook_preprocess_paragraph() for the section outreach 2.
   *
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent $event
   *   Paragraph event.
   */
  public function preprocessSectionsOutreach2(ParagraphPreprocessEvent $event): void {
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
    $field_horizontal = $paragraph->field_horizontal->value;
    $horizontal = $field_horizontal ? $field_horizontal : '50';
    $variables->set('percent_horizontal', $horizontal);

    $field_vertical = $paragraph->field_vertical->value;
    $vertical = $field_vertical ? $field_vertical : '50';
    $variables->set('percent_vertical', $vertical);

    $field_vertical_offset = $paragraph->field_vertical_offset->value;
    $vertical_offset = $field_vertical_offset ? $field_vertical_offset : '';
    $variables->set('vertical_offset', $vertical_offset);

    $field_minimum_height = $paragraph->field_minimum_height->value;
    $min_height  = $field_minimum_height ? $field_minimum_height . 'px' : '300px';
    $variables->set('min_height', $min_height);

    $field_adjustment_width = $paragraph->field_adjustment_width->value;
    $adjustment_width  = $field_adjustment_width ? $field_adjustment_width . 'px' : '';
    $variables->set('adjustment_width', $adjustment_width);

    $field_outreach_adjustment_height = $paragraph->field_outreach_adjustment_height->value;
    $adjustment_height = $field_outreach_adjustment_height ? $field_outreach_adjustment_height . 'px' : '';
    $variables->set('adjustment_height', $adjustment_height);

    $field_background_size = $paragraph->field_background_size->value;
    $background_size = $field_background_size ? $field_background_size : '';
    $variables->set('background_size', $background_size);

    $field_bg_color = $paragraph->field_bg_color->value;
    $background_color = $field_bg_color ? '#' . $field_bg_color : '#FFF';
    $variables->set('bg_color', $background_color);

    $field_image_scroll_ratio = $paragraph->field_image_scroll_ratio->value;
    $variables->set('scroll_ratio', $field_image_scroll_ratio);

    // This should override full_width_mobile if that is set.
    if ($paragraph->field_mobile_size->value) {
      $field_mobile_size = $paragraph->field_mobile_size->value;
      $variables->set('full_width_mobile', $field_mobile_size);
    } else {
      $field_full_width_mobile = $paragraph->field_full_width_mobile->value;
      $full_width_mobile =  $field_full_width_mobile ? 'background-size: 100% auto' : '';
      $variables->set('full_width_mobile', $full_width_mobile);
    }

    if ($paragraph->field_repeat->value) {
      $variables->set('repeat', 'repeat-x');
    } 


    // Hide on desktop or mobile
    if ($paragraph->field_hide_on_desktop->value) {
      $variables->set('hide_on_desktop', 'hide-on-desktop');
    } 
    $variables->set('hide_on_desktop', $paragraph->field_hide_on_desktop->value);
    
    if ($paragraph->field_hide_on_mobile->value) {
      $variables->set('hide_on_mobile', 'hide-on-mobile');
    } 
    $variables->set('hide_on_mobile', $paragraph->field_hide_on_mobile->value);

    //Set text styles
    if ($paragraph->field_centered->value) {
      $variables->set('text_center', 'text-center');
    } 
    if ($paragraph->field_no_drop_shadow->value) {
      $variables->set('no_shadow', 'no-shadow');
    }

    $field_no_styling = $paragraph->field_no_styling->value;
    $no_styling = $field_no_styling ? true : false;
    $variables->set('no_styling', $no_styling);


    // Create variable for border bottom (field_bottom_border)
    if (!$paragraph->field_bottom_border->isEmpty()) {  
      $field_bottom_border = $paragraph->field_bottom_border->value;
      switch ($field_bottom_border) {
        case '0':
          $border = 'border-bottom-none';
          break;
  
        case '1':
          $border = 'border-bottom-thin';
          break;
  
        case '2':
          $border = 'border-bottom-thick';
          break;
      };
      $variables->set('border_bottom', $border);
    }
  }
}