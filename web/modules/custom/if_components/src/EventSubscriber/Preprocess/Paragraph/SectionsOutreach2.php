<?php

namespace Drupal\if_components\EventSubscriber\Preprocess\Paragraph;

use Drupal\Core\Entity\EntityTypeManagerInterface;
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
   * Background attributes.
   *
   * @var array
   */
  protected $bgAttributes = [];

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


    // Set background image or background color
      if (!$paragraph->field_image->isEmpty()) {
        // Preprocess image to get URL
        $field_image = $paragraph->field_image->getValue();

        // $image = $this->entityTypeManager->getStorage('media')
        // ->load( $paragraph->get('field_image')->getValue()[0]['target_id']);
        $url = 'http://san-diego-custom-code.lndo.site/sites/default/files/styles/large/public/downtown-skyline-.jpg?itok=QqEnXL6h';
        // Use background_image
        $this->bgStyle = [
          'size' => 'background-size: 100%',
          'position' => 'background-position: 50% 50%',
          'min-height' => 'min-height: 300px',
          'image' => 'background-image: url(' . $url . ')',
        ];
      } else {
        //Use background_color
        if ($paragraph->field_bg_color){
          $this->bgStyle = [
            'bg-color' => 'background-color:' . $paragraph->field_bg_color->value,
          ];
        } else {
          $this->bgStyle = [
            'bg-color' => 'background-color: #FFF',
          ];
        }
      };


    // Hide on desktop or mobile fields
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

    // Set border bottom (field_bottom_border)
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

    // Send array of style variables to the paragraph display.
    $variables->set('bg_style', implode(";", $this->bgStyle));
    $variables->set('bg_attributes', $this->bgAttributes);
    $variables->set('text_classes', implode(" ", $this->textStyle));
  }
}