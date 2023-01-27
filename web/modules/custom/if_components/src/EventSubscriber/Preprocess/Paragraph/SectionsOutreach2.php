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
   * Text style.
   *
   * @var array
   */
  protected $textStyle = [];


  /**
   * Background image styles.
   *
   * @var array
   */
  protected $bgStyle = [];

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

    // Reset styles since they seem to stick when there are multiple
    // sections paragraphs on the page.
    $this->bgStyle = [];
    $this->textStyle = [];

    // Preprocess background image attributes and style
      if (!$paragraph->field_image->isEmpty()) {
        // Preprocess image to get URL
        $field_image = $paragraph->field_image->getValue();

        $image = $this->entityTypeManager->getStorage('media')->load( $paragraph->get('field_image')->getValue()[0]['target_id']);
        $fid = $image->getSource()->getSourceFieldValue($image);
        $image_file = File::load($fid);
        $url = $image_file->createFileUrl();

        //Fixed or paralax image
        $field_image_scroll_ratio = $paragraph->field_image_scroll_ratio->value;
        if ($field_image_scroll_ratio != '0.0' ) {
          $scroll_ratio = 'background-attachment: fixed';
        } else {
          $scroll_ratio = '';
        }

        // Build attribute style
        $this->bgStyle = [
          // 'size' => 'background-size: 100%',
          // 'position' => 'background-position: 50% 50%',
          // 'min-height' => 'min-height: 300px',
          'parallax' => $scroll_ratio,
          'image' => 'background-image: url(' . $url . ')',
        ];

        //Set values for data attributes in Twig template.



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
          $sand_background_size = $field_background_size ? $field_background_size : '';
          $variables->set('sand_background_size', $sand_background_size);
        
        $variables->set('image_style', 'stellar-window');
      } else {
        //Use background_color
        if ($paragraph->field_bg_color){
          $this->bgStyle = [
            'bg-color' => 'background-color: #' . $paragraph->field_bg_color->value,
          ];
        } else {
          $this->bgStyle = [
            'bg-color' => 'background-color: #FFF',
          ];
        }
      };
      $variables->set('bg_style', implode(";", $this->bgStyle));

    // Hide on desktop or mobile
      if ($paragraph->field_hide_on_desktop->value) {
        $variables->set('hide_on_desktop', 'hide-on-desktop');
      } 

      if ($paragraph->field_hide_on_mobile->value) {
        $variables->set('hide_on_mobile', 'hide-on-mobile');
      } 

    // Set text styles (field_centered, field_no_drop_shadow, field_no_styling)
      if ($paragraph->field_centered->value) {
        $this->textStyle[] = 'text-center';
      } 
      if ($paragraph->field_no_drop_shadow->value) {
        $this->textStyle[] = 'no-shadow';
      }
      if ($paragraph->field_no_styling->value) {
        $this->textStyle[] = 'no-styling';
      }

      $variables->set('text_classes', implode(" ", $this->textStyle));

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

    //To-do: Apply this fields
    // - field_horizontal (When background cover stops working, this determines horizontal focal point (0 is left edge, 100 is right edge))
    // - field_mobile_size (sets background size of image in mobile view)
    // - field_vertical (When background cover stops working, this determines vertical focal point (0 is top edge, 100 is bottom edge))
  }
}