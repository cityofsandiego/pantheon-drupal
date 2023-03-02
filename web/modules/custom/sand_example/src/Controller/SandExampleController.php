<?php

namespace Drupal\sand_example\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

// Bundle Interfaces.
use Drupal\sand_example\Entity\Bundle\DepartmentInterface;

// Bundle Classes.
use Drupal\sand_example\Entity\Bundle\Article;
use Drupal\sand_example\Entity\Bundle\Hero;

/**
 * Returns responses for Sand hero routes.
 */
class SandExampleController extends ControllerBase {

  /**
   * The container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected $container;

  /**
   * The controller constructor.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   */
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('service_container')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {

    // Example of node query.
    $nids = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', ['article','hero'], 'in')
      ->range(0,100)
      ->execute();
    $nodes = Node::loadMultiple($nids);


    // Table example with Headers and Rows.
    $header = [
      'title' => t('Title'),
      'content' => t('Content'),
      'time_type' => t('Hero Time / Article Type'),
      'dept' => t('Departments'),
    ];

    $rows = [];
    foreach ($nodes as $node) {
      $time_type = '';
      $dept = '';
      if ($node instanceof Hero) {
        $time_type = $node->getTimeOfDay();
      }
      if ($node instanceof Article) {
        $time_type = $node->getArticleType();
      }
      if ($node instanceof DepartmentInterface) {
        $dept = $node->getDepartments();
      }

      $rows[] = [
        $node->id(), 
        $node->getTitle(), 
        $time_type, 
        $dept
      ];
    }

    // Now create the render element for a type of 'table'.
    $build['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => t('No content has been found.'),
    ];
    
    return $build;
  }

}
