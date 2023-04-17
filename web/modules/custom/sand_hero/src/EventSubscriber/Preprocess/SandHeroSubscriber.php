<?php

namespace Drupal\sand_hero\EventSubscriber\Preprocess;

use Drupal;
use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Menu\MenuActiveTrail;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\file\Entity\File;
use Drupal\node\NodeInterface;
use Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\TempStore\PrivateTempStoreFactory;

/**
 * Class Department.
 *
 * Preprocess Department content type node.
 *
 * @package Drupal\if_components\EventSubscriber\Preprocess
 */
class SandHeroSubscriber implements EventSubscriberInterface {

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected CurrentRouteMatch $currentRouteMatch;

  /**
   * The menu active trail service.
   *
   * @var \Drupal\Core\Menu\MenuActiveTrail
   */
  protected MenuActiveTrail $menuActiveTrail;

  /**
   * Entity type manager interface.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * Sidebar context node IDs.
   *
   * @var array
   */
  public array $context_ids = [];

  /**
   * Departments to traverse through for sidebar contexts.
   *
   * @var array
   */
  public array $departments = [];

  /**
   * Side menu link data to be sent to the template.
   *
   * @var array
   */
  public array $sideMenuLinkData = [];

  /**
   * Top menu link data to be sent to the template.
   *
   * @var array
   */
  public array $topMenuLinkData = [];

  /**
   * Side menu id.
   *
   * @var string
   */
  public ?string $side_menu_id = NULL;

  /**
   * Top menu id.
   *
   * @var string
   */
  public ?string $top_menu_id = NULL;

  /**
   * Constructs a new Departments.
   *
   * @param \Drupal\Core\Routing\CurrentRouteMatch $current_route_match
   *   The route match.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager service.
   */
  public function __construct(
    CurrentRouteMatch          $current_route_match,
    EntityTypeManagerInterface $entity_type_manager
  ) {
    $this->currentRouteMatch = $current_route_match;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      PagePreprocessEvent::name() => 'preprocessPage',
    ];
  }

  public function preprocessPage(PagePreprocessEvent $event): void {
    $variables = $event->getVariables();
    $departments_on_node = [];
    $nids = [];
    $fileUrls = [];

    if ($variables->getNode() !== NULL) {
      $node = Drupal::routeMatch()->getParameter('node');
      if ($node instanceof NodeInterface) {
        $department_terms = $node->get('field_department')->getValue();
        if (!empty($department_terms)) {
          foreach ($department_terms as $department_term) {
            $departments_on_node[] = $department_term["target_id"];
          }
        }
      }

      if (!empty($departments_on_node)) {
        $nids = $this->sand_hero_query_hero_ids($departments_on_node);
      }

      if (!empty($nids)) {
        foreach ($nids as $nid) {
          $hero_node = $this->entityTypeManager->getStorage('node')
            ->load($nid);
          if ($hero_node !== NULL && $hero_node->get('field_image')
              ->getValue() !== NULL) {
            $hero_image = $this->entityTypeManager->getStorage('media')
              ->load($hero_node->get('field_image')
                ->getValue()[0]['target_id']);
            if ($hero_image !== NULL) {
              $fid = $hero_image->getSource()->getSourceFieldValue($hero_image);
              $hero_image_file = File::load($fid);
              $fileUrls[] = $hero_image_file->createFileUrl();
              $x = 0;
            }
          }
        }
      }
      if(empty($fileUrls)) {
        // default image if no image is found
        $fileUrls = ["/sites/default/files/downtown-skyline-.jpg"];
      }
      if(!empty($fileUrls)){
        $variables->set('hero_image', $fileUrls[array_rand($fileUrls)]);
        $tempstore = \Drupal::service('tempstore.private')->get('sand_hero');
        $tempstore->set('hero_image_js', $fileUrls);
      }
    }
  }

  /**
   * Retrieves the parent terms for a given term.
   *
   * @param int $tid
   *   The term ID for which to retrieve the parent terms.
   *
   * @return array
   *   An array of parent term objects.
   */
  protected function sand_hero_get_term_parents(int $tid): array {
    /** @var \Drupal\taxonomy\TermStorageInterface $term_storage */
    try {
      $term_storage = Drupal::service('entity_type.manager')
        ->getStorage('taxonomy_term');
    } catch (InvalidPluginDefinitionException|PluginNotFoundException) {
    }
    $field = $term_storage->loadAllParents($tid);
    $new_terms = array_map(function (Term $term) {
      return $term->label();
    }, $field);
    return array_keys($new_terms);
  }

  /**
   * @param string $timezone
   * @param float $latitude
   * @param float $longitude
   *
   * @return string[]
   * array(2) { [0]=> string(7) "all_day" [1]=> string(3) "day" }
   */
  protected function sand_hero_timesofday(string $timezone = "America/Los_Angeles", float $latitude = 32.7157, float $longitude = -117.1611): array {
    date_default_timezone_set($timezone);
    $server_time = Drupal::time()->getRequestTime();
    $sun_info = date_sun_info($server_time, $latitude, $longitude);

    // If we have expire enabled then we are probably using cloudflare so average
    // out the actual time with when the page was cached with cloudflare.
    if (function_exists('expire_menu')) {
      $server_time -= 1200;
    }
    $times_of_day = ['all_day'];

    $sunrise = $sun_info["sunrise"];
    $sunset = $sun_info["sunset"];
    $dawn = ['start' => $sunrise - 3600, 'end' => $sunrise + 3600];
    $dusk = ['start' => $sunset - 3600, 'end' => $sunset + 3600];

    if ($server_time > $dawn['start'] && $server_time < $dawn['end']) {
      $times_of_day[] = 'dawn';
    }

    if ($server_time > $dusk['start'] && $server_time < $dusk['end']) {
      $times_of_day[] = 'dusk';
    }

    if ($sunrise < $server_time && $server_time < $sunset) {
      $times_of_day[] = 'day';
    }
    else {
      $times_of_day[] = 'night';
    }

    return $times_of_day;
  }

  /**
   * Implements hook_js_settings_build().
   */
  protected function sand_hero_query_hero_ids(array $departments): int|array {
    /** @var \Drupal\taxonomy\TermStorageInterface $term_storage */
    if (empty($departments)) {
      return [];
    }
    $tmp = [];
    foreach ($departments as $department) {
      $tmp[] = (int) $department;
    }
    $departments = $tmp;
    $times_of_day = $this->sand_hero_timesofday();

    $term_storage = [];
    foreach ($departments as $department) {
      $term_storage[] = array_values($this->sand_hero_get_term_parents($department));
    }
    //  $term_storage = array_unique($term_storage);
    $departmentParents = [];
    foreach ($term_storage as $r) {
      foreach ($r as $k) {
        $departmentParents[] = $k;
      }
    }
    $departmentParents = array_unique($departmentParents);
    $departmentParents = array_diff($departmentParents, $departments);
    if (empty($departmentParents)) {
      $departmentParents[] = 0;
    }

    if (!empty($times_of_day)) {
      $query = Drupal::entityQuery('node');

      $orTimes = $query->orConditionGroup();
      foreach ($times_of_day as $time) {
        $orTimes->condition('field_hero_time_of_day', $time, '=');
      }

      $orDepartments = $query->orConditionGroup();
      foreach ($departments as $department) {
        $orDepartments->condition('field_department', $department, '=');
      }

      $orDepartmentParents = $query->orConditionGroup();
      foreach ($departmentParents as $departmentParent) {
        $orDepartmentParents->condition('field_department', $departmentParent, '='); //todo: think there is something wrong with this?
      }

      $sharedConditions = $query->andConditionGroup();
      $sharedConditions->condition('type', 'hero');
      $sharedConditions->condition('status', NodeInterface::PUBLISHED);
      $sharedConditions->condition($orTimes);

      $query->condition($sharedConditions);
      $query->condition($orDepartments);
      $entity_ids = $query->execute();

      if (empty($entity_ids)) {
        $query = Drupal::entityQuery('node');
        $query->condition($sharedConditions);
        $query->condition($orDepartmentParents);
        $entity_ids = $query->execute();
      }

      if (empty($entity_ids)) {
        $query = Drupal::entityQuery('node');
        $query->condition($sharedConditions);
        $query->condition('field_hero_sitewide', TRUE);
        $entity_ids = $query->execute();
      }

      return array_map('intval', array_values($entity_ids));
    }
    return [];
  }
}

