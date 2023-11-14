<?php

namespace Drupal\if_components\Plugin\Filter;

use Drupal\Core\Url;
use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class InsertWebformFilter.
 *
 * Insert webform into the content as a block.  This uses the same token syntax as D7 site.
 *
 * @package Drupal\if_components\Plugin\Filter
 *
 * @Filter(
 *   id = "filter_insert_webform",
 *   title = @Translation("Insert webform"),
 *   description = @Translation("Inserts the contents of a webform block into a node using [block:webform=client-block-WEBFORM ID] tag from D7."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE
 * )
 */
class InsertWebformFilter extends FilterBase implements ContainerFactoryPluginInterface {

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

    if (preg_match_all("/\[block:webform=client-block-([^\]]+)+\]/", $text, $match)) {
      $raw_tags = $repl = [];
      foreach ($match[1] as $key => $value) {
        $raw_tags[] = $match[0][$key];

        // This prepending webform_ to the webform-id is a left over from the conversion. The second try should
        // hanle new forms.
        $webform = $this->entityTypeManager->getStorage('webform')->load('webform_' . $value);
        if (is_null($webform)) {
            // Try just the webform-id.
            $webform = $this->entityTypeManager->getStorage('webform')->load($value);
        }
        // If we got a webform, process it.
        if (NULL !== $webform) {
          $webform = $this->entityTypeManager->getViewBuilder('webform')->view($webform);
          $repl[] = $this->renderer->render($webform);
          $result->addCacheTags($webform['#cache']['tags'])->addCacheContexts($webform['#cache']['contexts']);
        }

        if (!empty($repl)) {
          $text = str_replace($raw_tags, $repl, $text);
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
      return $this->t('<a id="filter-insert_reusable_component"></a>You may use [block:webform=client-block-<em>WEBFORM ID</em>] tags</a> to display the contents of a webform block.');
    }
    else {
      $tips_url = Url::fromRoute("filter.tips_all", [], ['fragment' => 'filter-insert_reusable_component']);
      return $this->t('You may use <a href="@insert_reusable_component_help">[block:webform=client-block-<em>WEBFORM ID</em>] tags</a> to display the contents of a webform block.',
        ["@insert_reusable_component_help" => $tips_url->toString()]);
    }
  }

}
