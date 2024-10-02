<?php

namespace Drupal\if_components\Plugin\Filter;

use Drupal\Core\Url;
use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class InsertReusableComponentFilter.
 *
 * Insert reusable component body into the content.  This uses the same token syntax as D7 site.
 *
 * @package Drupal\if_components\Plugin\Filter
 *
 * @Filter(
 *   id = "filter_insert_reusable_component",
 *   title = @Translation("Insert reusable components"),
 *   description = @Translation("Inserts the contents of a reusable component body into a node using [block:bean=bean-delta] tag from D7."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE
 * )
 */
class InsertReusableComponentFilter extends FilterBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Renderer instance.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition) {
    $instance = new static(
      $configuration,
      $pluginId,
      $pluginDefinition
    );
    $instance->entityTypeManager = $container->get('entity_type.manager');
    $instance->renderer = $container->get('renderer');
    $instance->currentUser = $container->get('current_user');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {

    $result = new FilterProcessResult($text);

    if (preg_match_all("/\[block:bean=([^\]]+)+\]/", $text, $match)) {
      $raw_tags = $repl = [];
      foreach ($match[1] as $key => $value) {
        $raw_tags[] = $match[0][$key];
        $query = $this->entityTypeManager
          ->getStorage('node')
          ->getQuery();
        $query->condition('type', 'reusable_component')
          ->condition('field_block_delta', $value);
        $query->accessCheck(FALSE);
        $query_result = $query->execute();
        if (!empty($query_result)) {
          $nid = reset($query_result);
          if ($node = $this->entityTypeManager->getStorage('node')->load($nid)) {
            $component_view = $this->entityTypeManager->getViewBuilder('node')
              ->view($node, 'full');
          }
          else {
            $component_view = NULL;
          }

          if (!empty($component_view)) {
            $repl[] = $this->renderer->render($component_view);
            $result->addCacheTags($component_view['#cache']['tags'])
              ->addCacheContexts($component_view['#cache']['contexts']);
          }

          if (!empty($repl)) {
            $text = str_replace($raw_tags, $repl, $text);
          }
        }
      }
    }

    $result->setProcessedText($text);
    return $result;

  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    if ($long) {
      return $this->t('<a id="filter-insert_reusable_component"></a>You may use [block:bean=<em>bean_delta</em>] tags to display the contents of a reusable component (migrated D7 bean).');
    }
    else {
      $tips_url = Url::fromRoute("filter.tips_all", [], ['fragment' => 'filter-insert_reusable_component']);
      return $this->t('You may use <a href="@insert_reusable_component_help">[block:bean=<em>bean_delta</em>] tags</a> to display the contents of a reusable component.',
        ["@insert_reusable_component_help" => $tips_url->toString()]);
    }
  }

}
