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

    public function prepareView(array $entities_items) {
        // Collect entity IDs to load. For performance, we want to use a single
        // "multiple entity load" to load all the entities for the multiple
        // "entity reference item lists" being displayed. We thus cannot use
        // \Drupal\Core\Field\EntityReferenceFieldItemList::referencedEntities().
        $ids = [];
        foreach ($entities_items as $items) {
            foreach ($items as $item) {
                $x = 1;
            }
        }
        if ($ids) {
            $target_type = $this->getFieldSetting('target_type');
            $target_entities = \Drupal::entityTypeManager()->getStorage($target_type)->loadMultiple($ids);
        }
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

      // Now get all the department TIDs and parents of the location node we are on.
      $location_node = $items->getParent()->getEntity();
      $location_node_tids = $location_node->getDepartmentsTID(TRUE);

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
      $query = $database->select('node__field_date_date', 'd')
          ->leftJoin('node__field_department', 'nfd', 'd.entity_id = nfd.entity_id AND nfd.bundle = :bundle', array(':bundle' => 'date'));
      // Add a condition for field_department
      $query->fields('d');
      $query->condition('d.field_date_date_value', $days_of_this_week, 'IN');
      $query->condition('d.bundle', 'date');
      $query->condition(
        $query->orConditionGroup()
          ->isNull('d.field_department')
          ->condition('d.field_department', $location_node_tids, 'IN')
      );
      $result = $query->execute();


//      $query = \Drupal::entityQuery('node');
//      $group = $query
//          ->orConditionGroup()
//          ->condition('field_department', 'IS NULL')
//          ->condition('field_department', $location_node_tids, 'IN');
//      $result = $query->condition($group)
//          ->condition('type', 'date')
//          ->condition('status', 1)
//          ->condition('field_date_date', $days_of_this_week, 'IN')
//          ->accessCheck(TRUE)
//          ->execute();
//      $date_nodes = \Drupal\node\Entity\Node::loadMultiple($result);
//      
      foreach ($result as $row) {
         $field_date_date_value = $date_node->field_date_date->getValue();
         foreach ($office_hours as $key => $office_hour) {
             if ($key > 6) {
                 continue;
             }
             if ($office_hour['date'] == $field_date_date_value[0]["value"]) {
                $office_hours[$key]['formatted_slots'] = t('Closed');
                if (!empty($date_node->get('field_date_type')->value)) {
                    $comment = $date_node->get('field_date_type')->view(['label' => 'hidden'])[0]['#markup']; 
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

      // Enable dynamic field update in office_hours_status_update.js.
      // Since Field cache does not work properly for Anonymous users.
      $elements = $this->attachStatusUpdateJS($items, $langcode, $elements);
      // Add a ['#cache']['max-age'] attribute to $elements.
      // Note: This invalidates a previous Cache in Status Formatter.
      $elements = $this->addCacheData($items, $elements);


      return $elements;

  }

}
