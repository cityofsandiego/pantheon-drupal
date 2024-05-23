<?php

namespace Drupal\sand_example\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Drupal\sand_example\SandExampleServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

// Bundle Interfaces.
use Drupal\sand_type\Entity\Bundle\Interface\DepartmentInterface;

// Bundle Classes.
use Drupal\sand_type\Entity\Bundle\Article;
use Drupal\sand_type\Entity\Bundle\Hero;

// Query Classes
use Drupal\sand_type\Query\Bundle\ArticleQuery;

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
  
  protected $myService;

  /**
   * The controller constructor.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   */
  public function __construct(ContainerInterface $container, SandExampleServiceInterface $myService) {
    $this->container = $container;
    $this->myService = $myService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('service_container'),
      $container->get('sand_example.service1'),
    );
  }

  /**
   * Builds the response.
   */
  public function build() {
    
    $build['service_example'] = [
      '#markup' => $this->t('From myService doSomething: ') . $this->myService->doSomething(),
    ];


    // Example of node query.
    $nids = \Drupal::entityQuery('node')
      ->accessCheck(TRUE)
      ->condition('status', 1)
      ->condition('type', ['article','hero'], 'in')
      ->range(0,200)
      ->execute();
    $nodes = Node::loadMultiple($nids);


    // Table example with Headers and Rows.
    $header = [
      'title' => t('Node ID'),
      'content' => t('Title'),
      'time_type' => t('Hero / Article / External'),
      'dept' => t('Departments'),
    ];

    $rows = [];
    foreach ($nodes as $node) {
      $time_type = '';
      $dept = '';
      // The Hero Class is works because of the concept of bundle classes introduced
      // in 9.3. You have to have a hook tell Drupal about the class, then of course
      // define the class. The hook is: sand_example_entity_bundle_info_alter. 
      // Remember you can test for the Bundle Class OR the Interface Class. See
      // Hero.php for more details.

      if ($node instanceof Hero) {
        $time_type = 'Hero Time';
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
    
    $ids_array = ArticleQuery::getIds();
    
    $build['article_ids'] = [
      '#markup' => 'Aricle Ids: ' . implode(',', $ids_array),
    ];

    return $build;
  }

}
