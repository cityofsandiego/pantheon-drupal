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
   * Text classes to display.
   *
   * @var array
   */
  protected $textClasses = [];

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

    // Reset background Style since they seem to stick when there are multiple
    // sections paragraphs on the page.
    $this->bgStyle = [];
    //dump($paragraph);

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

    if ($paragraph->field_centered){ 
      $this->textClasses[] = ['text-center'];
    }

    // $bgStyleString = implode(";", $this->bgStyle);
    // dump($string);

    // Send array of contact info to the paragraph display.
    $variables->set('bg_style', implode(";", $this->bgStyle));
    $variables->set('bg_attributes', $this->bgAttributes);
    $variables->set('text_classes', $this->textClasses);
  }
}