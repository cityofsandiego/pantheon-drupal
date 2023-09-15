<?php

namespace Drupal\if_components\EventSubscriber\Preprocess;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Menu\MenuActiveTrail;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\node\NodeInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\preprocess_event_dispatcher\Event\BlockPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Cache\CacheableMetadata;

/**
 * This gives an example of how to use the Preprocess
 *
 * __construct() and getSubscribedEvents() make the order of the preprocess events
 * passing data from the first event to the second event can be done with a cache
 * $cid is the cache id for the specific page, so it can be used to retrieve the page data for building blocks
 *
 * in this example. we have a preprocessPage that can set twig variables.
 * and we have preprocessBlock that can put inline javascript into the page.
 * passing the data from the preprocessPage event to the preprocessBlock event with cache id $cid
 */










/**
 * Class Department.
 *
 * Preprocess Department content type node.
 *
 * @package Drupal\if_components\EventSubscriber\Preprocess
 */
final class Node implements EventSubscriberInterface {

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * The menu active trail service.
   *
   * @var \Drupal\Core\Menu\MenuActiveTrail
   */
  protected $menuActiveTrail;

  /**
   * Entity type manager interface.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

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
   * Special top menu link data for Mayoral Artifacts.
   *
   * @var array
   */
  public array $maMenuLinkData = [];

  /**
   * Special top menu link data for Digital Archives Photos.
   *
   * @var array
   */
  public array $dapMenuLinkData = [];

  /**
   * Side menu id.
   *
   * @var string
   */
  public $side_menu_id = NULL;

  /**
   * Top menu id.
   *
   * @var string
   */
  public $top_menu_id = NULL;

  /**
   * Constructs a new Departments.
   *
   * @param \Drupal\Core\Routing\CurrentRouteMatch $current_route_match
   *   The route match.
   * @param \Drupal\Core\Menu\MenuActiveTrail $menu_active_trail
   *   Drupal menu active trail.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager service.
   */
  public function __construct(
    CurrentRouteMatch          $current_route_match,
    MenuActiveTrail            $menu_active_trail,
    EntityTypeManagerInterface $entity_type_manager
  ) {
    $this->currentRouteMatch = $current_route_match;
    $this->menuActiveTrail = $menu_active_trail;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      NodePreprocessEvent::name() => 'preprocessNode',
      BlockPreprocessEvent::name() => 'preprocessTitleBlock',
      PagePreprocessEvent::name() => 'preprocessPage',
      BlockPreprocessEvent::name() => 'preprocessHeroBlock',
    ];
  }

  /**
   * Preprocess node.
   *
   * @param \Drupal\node\NodeEvent $node_event
   *   The node event.
   */
  /**
   * Preprocess node.
   *
   * @param \Drupal\node\NodeEvent $node_event
   *   The node event.
   */
  public function preprocessPage(PagePreprocessEvent $event): void {
    $variables = $event->getVariables();
    $defaultBGImageURL = '/sites/default/files/downtown-skyline-.jpg'; // default background image
    $is_front = $variables->get('is_front') ?? \Drupal::service('path.matcher')->isFrontPage();
    $nids = [];

    if ($is_front) {
      $nids = $this->if_components_hero_query_hero_home_page();
    } elseif ($node = $variables->getNode()) {
      if ($node instanceof NodeInterface) {
        $department_terms = $node->get('field_department')->getValue();
        if (!empty($department_terms)) {
          $departments_on_node = array_column($department_terms, "target_id");
          $nids = $this->if_components_hero_query_hero_ids($departments_on_node);
        }
      }
    }

    $variables->set('hero_image', $defaultBGImageURL);
    if (!empty($nids)) {
      $hero_nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
      $hero_js_array = array_filter(array_map(function ($hero_node) {
        if ($hero_image = $hero_node->get('field_image')->entity) {
          $hero_image_file = $hero_image->getSource()
            ->getSourceFieldValue($hero_image);
          $file = File::load($hero_image_file);

          if ($file && ($file_url = $file->createFileUrl())) {
            return [
              $file_url,
              $hero_node->get('field_hero_image_by')->value,
              $hero_node->get('field_hero_prefix_image_by')->value,
            ];
          }
        }
        return null;
      }, $hero_nodes));

      if (!empty($hero_js_array)) {
        $unique_hero_js_array = array_map('unserialize', array_unique(array_map('serialize', $hero_js_array)));
        $hero_one_time = $unique_hero_js_array[array_rand($unique_hero_js_array)];
        $variables->set('hero_image', $hero_one_time[0]);
        $variables->set('hero_image_by', $hero_one_time[1] ?? null);
        $variables->set('hero_prefix_image_by', $hero_one_time[2] ?? null);

        if (count($unique_hero_js_array) >= 2) {
          // The $variables #attached is not used. It is only available at Document Ready. So no good for Inline JS.
          // I kept it here just in case we need it later by accessing drupalsettings['hero'].
          $attached = $variables->get('#attached');
          $attached['drupalSettings']['hero'] = $unique_hero_js_array;
          $variables->set('#attached', $attached);

          // generate cache key for this page based on URL
          $current_url = Url::fromRoute('<current>');
          $cid = 'if_components:unique_hero_js_array:' . $current_url->toString();
          // Create a cacheable data object.
          $cacheable_data = new CacheableMetadata();
          $cacheable_data->setCacheTags(['if_components:unique_hero_js_array']);
          $cacheable_data->setCacheContexts(['url']);

          // Set cache max age to 10 seconds.
          $cache_max_age = 10;
          $serialized_array = json_encode(array_values($unique_hero_js_array));
          // Save the data to cache.
          \Drupal::cache()
            ->set($cid, $serialized_array, time() + $cache_max_age, $cacheable_data->getCacheTags());
        }
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
  protected function if_components_hero_get_term_parents(int $tid): array {
    try {
      /** @var \Drupal\taxonomy\TermStorageInterface $term_storage */
      $term_storage = \Drupal::service('entity_type.manager')
        ->getStorage('taxonomy_term');
    } catch (InvalidPluginDefinitionException | PluginNotFoundException) {
      return [];
    }

    $parent_terms = $term_storage->loadAllParents($tid);
    $parent_term_labels = array_map(function (Term $term) {
      return $term->label();
    }, $parent_terms);

    return array_keys($parent_term_labels);
  }

  /**
   * @param string $timezone
   * @param float $latitude
   * @param float $longitude
   *
   * @return string[]
   * array(2) { [0]=> string(7) "all_day" [1]=> string(3) "day" }
   */
  protected function if_components_hero_timesofday(string $timezone = "America/Los_Angeles", float $latitude = 32.7157, float $longitude = -117.1611): array {
    $cache = \Drupal::cache()->get('if_components_hero_timesofday_cache');

    if ($cache) {
      return $cache->data;
    }

    date_default_timezone_set($timezone);
    $server_time = \Drupal::time()->getRequestTime();
    $sun_info = date_sun_info($server_time, $latitude, $longitude);

    $sunrise = $sun_info["sunrise"];
    $sunset = $sun_info["sunset"];
    $dawn = ['start' => $sunrise - 3600, 'end' => $sunrise + 3600];
    $dusk = ['start' => $sunset - 3600, 'end' => $sunset + 3600];

    $times_of_day = [
      'all_day',
      ($server_time > $dawn['start'] && $server_time < $dawn['end']) ? 'dawn' : null,
      ($server_time > $dusk['start'] && $server_time < $dusk['end']) ? 'dusk' : null,
      ($sunrise < $server_time && $server_time < $sunset) ? 'day' : 'night'
    ];

    // Remove null values
    $times_of_day = array_filter($times_of_day);

    // Set cache for 5 minutes (300 seconds)
    \Drupal::cache()->set('if_components_hero_timesofday_cache', $times_of_day, time() + 300);

    return $times_of_day;
  }

  /**
   * Implements hook_js_settings_build().
   */
  protected function if_components_hero_query_hero_home_page(): array {
    $times_of_day = $this->if_components_hero_timesofday();

    if (empty($times_of_day)) {
      return [];
    }

    $query = \Drupal::entityQuery('node')
      ->condition('type', 'hero')
      ->condition('status', NodeInterface::PUBLISHED)
      ->condition('field_hero_frontpage', TRUE)
      ->condition('field_hero_time_of_day', $times_of_day, 'IN');

    $entity_ids = $query->execute();

    return array_map('intval', array_values($entity_ids));
  }

  /**
   * Implements hook_js_settings_build().
   */
  protected function if_components_hero_query_hero_ids(array $departments): array {
    if (empty($departments)) {
      return [];
    }

    $departments = array_map('intval', $departments);
    $times_of_day = $this->if_components_hero_timesofday();
    if (empty($times_of_day)) {
      return [];
    }

    $term_storage = [];
    foreach ($departments as $department) {
      $term_storage[] = array_values($this->if_components_hero_get_term_parents($department));
    }

    $departmentParents = array_unique(array_merge(...$term_storage));
    $departmentParents = array_diff($departmentParents, $departments);

    $entity_ids = [];
    if (!empty($departments)) {
      $query = \Drupal::entityQuery('node')
        ->condition('type', 'hero')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('field_hero_time_of_day', $times_of_day, 'IN')
        ->condition('field_department', $departments, 'IN');
      $entity_ids = $query->execute();
    }

    if (empty($entity_ids) && !empty($departmentParents)) {
      $query = \Drupal::entityQuery('node')
        ->condition('type', 'hero')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('field_hero_time_of_day', $times_of_day, 'IN')
        ->condition('field_department', $departmentParents, 'IN');
      $entity_ids = $query->execute();
    }

    if (empty($entity_ids)) {
      $query = \Drupal::entityQuery('node')
        ->condition('type', 'hero')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('field_hero_time_of_day', $times_of_day, 'IN')
        ->condition('field_hero_sitewide', TRUE);
      $entity_ids = $query->execute();
    }

    return array_map('intval', array_values($entity_ids));
  }

  public function preprocessTitleBlock(BlockPreprocessEvent $event): void {
    $variables = $event->getVariables();
    $content_types = ['department', 'location', 'department_document', 'article', 'blog', 'department_parent', 'event', 'mayoral_artifacts', 'digital_archives_photos', 'sand_gallery', 'webform'];

    if ($variables->get('base_plugin_id') == 'page_title_block') {
      $node = \Drupal::routeMatch()->getParameter('node');
      if (isset($node) && $node instanceof NodeInterface && in_array($node->getType(), $content_types)) {

        // Get current departments.
        $field_department = $node->field_department->getValue();
        foreach ($field_department as $department) {
          $this->departments[] = $department['target_id'];
        }

        // Top menu.
        $this->getSidebarContexts('field_department', $this->departments);
        foreach ($this->context_ids as $nid) {
          $context_node = $this->entityTypeManager->getStorage('node')->load($nid);
          if (count($context_node->field_top_menu_id->getValue()) > 0) {
            $this->top_menu_id = $context_node->field_top_menu_id->getValue()[0]['value'];
          }
        }
        $this->buildMenuLinks('topmenu');
        array_multisort(array_column($this->topMenuLinkData, 'weight'), SORT_ASC, $this->topMenuLinkData);
        $variables->set('topmenu', [
          'items' => $this->topMenuLinkData,
        ]);
        if ($node->getType() == 'mayoral_artifacts') {
          $this->buildMenuLinks('mayoral_artifacts');
          array_multisort(array_column($this->maMenuLinkData, 'weight'), SORT_ASC, $this->maMenuLinkData);
          $variables->set('topmenu', ['items' => $this->maMenuLinkData]);
        }
        if ($node->getType() == 'digital_archives_photos') {
          $this->buildMenuLinks('digital_archives_photos');
          array_multisort(array_column($this->dapMenuLinkData, 'weight'), SORT_ASC, $this->dapMenuLinkData);
          $variables->set('topmenu', ['items' => $this->dapMenuLinkData]);
        }

        // Department title.
        $department_title = NULL;
        foreach ($node->field_department->getValue() as $department) {
          $term = Term::load($department['target_id']);
          $parent_id = $term->get('parent')->getValue()[0]['target_id'];
          if ($parent_id == 0) {
            $department_title = $term->getName();
          }
        }
        $variables->set('department_title', $department_title);
        if ($node->getType() == 'mayoral_artifacts') {
          $variables->set('department_title', 'Office of the City Clerk');
        }
        if ($node->getType() == 'digital_archives_photos') {
          $variables->set('department_title', 'Digital Archives');
        }
      }
    }
  }

  public function preprocessHeroBlock(BlockPreprocessEvent $event): void {
    $variables = $event->getVariables();
    $is_front = $variables->get('is_front') ?? \Drupal::service('path.matcher')->isFrontPage();


    if ($variables->get('base_plugin_id') == 'hero_block') {
      $current_url = Url::fromRoute('<current>');
      $cid = 'if_components:unique_hero_js_array:' . $current_url->toString();

      // Retrieve the cached data.
      $cache = \Drupal::cache()->get($cid);
      if ($cache) {
        $unique_hero_js_array = $cache->data;

        $content = $variables->get('content');

        if ($is_front) {
          $myMarkup = "<script>const arr=" . $unique_hero_js_array . ";const randomIndex=Math.floor(Math.random()*arr.length);const selectedArray=arr[randomIndex];const heroBgImage=document.getElementById('hero-bg-image');heroBgImage.style.backgroundImage=heroBgImage.style.backgroundImage.replace(/url\(.*?\)/i,'url('+selectedArray[0]+')');const bg_credit=document.getElementById('hero-bg-credit');if(bg_credit){bg_credit.textContent=selectedArray[2]+' '+selectedArray[1];};if(bg_credit.textContent.includes('null')){bg_credit.remove();};console.log(arr);console.log(selectedArray);</script>";
        } else {
          $myMarkup = "<script>const arr=" . $unique_hero_js_array . ";const randomIndex=Math.floor(Math.random()*arr.length);const selectedArray=arr[randomIndex];const heroBgImage=document.getElementById('hero-bg-image');heroBgImage.style.backgroundImage=heroBgImage.style.backgroundImage.replace(/url\(.*?\)/i,'url('+selectedArray[0]+')');console.log(arr);console.log(selectedArray);</script>";
        }

        if (isset($content['#markup'])) {
          $content['#markup'] .= $myMarkup;
        } else {
          $content['#markup'] = $myMarkup;
        }

        $variables->set('content', $content);
      }
    }
  }

  /**
   * Preprocess a node with bundle type department in view mode full.
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent $event
   *   Event.
   */
  public function preprocessNode(NodePreprocessEvent $event): void {
    $variables = $event->getVariables();
    $node = $variables->getEntity();

    if ($node->hasField('field_department')) {

      $sidebar = [];
      $sidebar_bottom = [];

      $field_department = $node->field_department->getValue();

      if (!empty($field_department)) {
        foreach ($field_department as $department) {
          $this->departments[] = $department['target_id'];
        }
        $this->getSidebarContexts('field_department', $this->departments);
        $this->addTermDescendents($this->departments);
        $this->getSidebarContexts('field_department_subs', $this->departments);

        // Load sidebar context nodes, load block content, get menu ids.
        foreach ($this->context_ids as $nid) {
          $context_node = $this->entityTypeManager->getStorage('node')
            ->load($nid);
          if (count($context_node->field_sidebar_menu_id->getValue()) > 0) {
            $this->side_menu_id = $context_node->field_sidebar_menu_id->getValue()[0]['value'];
          }
          foreach ($context_node->field_block->getValue() as $paragraph_id) {
            $paragraph = Paragraph::load($paragraph_id['target_id']);
            switch ($paragraph->field_region->getValue()[0]['value']) {
              case 'sidebar':
                $sidebar[] = [
                  'weight' => $paragraph->field_weight->getValue()[0]['value'],
                  'value' => $this->entityTypeManager->getViewBuilder('paragraph')
                    ->view($paragraph, 'full'),
                ];
                break;
              case 'sidebar_bottom':
                $sidebar_bottom[] = [
                  'weight' => $paragraph->field_weight->getValue()[0]['value'],
                  'value' => $this->entityTypeManager->getViewBuilder('paragraph')
                    ->view($paragraph, 'full'),
                ];
                break;
            }
          }
        }

        $side_title = NULL;
        foreach (array_unique($this->departments) as $department) {
          $term = Term::load($department);
          $parent_id = $term->get('parent')->getValue()[0]['target_id'];
          if ($parent_id != 0) {
            $side_title = $term->getName();
          }
        }

        // Get side menu links.
        $this->buildMenuLinks('sidemenu');

        array_multisort(array_column($sidebar, 'weight'), SORT_ASC, $sidebar);
        array_multisort(array_column($sidebar_bottom, 'weight'), SORT_ASC, $sidebar_bottom);
        array_multisort(array_column($this->sideMenuLinkData, 'weight'), SORT_ASC, $this->sideMenuLinkData);
        array_multisort(array_column($this->topMenuLinkData, 'weight'), SORT_ASC, $this->topMenuLinkData);

        $variables->set('sidebar', $sidebar);
        $variables->set('sidebar_bottom', $sidebar_bottom);
        $variables->set('sidemenu', [
          'title' => $side_title,
          'items' => $this->sideMenuLinkData,
        ]);

      }
    }

    // //Preprocess Department document file to get URL
    if ($node->hasField('field_attachment')) {
      $field_attachment = $node->field_attachment->getValue();

      if (!empty($field_attachment)) {
        $attachment = $this->entityTypeManager->getStorage('media')
          ->load( $node->get('field_attachment')->getValue()[0]['target_id']);
        $field_id = $attachment->getSource()->getSourceFieldValue( $attachment);
        $file_url = File::load($field_id);
        $variables->set('attachment_url', $file_url->createFileUrl());
      }
    }

    //Preprocess Image on Article Outreach2
    if ($node->getType() == 'outreach_article2') {
      $field_image = $node->field_image->getValue();
      $bgStyle = [];
      
      if (!empty($field_image)) {
        $image = $this->entityTypeManager->getStorage('media')
          ->load( $node->get('field_image')->getValue()[0]['target_id']);
        $fid = $image->getSource()->getSourceFieldValue($image);
        $image_file = File::load($fid);
        $url = $image_file->createFileUrl();
        
        $field_minimum_height = $node->field_outreach_minimum_height->value;
        $min_height  = $field_minimum_height ? $field_minimum_height . 'px' : '300px';

        // Build attribute style
        $this->$bgStyle = [
          'size' => 'background-size: cover',
          'position' => 'background-position: center center',
          'repeat' => 'background-repeat: no-repeat',
          'min-height' => 'min-height:' . $min_height,
          'image' => 'background-image: url(' . $url . ')',
        ];

        $variables->set('bg_style', implode(";", $this->$bgStyle));
      } else {
        $variables->set('bg_style', '');
      }

      foreach ($node->field_department->getValue() as $department) {
        $term = Term::load($department['target_id']);
        $department_name = preg_replace('/[\- ]/', '_', $term->getName());
        $variables->set(strtolower($department_name), $term->getName());
      }
    }
  }

  /*
   * Helper function to add context node ids based on term.
   */
  public function getSidebarContexts($field, $terms): void {
    foreach ($terms as $term) {
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'sidebar_block_context')
        ->condition($field, [$term], 'IN');
      $nids = $query->execute();
      foreach ($nids as $nid) {
        if (!in_array($nid, $this->context_ids)) {
          $this->context_ids[] = $nid;
        }
      }
    }
  }

  /**
   * Helper function to add child department taxonomy term ids.
   */
  public function addTermDescendents($terms) {
    foreach ($terms as $term) {
      $parent = $this->entityTypeManager
        ->getStorage('taxonomy_term')
        ->loadParents($term);
      $parent = reset($parent);
      if (is_object($parent)) {
        if (!in_array($parent, $this->departments)) {
          $this->departments[] = $parent->id();
        }
      }
    }
  }

  /**
   * Builds the menu links for this Department.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  private function buildMenuLinks($menu) {
    if ($menu == 'topmenu') {
      $menu_id = $this->top_menu_id;
    }
    elseif ($menu == 'sidemenu') {
      $menu_id = $this->side_menu_id;
    }
    elseif ($menu == 'mayoral_artifacts') {
      $menu_id = 'city-clerk';
    }
    elseif ($menu == 'digital_archives_photos') {
      $menu_id = 'digital-archives';
    }

    $parameters = new MenuTreeParameters();
    $parameters->onlyEnabledLinks();
    $menu_active_trail = $this->menuActiveTrail->getActiveTrailIds($menu_id);
    $parameters->setActiveTrail($menu_active_trail);

    $menu_tree = \Drupal::menuTree()->load($menu_id, $parameters);
    foreach ($menu_tree as $delta => $menu_item) {
      $classes = [];
      if (in_array($delta, $menu_active_trail)) {
        $classes[] = 'is_active';
      }

      $menu_content_storage = $this->entityTypeManager->getStorage('menu_link_content');
      $child_items = $menu_content_storage->loadByProperties(['parent' => $menu_item->link->getPluginId()]);
      $children = [];

      if (count($child_items) > 0) {
        $classes[] = 'expanded';
        // @todo may need to refactor if more than one level of children needed.
        foreach($child_items as $child_item) {
          $children[] = [
            'title' => $child_item->getTitle(),
            'url' => $child_item->getUrlObject()->toString(),
            'weight' => $child_item->getWeight(),
          ];
        }
        array_multisort(array_column($children, 'weight'), SORT_ASC, $children);
      }

      $item = [
        'title' => $menu_item->link->getTitle(),
        'url' => $menu_item->link->getUrlObject()->toString(),
        'weight' => $menu_item->link->getWeight(),
        'children' => $children,
        'classes' => $classes,
      ];

      if ($menu == 'sidemenu') {
        $this->sideMenuLinkData[] = $item;
      }
      elseif ($menu == 'topmenu') {
        $this->topMenuLinkData[] = $item;
      }
      elseif ($menu == 'mayoral_artifacts') {
        $this->maMenuLinkData[] = $item;
      }
      elseif ($menu == 'digital_archives_photos') {
        $this->dapMenuLinkData[] = $item;
      }

    }

  }

}
