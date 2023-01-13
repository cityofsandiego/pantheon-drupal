<?php

namespace Drupal\if_components\EventSubscriber\Preprocess\Paragraph;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\file\Entity\File;
use Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Preprocess paragraph: Sections
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
      ParagraphPreprocessEvent::name('sections') => 'preprocessSections',
    ];
  }

  /**
   * Implements hook_preprocess_paragraph() for the section outreach 2.
   *
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\ParagraphPreprocessEvent $event
   *   Paragraph event.
   */
  public function preprocessSections(ParagraphPreprocessEvent $event): void {
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
        
        // Build attribute style
        $this->bgStyle = [
          // 'size' => 'background-size: 100%',
          // 'position' => 'background-position: 50% 50%',
          // 'min-height' => 'min-height: 300px',
          'image' => 'background-image: url(' . $url . ')',
        ];

        //Set values for data attributes in Twig template.
          $field_image_scroll_ratio = $paragraph->field_image_scroll_ratio->value;
          $scroll_ratio = $field_image_scroll_ratio ? $field_image_scroll_ratio : '';
          $variables->set('scroll_ratio', $scroll_ratio);

          $field_minimum_height = $paragraph->field_minimum_height->value;
          $min_height  = $field_minimum_height ? $field_minimum_height . 'px' : '300px';
          $variables->set('min_height', $min_height);
        
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

    // Set text styles (field_centered)
      if ($paragraph->field_centered->value) {
        $this->textStyle[] = 'text-center';
      } 

      $variables->set('text_classes', implode(" ", $this->textStyle));

    //To-do: Ask SAND team about the use of
    // - field_full_width_mobile
    // - field_minimum_height
  }
}