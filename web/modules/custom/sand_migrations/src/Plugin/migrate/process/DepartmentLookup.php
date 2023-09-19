<?php

declare(strict_types = 1);

namespace Drupal\sand_migrations\Plugin\migrate\process;

use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This plugin looks for existing entities.
 *
 * In its most simple form, this plugin needs no configuration, and determines
 * the configuration automatically. This requires the migration's process to
 * define a default value for the destination entity's bundle key, and the
 * destination field this plugin is on to be a supported type.
 *
 * Available configuration keys:
 * - entity_type: (optional) The ID of the entity type to query for.
 * - value_key: (optional) The name of the entity field on which the source
 *   value will be queried. If omitted, defaults to one of the following
 *   depending on the destination field type:
 *    - entity_reference: The entity label key.
 *    - file: The uri field.
 *    - image: The uri field.
 * - operator: (optional) The comparison operator supported by entity query:
 *   See \Drupal\Core\Entity\Query\QueryInterface::condition() for available
 *   values. Defaults to '=' for scalar values and 'IN' for arrays.
 * - bundle_key: (optional) The name of the bundle field on the entity type
 *   being queried.
 * - bundle: (optional) The value to query for the bundle - can be a string or
 *   an array.
 * - access_check: (optional) Indicates if access to the entity for this user
 *   will be checked. Default is true.
 * - ignore_case: (optional) Whether to ignore case in the query. Defaults to
 *   false, meaning the query is case-sensitive by default. Works only with
 *   strict operators: '=' and 'IN'.
 * - destination_field: (optional) If specified, and if the plugin's source
 *   value is an array, the result array's items will be themselves arrays of
 *   the form [destination_field => ENTITY_ID].
 *
 * @codingStandardsIgnoreStart
 *
 * Example usage with minimal configuration:
 * @code
 * destination:
 *   plugin: 'entity:node'
 * process:
 *   type:
 *     plugin: default_value
 *     default_value: page
 *   field_tags:
 *     plugin: entity_lookup
 *     access_check: false
 *     source: tags
 * @endcode
 * In this example above, the access check is disabled.
 *
 * Example usage with full configuration:
 * @code
 *   field_tags:
 *     plugin: entity_lookup
 *     source: tags
 *     value_key: name
 *     bundle_key: vid
 *     bundle: tags
 *     entity_type: taxonomy_term
 *     ignore_case: true
 *     operator: STARTS_WITH
 * @endcode
 *
 * @codingStandardsIgnoreEnd
 *
 * @see \Drupal\Core\Entity\Query\QueryInterface::condition()
 *
 * @MigrateProcessPlugin(
 *   id = "department_lookup",
 *   handle_multiples = TRUE
 * )
 */
class DepartmentLookup extends ProcessPluginBase implements ContainerFactoryPluginInterface {

  protected ?EntityTypeManagerInterface $entityTypeManager;
  protected EntityFieldManagerInterface $entityFieldManager;
  protected MigrationInterface $migration;
  protected SelectionPluginManagerInterface $selectionPluginManager;
  protected ?string $destinationEntityType;
  protected ?string $destinationBundleKey = NULL;
  protected ?string $lookupValueKey = NULL;
  protected ?string $lookupBundleKey = NULL;
  protected $lookupBundle = NULL;
  protected ?string $lookupEntityType = NULL;
  protected ?string $destinationProperty;
  protected bool $accessCheck = TRUE;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition, MigrationInterface $migration = NULL) {
    $instance = new static(
      $configuration,
      $pluginId,
      $pluginDefinition
    );
    $instance->migration = $migration;
    $instance->entityTypeManager = $container->get('entity_type.manager');
    $instance->entityFieldManager = $container->get('entity_field.manager');
    $instance->selectionPluginManager = $container->get('plugin.manager.entity_reference_selection');
    $pluginIdParts = explode(':', $instance->migration->getDestinationPlugin()->getPluginId());
    $instance->destinationEntityType = empty($pluginIdParts[1]) ? NULL : $pluginIdParts[1];
    $instance->destinationBundleKey = $instance->destinationEntityType ? $instance->entityTypeManager->getDefinition($instance->destinationEntityType)->getKey('bundle') : NULL;
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // If the source data is an empty array, return the same.
    if (gettype($value) === 'array' && count($value) === 0) {
      return [];
    }

    $tids = [];
    foreach ($value as $key => $tag) {
      $tid = $tag['tid'];

      $query = \Drupal::database()->select('taxonomy_term_revision__field_field_d7_tid', 't');
      $query->addField('t', 'entity_id');
      $query->condition('t.field_field_d7_tid_value', $tid);
      $results = $query->execute();
      $new_tid = $results->fetchCol();
      if (!empty($new_tid[0])) {
        $tids[] = $new_tid[0];
//      } else {
//          $new_term = Term::create([ 'vid' => 'department', 'name' => 'A Not Found during migration' ]);
////          $new_term->enforceIsNew();
//          $new_term->save();
//          $tids[] = $new_term->id();
      }
    }
    $tids = [4059];
    return array_unique($tids);
  }

}
