<?php

namespace Drupal\sand_search\Plugin\search_api\processor;

use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\search_api\Plugin\PluginFormTrait;
use Drupal\search_api\Processor\ProcessorPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Excludes entities marked as 'excluded' from being indexes.
 *
 * @SearchApiProcessor(
 *   id = "sand_search_processor",
 *   label = @Translation("Sand Search Processor to exclude by path"),
 *   description = @Translation("Exclude entities from being indexed via path alias."),
 *   stages = {
 *     "alter_items" = -50
 *   }
 * )
 */
class SandSearchProcessor extends ProcessorPluginBase implements PluginFormInterface {

  use PluginFormTrait;

  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface|null
   */
  protected $entityFieldManager;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    /** @var static $processor */
    $processor = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $processor->setEntityFieldManager($container->get('entity_field.manager'));
    return $processor;
  }

  /**
   * Retrieves the entity field manager.
   *
   * @return \Drupal\Core\Entity\EntityFieldManagerInterface
   *   The entity field manager.
   */
  public function getEntityFieldManager() {
    return $this->entityFieldManager ?: \Drupal::service('entity_field.manager');
  }

  /**
   * Sets the entity field manager.
   *
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The new entity field manager.
   *
   * @return $this
   */
  public function setEntityFieldManager(EntityFieldManagerInterface $entity_field_manager) {
    $this->entityFieldManager = $entity_field_manager;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'paths' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $paths_config = $this->getConfiguration()['paths'];

      $form['paths'] = [
        '#type' => 'textarea',
        '#title' => $this->t('Paths to exclude from Search'), 
        '#description' => $this->t('List each path on a newline to exclude from this index. Wildcard (*) allowed at the end of the path'),
        '#default_value' => $paths_config,
      ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->setConfiguration($values);
  }

  /**
   * {@inheritdoc}
   */
  public function alterIndexedItems(array &$items) {
    $config = $this->getConfiguration()['paths'];
    // Convert \r\n to |. Done in two steps because I'm not
    // sure if \n can appear on a linux client instead of \r\n.
    $config_removed_cr = str_replace("\r", "", $config);
    $paths = str_replace("\n", "|", $config_removed_cr);

    /** @var \Drupal\search_api\Item\ItemInterface $item */
    foreach ($items as $item_id => $item) {
      $object = $item->getOriginalObject()->getValue();
      if (!$object instanceof EntityInterface) {
        continue;
      }
      $entity_path = $object->toUrl()->toString();
      if (preg_match('#' . $paths . '#', $entity_path, $matches)) {
        unset($items[$item_id]);
      }
    }
  }

}
