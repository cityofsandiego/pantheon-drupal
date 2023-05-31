<?php

namespace Drupal\sand_hours\Plugin\Field\FieldFormatter;

use DateTime;
use DateTimeZone;
use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;

use Drupal\node\Entity\Node;
use Drupal\office_hours\OfficeHoursDateHelper;
use Drupal\office_hours\Plugin\Field\FieldFormatter\OfficeHoursFormatterBase;


/**
 * Plugin implementation of the 'Sand Hours' formatter.
 *
 * @FieldFormatter(
 *   id = "sand_hours",
 *   label = @Translation("Sand Hours"),
 *   field_types = {
 *     "office_hours"
 *   }
 * )
 */
class SandHoursFormatter extends OfficeHoursFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
      $summary = parent::settingsSummary();
      $summary[] = '(When using multiple slots per day, better use the table formatter.)';
      return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
      /** @var \Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemList $items */
      $elements = [];

      // If no data is filled for this entity, do not show the formatter.
      if ($items->isEmpty()) {
          return $elements;
      }

      $settings = $this->getSettings();
      $third_party_settings = $this->getThirdPartySettings();
      $field_definition = $items->getFieldDefinition();
      // N.B. 'Show current day' may return nothing in getRows(),
      // while other days are filled.
      /** @var \Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemListInterface $items */
      $office_hours = $items->getRows($settings, $this->getFieldSettings(), $third_party_settings);

      // If no data is filled for this entity, do not show the formatter.
      if ($items->isEmpty()) {
          return $elements;
      }
      
      // Reset Start of the week to today.
      $today = (int)date('w');
      $office_hours = OfficeHoursDateHelper::weekDaysOrdered($office_hours, $today); 

      $start_of_today = new DateTime('midnight', new DateTimeZone('America/Los_Angeles'));
      $u_start_of_today = $start_of_today->format('U');

      // The office hours of array always starts on sunday with the key of zero.
      $days_of_this_week = [];
      foreach ($office_hours as $key => $office_hour) {
          if ($key > 6) {
              continue;
          }
          $days_from_today = $key < $today ? $key -$today + 7 : $key - $today;
          $office_hours[$key]['days_from_today'] = $days_from_today;
          $date = date('U', strtotime('+'.($days_from_today).' days', $u_start_of_today));
          $office_hours[$key]['date'] = $date;
          $days_of_this_week[] = $date;
      }

//      $date_query = \Drupal::service('sand_type.date_query');
//      $nids = $date_query->getIds();

      $database = \Drupal::database();
      $result = $database->select('node__field_date_date', 'd')
          ->fields('d')
          ->condition('d.field_date_date_value', $days_of_this_week, 'IN')
          ->execute();
      
      foreach ($result as $row) {
         $field_date_date_value = $row->field_date_date_value;
         foreach ($office_hours as $key => $office_hour) {
             if ($key > 6) {
                 continue;
             }
             if ($office_hour['date'] == $field_date_date_value) {
                $office_hours[$key]['formatted_slots'] = $office_hour['closed'];
                $node = Node::load($row->entity_id);
                if (!empty($node->get('field_date_type')->value)) {
                    $comment = $node->get('field_date_type')->view(['label' => 'hidden'])[0]['#markup']; 
                } else {
                    $comment = t('City Closed'); 
                }
                $office_hours[$key]['comments'] = '(' . $comment . ')';
             }
         }
      }

      $elements[] = [
          '#theme' => 'office_hours',
          '#parent' => $field_definition,
          // Pass filtered office_hours structures to twig theming.
          '#office_hours' => $office_hours,
          // Pass (unfiltered) office_hours items to twig theming.
          '#office_hours_field' => $items,
          '#item_separator' => $settings['separator']['days'],
          '#slot_separator' => $settings['separator']['more_hours'],
          '#attributes' => [
              'class' => ['office-hours'],
          ],
          // '#empty' => $this->t('This location has no opening hours.'),
          '#attached' => [
              'library' => [
                  'office_hours/office_hours_formatter',
              ],
          ],
      ];

      $elements = $this->addSchemaFormatter($items, $langcode, $elements);
      $elements = $this->addStatusFormatter($items, $langcode, $elements);

      // Add a ['#cache']['max-age'] attribute to $elements.
      // Note: This invalidates a previous Cache in Status Formatter.
      $this->addCacheMaxAge($items, $elements);

      return $elements;

  }

}
