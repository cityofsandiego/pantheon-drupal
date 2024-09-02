<?php

/**
 * This is an example of a Bundle Class. 
 * For an explanation see 
 *   https://www.hashbangcode.com/article/drupal-9-entity-bundle-classes 
 * 
 * Basically we can put all the business logic associated with a content type
 * in one place and have it easily available elsewhere with little pain and 
 * without having to wrap the "Node" class in another class before we use it.
 */

namespace Drupal\sand_type\Entity\Bundle;

use Drupal\node\Entity\Node;
use Drupal\Core\Url;

use Drupal\sand_type\Entity\Bundle\Interface\DepartmentInterface;
use Drupal\sand_type\Entity\Bundle\Traits\DepartmentTraits;

class Location extends Node implements DepartmentInterface {

  use DepartmentTraits;

  /**
   * Used in a custom filter for the library branch pages to bring in and format
   * XML.
   *
   * The custom filters are not in features so the call to this function will
   * only
   * be in the database.
   *
   * @param string $url
   * @param int $max_events
   *
   * @return string
   */
  public static function formatLibraryXML(string $url, int $max_events = 5): string {

    // Get XML from url.
    $url = str_replace("&amp;", "&", $url);
    $xml_string = @file_get_contents($url);
    if (empty($xml_string)) {
      return '';
    }

    // Turn it into a SimpleXML object.
    $xml_object = simplexml_load_string($xml_string);

    // Loop through each event.
    $kount = 0;
    $rows = [];
    foreach ($xml_object->event as $event) {
      if (++$kount > $max_events) {
        break;
      }
      if (!empty($event->date)) {
        $rows[$kount]['date'] = Location::getDateText($event);
        // Add time but take off even hours (:00).
        if (!empty($event->time)) {
          $rows[$kount]['time'] = str_replace(':00', '', $event->time);
        }
      }

      // Now add Title and link to event if we have a link.
      $rows[$kount]['title'] = $event->eventTitle;
      if (!empty($event->eventLink)) {
        $rows[$kount]['link'] = Url::fromUri($event->eventLink);
      }

      // If closing event, say so.
      if ($event->eventType == 'Closing') {
        $rows[$kount]['closing'] = 'Closing';
      }

      // Add ageGroups info.
      if (isset($event->ageGroups->age)) {
        $age_groups = (array) $event->ageGroups->age;
        $rows[$kount]['age_groups'] = implode(', ', $age_groups);
      }
    }

    // Render the output using twig.
    $render_array = [
      '#theme' => 'sand_location_library_xml',
      '#rows' => $rows,
    ];
    return \Drupal::service('renderer')->renderPlain($render_array);
  }

  /**
   * Get the date from the library XML event and format it.
   * 
   * @param $event
   *
   * @return string|null
   */
  private static function getDateText($event): ?string {
    if (empty($event->date)) {
      return '';
    }

    // Reformat date, Strip off Day first comma separated value which is the day (i.e. Saturday).
    // Create Date object for easy formatting. Previously formatting with date of June 23, 2019, now 06/23/2019
    $date = preg_replace('/^.*?, /', '', $event->date);
    $date = \DateTime::createFromFormat('F jS, Y', $date);

    if (!$date) {
      $date = (string) $event->date;
      $date = \DateTime::createFromFormat('m/d/Y', $date);
    }

    if (empty($date)) {
      return '';
    }

    // Output just month abbreviation and the day of the month.
    $today = new \DateTime();
    if ($today->format('M j') == $date->format('M j')) {
      // If today, then say so.
      $date_text = 'Today';
    }
    else {
      $date_text = $date->format('M j');
    }
    return $date_text;
  }

  public static function formatInsideSDHomeXML(string $url, int $max_items = 1): string {

    // Get XML from url.
    $url = str_replace("&amp;", "&", $url);
    $xml_string = @file_get_contents($url);
    if (empty($xml_string)) {
      return '';
    }

    // Turn it into a SimpleXML object.
    $xml_object = simplexml_load_string($xml_string);

    // Loop through each event.
    $kount = 0;
    $rows = [];
    foreach ($xml_object->item as $item) {
      if (++$kount > $max_items) {
        break;
      }

      // Add Title and link to item.
      $rows[$kount]['title'] = $item->title;
      $rows[$kount]['link'] = Url::fromUri($item->view_node);
      $rows[$kount]['created'] = $item->created;
      $rows[$kount]['image_url'] = $item->field_media_image;
    }

    // Render the output using twig.
    $render_array = [
      '#theme' => 'sand_location_insidesd_home_xml',
      '#rows' => $rows,
    ];
    return \Drupal::service('renderer')->renderPlain($render_array);
  }

  public static function formatInsideSDArticlesXML(string $url, int $max_items = 3): string {

    // Get XML from url.
    $url = str_replace("&amp;", "&", $url);
    $xml_string = @file_get_contents($url);
    if (empty($xml_string)) {
      return '';
    }

    // Turn it into a SimpleXML object.
    $xml_object = simplexml_load_string($xml_string);

    // Loop through each event.
    $kount = 0;
    $rows = [];
    foreach ($xml_object->item as $item) {
      if (++$kount > $max_items) {
        break;
      }

      // Add Title and link to item.
      $rows[$kount]['title'] = $item->title;
      $rows[$kount]['link'] = Url::fromUri($item->view_node);
      $rows[$kount]['created'] = $item->created;
      $rows[$kount]['categories'] = $item->field_category;
      $rows[$kount]['row_count'] = $kount;
      $rows[$kount]['image_url'] = $item->field_media_image;
    }

    // Render the output using twig.
    $render_array = [
      '#theme' => 'sand_location_insidesd_articles_xml',
      '#rows' => $rows,
    ];
    return \Drupal::service('renderer')->renderPlain($render_array);
  }

}
