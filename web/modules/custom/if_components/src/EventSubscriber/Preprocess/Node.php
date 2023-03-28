<?php

namespace Drupal\if_components\EventSubscriber\Preprocess;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Menu\MenuActiveTrail;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\file\Entity\File;
use Drupal\node\NodeInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\preprocess_event_dispatcher\Event\BlockPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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
    ];
  }

  public function preprocessPage(PagePreprocessEvent $event): void {
    $variables = $event->getVariables();

    if ($variables->getNode() !== NULL) {
      /**
       * @todo remove or edit this.
       * sand_hero module looks to supersede this, so I just grab a random
       * hero image, only taking into account whether it's the front page.
       */
      $query = $this->entityTypeManager
        ->getListBuilder('node')
        ->getStorage()
        ->getQuery();
      $query->condition('type', 'hero')
        ->condition('field_hero_frontpage', 0);
      $nids = $query->execute();
      $nid = array_rand($nids, 1);
      $hero_node = $this->entityTypeManager->getStorage('node')->load($nid);
      if ($hero_node !== NULL && $hero_node->get('field_image')->getValue() !== NULL) {
        $hero_image = $this->entityTypeManager->getStorage('media')
          ->load($hero_node->get('field_image')->getValue()[0]['target_id']);
        if ($hero_image !== NULL) {
          $fid = $hero_image->getSource()->getSourceFieldValue($hero_image);
          $hero_image_file = File::load($fid);
          $variables->set('hero_image', $hero_image_file->createFileUrl());
        }
      }
    }
  }

  public function preprocessTitleBlock(BlockPreprocessEvent $event): void {
    $variables = $event->getVariables();
    $content_types = ['department', 'location', 'department_document', 'article', 'blog', 'department_parent', 'mayoral_artifacts', 'digital_archives_photos'];

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
        $variables->set('topmenu', [
          'items' => $this->topMenuLinkData,
        ]);

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

    }

  }

}
