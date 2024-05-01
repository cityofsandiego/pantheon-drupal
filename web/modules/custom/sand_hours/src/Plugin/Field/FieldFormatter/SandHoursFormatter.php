<?php

namespace Drupal\sand_hours\Plugin\Field\FieldFormatter;

use DateTime;
use DateTimeZone;
use Drupal\Component\Utility\SortArray;
use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;

use Drupal\office_hours\OfficeHoursDateHelper;
use Drupal\office_hours\Plugin\Field\FieldFormatter\OfficeHoursFormatterBase;

use Drupal\sand_type\Entity\Bundle\Date;
use Drupal\sand_type\Query\Bundle\DateQuery;

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
    $today = (int) date('w');
    $office_hours = OfficeHoursDateHelper::weekDaysOrdered($office_hours, $today);

    $start_of_today = new DateTime('midnight', new DateTimeZone('America/Los_Angeles'));
    $u_start_of_today = $start_of_today->format('U');

    // The office hours of array always starts on sunday with the key of zero.
    $days_of_this_week = [];
    foreach ($office_hours as $key => $office_hour) {
      if ($key > 6) {
        continue;
      }
      $days_from_today = $key < $today ? $key - $today + 7 : $key - $today;
      $office_hours[$key]['days_from_today'] = $days_from_today;
      $date = date('U', strtotime('+' . ($days_from_today) . ' days', $u_start_of_today));
      $office_hours[$key]['date'] = $date;
      $days_of_this_week[] = $date;
    }

    $date_nids = DateQuery::getDates($days_of_this_week, $location_node_tids);
    $date_nodes = \Drupal\node\Entity\Node::loadMultiple($date_nids);

    // For each date node that appears in this coming week.

    /** @var Date $date_node */
    foreach ($date_nodes as $date_node) {
      $dates = $date_node->getStartDates();
      // For each office hour day see if it matches the date found in the node.
      foreach ($office_hours as $key => $office_hour) {
        // Only need 7 days
        if ($key > 6) {
          continue;
        }
        if (in_array($office_hour['date'], $dates)) {
          $office_hours[$key]['formatted_slots'] = t('Closed');
          $office_hours[$key]['comments'] = '(' . $date_node->getTitle() . ')';
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

    $elements = $this->attachSchemaFormatter($items, $langcode, $elements);
    $elements = $this->attachStatusFormatter($items, $langcode, $elements);
    // Sort elements, to have Statusformattor on correct position.
    usort($elements, [SortArray::class, 'sortByWeightProperty']);

    if ($this->attachCache) {
      // Since Field cache does not work properly for Anonymous users,
      // .. enable dynamic field update in office_hours_status_update.js.
      // .. add a ['#cache']['max-age'] attribute to $elements.
      $elements += $this->attachCacheData($items, $langcode);
    }

    return $elements;
  }

}
