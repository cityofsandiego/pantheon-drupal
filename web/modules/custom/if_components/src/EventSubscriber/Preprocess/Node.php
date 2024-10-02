<?php

namespace Drupal\if_components\EventSubscriber\Preprocess;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
//use Drupal\Core\Menu\MenuActiveTrail;
//use Drupal\Core\ProxyClass\Menu\MenuActiveTrail;
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

  public array $context_ids_for_path = [];

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
    $menu_active_trail,
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
      PagePreprocessEvent::name() => 'preprocessPage',
      BlockPreprocessEvent::name() => 'preprocessTitleBlock',
    ];
  }

  public function preprocessPage(PagePreprocessEvent $event): void {
    $variables = $event->getVariables();
    $defaultBGImageURL = '/themes/custom/sand/images/home-hero-1.jpg'; // default background image
    $is_front = $variables->get('is_front') ?? \Drupal::service('path.matcher')->isFrontPage();
    $nids = [];
    if ($is_front) {
      $nids = $this->if_components_hero_query_hero_home_page();
    } elseif ($node = $variables->getNode()) {
      if ($node instanceof NodeInterface) {
        if ($node->hasField('field_department')) {
          $department_terms = $node->get('field_department')->getValue();
        }
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

          $prefix = $hero_node->get('field_hero_prefix_image_by')->value;
          $imageBy = $hero_node->get('field_hero_image_by')->value;
          $caption = $hero_node->get('field_hero_caption')->value;
          if ($prefix !== null && $imageBy !== null) {
            $imageBy = $prefix . ' ' . $imageBy;
          } elseif ($prefix !== null) {
            $imageBy = $prefix;
          } elseif ($imageBy === null) {
            $imageBy = null;
          }

          if ($file && ($file_url = $file->createFileUrl())) {
            return [
              $file_url,
              $caption,
              $imageBy,
            ];
          }
        }
        return null;
      }, $hero_nodes));

      if (!empty($hero_js_array)) {
        $unique_hero_js_array = array_map('unserialize', array_unique(array_map('serialize', $hero_js_array)));
        $hero_one_time = $unique_hero_js_array[array_rand($unique_hero_js_array)];
        $variables->set('hero_image', $hero_one_time[0]);
        $variables->set('hero_caption', $hero_one_time[1] ?? null);
        $variables->set('hero_image_by', $hero_one_time[2] ?? null);

        if (count($unique_hero_js_array) >= 2) {
          $attached = $variables->get('#attached');
          $attached['drupalSettings']['hero'] = $unique_hero_js_array;
          $variables->set('#attached', $attached);
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
      ->accessCheck(FALSE)
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
        ->accessCheck(FALSE)
        ->condition('type', 'hero')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('field_hero_time_of_day', $times_of_day, 'IN')
        ->condition('field_department', $departments, 'IN');
      $entity_ids = $query->execute();
    }

    if (empty($entity_ids) && !empty($departmentParents)) {
      $query = \Drupal::entityQuery('node')
        ->accessCheck(FALSE)
        ->condition('type', 'hero')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('field_hero_time_of_day', $times_of_day, 'IN')
        ->condition('field_department', $departmentParents, 'IN');
      $entity_ids = $query->execute();
    }

    if (empty($entity_ids)) {
      $query = \Drupal::entityQuery('node')
        ->accessCheck(FALSE)
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
    $content_types = ['department', 'location', 'department_document', 'article', 'blog', 'department_parent', 'event', 'mayoral_artifacts', 'digital_archives_photos', 'sand_gallery', 'webform', 'search_page'];

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
        if ($node->getType() == 'sand_gallery') {
          $this->buildMenuLinks('digital_archives_photos');
          array_multisort(array_column($this->dapMenuLinkData, 'weight'), SORT_ASC, $this->dapMenuLinkData);
          $variables->set('topmenu', ['items' => $this->dapMenuLinkData]);
        }

        // Department title.
        $department_title = NULL;
        foreach ($node->field_department->getValue() as $department) {
          $term = Term::load($department['target_id']);
          // If no term then don't try and set department_title.
          if (empty($term)) {
            continue;
          }
          $parent_id = $term->get('parent')->getValue()[0]['target_id'];
          if ($parent_id == 0) {
            $department_title = $term->getName();
          }
          else {
            $term = Term::load($parent_id);
            $parent_id = $term->get('parent')->getValue()[0]['target_id'];
            if ($parent_id == 0) {
              $department_title = $term->getName();
            }
            else {
              $term = Term::load($parent_id);
              $parent_id = $term->get('parent')->getValue()[0]['target_id'];
              if ($parent_id == 0) {
                $department_title = $term->getName();
              }
              else {
                $term = Term::load($parent_id);
                $parent_id = $term->get('parent')->getValue()[0]['target_id'];
                if ($parent_id == 0) {
                  $department_title = $term->getName();
                }
              }
            }
          }
        }
        $variables->set('department_title', $department_title);
        if ($node->getType() == 'mayoral_artifacts') {
          $variables->set('department_title', 'Office of the City Clerk');
        }
        if ($node->getType() == 'digital_archives_photos' || $node->getType() == 'sand_gallery') {
          $variables->set('department_title', 'Digital Archives');
        }

        // Slide logic
        if ($node->getType() == 'department_parent' && $show_slider = $node->get('field_show_top_slider')->getValue()) {
          if ($show_slider[0]['value'] == 1) {
            $department_argument = $node->get('field_department')->getValue()[0]['target_id'];
            $variables->set('department_argument', $department_argument);
          }
          $variables->set('show_slider', $show_slider[0]['value']);

        }
      }
      else {
        // This is not a node page.
        $path = \Drupal::request()->getPathInfo();
        $this->getSidebarContextsByPath($path);
        if (!empty($this->context_ids_for_path)) {
          foreach ($this->context_ids_for_path as $nid) {
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
        }
      }
    }
    if ($variables->get('base_plugin_id') == 'hero_block') {
      $current_url = Url::fromRoute('<current>');
      $cid = 'if_components:unique_hero_js_array:' . $current_url->toString();

      // Retrieve the cached data.
      $cache = \Drupal::cache()->get($cid);
      if ($cache) {
        $unique_hero_js_array = $cache->data;
        $content = $variables->get('content');
        $myMarkup = "<script>const a=" . $unique_hero_js_array . ";const rIdx=Math.floor(Math.random()*a.length);const sA=a[rIdx];const hBg=document.getElementById('hero-bg-image');hBg.style.backgroundImage='url('+sA[0]+')';const bgC=document.getElementById('hero-bg-credit');const hC=document.getElementById('hero--credit');if(bgC){if(sA[1]!==null){bgC.textContent=sA[1];if(sA[2]!==null){const br=document.createElement('br');bgC.appendChild(br);bgC.appendChild(document.createTextNode(sA[2]));}}else if(sA[2]!==null){bgC.textContent=sA[2];}}if(!bgC.textContent||bgC.textContent.includes('null')){hC.style.display='none';}else{hC.style.display='block';}</script>";
        $content['#markup'] = $myMarkup;
        $variables->set('content', $content);
      }
    }
  }

  public function preprocessHeroBlock(BlockPreprocessEvent $event): void {
    $variables = $event->getVariables();

    if ($variables->get('base_plugin_id') == 'hero_block') {
      $current_url = Url::fromRoute('<current>');
      $cid = 'if_components:unique_hero_js_array:' . $current_url->toString();

      // Retrieve the cached data.
      $cache = \Drupal::cache()->get($cid);
      if ($cache) {
        $unique_hero_js_array = $cache->data;
        $content = $variables->get('content');
        $myMarkup = "<script>const a=" . $unique_hero_js_array . ";const rIdx=Math.floor(Math.random()*a.length);const sA=a[rIdx];const hBg=document.getElementById('hero-bg-image');hBg.style.backgroundImage='url('+sA[0]+')';const bgC=document.getElementById('hero-bg-credit');const hC=document.getElementById('hero--credit');if(bgC){if(sA[1]!==null){bgC.textContent=sA[1];if(sA[2]!==null){const br=document.createElement('br');bgC.appendChild(br);bgC.appendChild(document.createTextNode(sA[2]));}}else if(sA[2]!==null){bgC.textContent=sA[2];}}if(!bgC.textContent||bgC.textContent.includes('null')){hC.style.display='none';}else{hC.style.display='block';}</script>";
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
            if (!empty($paragraph->field_region->getValue()) && !empty($paragraph->field_region->getValue()[0]['value'])) {
              $weight_value = isset($paragraph->field_weight->getValue()[0]['value']) ? $paragraph->field_weight->getValue()[0]['value'] : 0;
              $region = $paragraph->field_region->getValue()[0]['value'];
              $item = [
                'weight' => $weight_value,
                'paragraph_id' => $paragraph->id(),
              ];
              if ($region === 'sidebar') {
                $sidebar[] = $item;
              } elseif ($region === 'sidebar_bottom') {
                $sidebar_bottom[] = $item;
              }
            }
          }
        }

        $side_title = NULL;
        foreach (array_unique($this->departments) as $department) {
          $term = Term::load($department);
          // If no term then don't try and set side_title.
          if (empty($term)) {
            continue;
          }
          $parent_id = $term->get('parent')->getValue()[0]['target_id'];
          if ($parent_id != 0) {
            $side_title = $term->getName();
          }
        }

        // Get side menu links.
        $this->buildMenuLinks('sidemenu');

        // Sort the arrays.
        array_multisort(array_column($sidebar, 'weight'), SORT_ASC, $sidebar);
        array_multisort(array_column($sidebar_bottom, 'weight'), SORT_ASC, $sidebar_bottom);
        array_multisort(array_column($this->sideMenuLinkData, 'weight'), SORT_ASC, $this->sideMenuLinkData);
        array_multisort(array_column($this->topMenuLinkData, 'weight'), SORT_ASC, $this->topMenuLinkData);

        // Render paragraphs after sorting.
        foreach ($sidebar as &$item) {
          $paragraph = Paragraph::load($item['paragraph_id']);
          $item['value'] = $this->entityTypeManager->getViewBuilder('paragraph')->view($paragraph, 'full');
        }
        unset($item);

        foreach ($sidebar_bottom as &$item) {
          $paragraph = Paragraph::load($item['paragraph_id']);
          $item['value'] = $this->entityTypeManager->getViewBuilder('paragraph')->view($paragraph, 'full');
        }
        unset($item);

        $variables->set('sidebar', $sidebar);
        $variables->set('sidebar_bottom', $sidebar_bottom);
        $variables->set('sidemenu', [
          'title' => $side_title,
          'items' => $this->sideMenuLinkData,
        ]);

      }
    }

    // Preprocess Department document file to get URL
    if ($node->hasField('field_attachment')) {
      $field_attachment = $node->field_attachment->getValue();

      if (!empty($field_attachment) && isset($field_attachment[0]['target_id'])) {
        $attachment = $this->entityTypeManager->getStorage('media')
          ->load($node->get('field_attachment')->getValue()[0]['target_id']);
        $field_id = $attachment->getSource()->getSourceFieldValue($attachment);
        $file_url = File::load($field_id);
        $variables->set('attachment_url', $file_url->createFileUrl());
      }
    }

    // Preprocess Image on Article Outreach2
    if ($node->getType() == 'outreach_article2') {
      $field_image = $node->field_image->getValue();
      $bgStyle = [];

      if (!empty($field_image)) {
        $image = $this->entityTypeManager->getStorage('media')
          ->load($node->get('field_image')->getValue()[0]['target_id']);
        $fid = $image->getSource()->getSourceFieldValue($image);
        $image_file = File::load($fid);
        $url = $image_file->createFileUrl();

        $field_minimum_height = $node->field_outreach_minimum_height->value;
        $min_height = $field_minimum_height ? $field_minimum_height . 'px' : '300px';

        // Build attribute style
        $bgStyle = [
          'size' => 'background-size: cover',
          'position' => 'background-position: center center',
          'repeat' => 'background-repeat: no-repeat',
          'min-height' => 'min-height:' . $min_height,
          'image' => 'background-image: url(' . $url . ')',
        ];

        $variables->set('bg_style', implode(";", $bgStyle));
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


  /*
   * Helper function to add context node ids based on path.
   */
  public function getSidebarContextsByPath(string $path): void {
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'sidebar_block_context')
        ->condition('field_path', $path . "%", 'LIKE');
      $query->accessCheck(FALSE);
      $nids = $query->execute();
      foreach ($nids as $nid) {
        if (!in_array($nid, $this->context_ids_for_path)) {
          $this->context_ids_for_path[] = $nid;
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
        $grandparent = $this->entityTypeManager
          ->getStorage('taxonomy_term')
          ->loadParents($parent->id());
        $grandparent = reset($grandparent);
        if (is_object($grandparent)) {
          if (!in_array($grandparent, $this->departments)) {
            $this->departments[] = $grandparent->id();
          }
          $greatgrandparent = $this->entityTypeManager
            ->getStorage('taxonomy_term')
            ->loadParents($grandparent->id());
          $greatgrandparent = reset($greatgrandparent);
          if (is_object($greatgrandparent)) {
            if (!in_array($greatgrandparent, $this->departments)) {
              $this->departments[] = $greatgrandparent->id();
            }
          }
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
