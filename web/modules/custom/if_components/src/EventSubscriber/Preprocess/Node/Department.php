<?php

namespace Drupal\if_components\EventSubscriber\Preprocess\Node;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Menu\MenuActiveTrail;
use Drupal\Core\Menu\MenuLinkManagerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class Department.
 *
 * Preprocess Department content type node.
 *
 * @package Drupal\if_components\EventSubscriber\Preprocess
 */
final class Department implements EventSubscriberInterface {

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * The menu link manager.
   *
   * @var \Drupal\Core\Menu\MenuLinkManagerInterface
   */
  protected $menuLinkManager;

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
   * Menu name.
   *
   * @var string
   */
  protected $menuName = 'departments';

  /**
   * Menu link data to be sent to the template.
   *
   * @var array
   */
  protected array $menuLinkData = [];

  /**
   * Departments menu cache tags.
   *
   * @var array
   */
  protected array $cache = [];

  /**
   * Constructs a new Departments.
   *
   * @param \Drupal\Core\Routing\CurrentRouteMatch $current_route_match
   *   The route match.
   * @param \Drupal\Core\Menu\MenuLinkManagerInterface $menu_link_manager
   *   The menu link manager.
   * @param \Drupal\Core\Menu\MenuActiveTrail $menu_active_trail
   *   Drupal menu active trail.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager service.
   */
  public function __construct(
    CurrentRouteMatch $current_route_match,
    MenuLinkManagerInterface $menu_link_manager,
    MenuActiveTrail $menu_active_trail,
    EntityTypeManagerInterface $entity_type_manager
  ) {
    $this->currentRouteMatch = $current_route_match;
    $this->menuLinkManager = $menu_link_manager;
    $this->menuActiveTrail = $menu_active_trail;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      NodePreprocessEvent::name('department') => 'preprocessDepartment',
    ];
  }

  /**
   * Preprocess a node with bundle type department in view mode full.
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent $event
   *   Event.
   */
  public function preprocessDepartment(NodePreprocessEvent $event): void {
    $variables = $event->getVariables();
    // Get existing cache data.
    $this->cache = $variables->get('#cache') ?? [];

    $node = $variables->getEntity();

    $this->buildMenuLinks();

    $variables->set(
      'menu_items',
      [
        'menu_items' => $this->menuLinkData,
      ]
    );

    $sidebar = [];
    $sidebar_bottom = [];
    $context_ids = [];
    $departments = [];

    $field_department = $node->field_department->getValue();
    foreach ($field_department as $department) {
      $departments[] = $department['target_id'];
    }
    if (!empty($field_department)) {
      foreach ($departments as $department) {
        $query = $this->entityTypeManager
          ->getListBuilder('node')
          ->getStorage()
          ->getQuery();
        $query->condition('type', 'sidebar_block_context')
          ->condition('field_department', [$department], 'IN');
        $nids = $query->execute();
        foreach ($nids as $nid) {
          if (!in_array($nid, $context_ids)) {
            $context_ids[] = $nid;
          }
        }
      }
      foreach ($departments as $department) {
        $parent = $this->entityTypeManager
          ->getStorage('taxonomy_term')
          ->loadParents($department);
        $parent = reset($parent);
        if (is_object($parent)) {
          if (!in_array($parent, $departments)) {
            $departments[] = $parent->id();
          }
        }
      }
      foreach ($departments as $department) {
        $query = $this->entityTypeManager
          ->getListBuilder('node')
          ->getStorage()
          ->getQuery();
        $query->condition('type', 'sidebar_block_context')
          ->condition('field_department_subs', [$department], 'IN');
        $nids = $query->execute();
        foreach ($nids as $nid) {
          if (!in_array($nid, $context_ids)) {
            $context_ids[] = $nid;
          }
        }
      }
      // Load sidebar context nodes, load block content.
      foreach ($context_ids as $nid) {
        $context_node = Node::load($nid);
        foreach ($context_node->field_block->getValue() as $paragraph_id) {
          $paragraph = Paragraph::load($paragraph_id['target_id']);
          switch ($paragraph->field_region->getValue()[0]['value']) {
            case 'sidebar':
              $sidebar[] = [
                'weight' => $paragraph->field_weight->getValue()[0]['value'],
                'value' => $this->entityTypeManager->getViewBuilder('paragraph')->view($paragraph, 'full'),
              ];
              break;
            case 'sidebar_bottom':
              $sidebar_bottom[] = [
                'weight' => $paragraph->field_weight->getValue()[0]['value'],
                'value' => $this->entityTypeManager->getViewBuilder('paragraph')->view($paragraph, 'full'),
              ];
              break;
          }
        }
      }
    }

    array_multisort(array_column($sidebar, 'weight'), SORT_ASC, $sidebar);
    array_multisort(array_column($sidebar_bottom, 'weight'), SORT_ASC, $sidebar_bottom);
    $variables->set('sidebar', $sidebar);
    $variables->set('sidebar_bottom', $sidebar_bottom);

    // Ensure all cache tags are up-to-date given entities referenced.
    $variables->set('#cache', $this->cache);
  }

  /**
   * Builds the menu links for this Department.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  private function buildMenuLinks() {
    // Check if the Department page is listed in the Departments menu.
    $menu_level = $this->menuActiveTrail->getActiveTrailIds($this->menuName);
    $menu_level = reset($menu_level);

    if (!empty($menu_level)) {
      // Load child menu items by 'parent' property.
      $second_menu_content_storage = $this->entityTypeManager->getStorage('menu_link_content');
      $menu_link_content_child = $second_menu_content_storage->loadByProperties(['parent' => $menu_level]);
      if (!empty($menu_link_content_child)) {
        foreach ($menu_link_content_child as $menu_link_content) {
          $this->extractMenuLinkData($menu_link_content);
        }
      }
    }
  }

  /**
   * Extracts the menu link content and adds it to the display.
   *
   * @param object $menuLinkContent
   *   Menu link object.
   */
  private function extractMenuLinkData($menuLinkContent) {
    // Add this item to our list of menu to display.
    $this->menuLinkData[] = [
      'title' => $menuLinkContent->getTitle(),
      'url' => $this->getMenuLink($menuLinkContent),
    ];

    // Add this menu item's cache tag to the node cache tags so that when it is
    // updated, this paragraph's cache will be invalidated.
    $this->cache = array_merge_recursive($this->cache, [
      'tags' => [
        'menu_link_content:' . $menuLinkContent->id(),
      ],
    ]);

  }

  /**
   * Extracts the menu link content and adds it to the display.
   *
   * @param object $menuLinkContent
   *   Menu object.
   */
  private function getMenuLink($menuLinkContent) {
    return $menuLinkContent->getUrlObject()->toString();
  }

}
