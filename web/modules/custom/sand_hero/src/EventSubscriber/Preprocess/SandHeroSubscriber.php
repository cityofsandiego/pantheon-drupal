<?php

namespace Drupal\sand_hero\EventSubscriber\Preprocess;

use Drupal;
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
//      NodePreprocessEvent::name() => 'preprocessNode',
//      BlockPreprocessEvent::name() => 'preprocessTitleBlock',
      PagePreprocessEvent::name() => 'preprocessPage',
    ];
  }

  public function preprocessPage(PagePreprocessEvent $event): void {
    $variables = $event->getVariables();

    if ($variables->getNode() !== NULL) {
      $departments_on_node = [];
      $nids = [];
      $node = Drupal::routeMatch()->getParameter('node');
      if ($node instanceof NodeInterface) {
        $department_terms = $node->get('field_department')->getValue();
        if (!empty($department_terms)) {
          foreach ($department_terms as $department_term) {
            // do something with department term
            $departments_on_node[] = $department_term["target_id"];
          }
        }
      }

      if (!empty($departments_on_node)) {
        $nids = sand_hero_query_hero_ids($departments_on_node);
      }
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
}
