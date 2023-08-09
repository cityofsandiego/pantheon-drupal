<?php

namespace Drupal\sand_info\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Returns responses for Sand info routes.
 */
class SandInfoController extends ControllerBase
{

    /**
     * Builds the response.
     */
    public function build()
    {

        $build['content'] = [
            '#type' => 'item',
            '#markup' => $this->t('It works!'),
        ];


        $header[] = ['Name', 'Machine', 'Required', 'Type'];

        $entityFieldManager = \Drupal::service('entity_field.manager');
        $entity_type = 'node';

        $types = \Drupal::entityTypeManager()
            ->getStorage('node_type')
            ->loadMultiple();
        $bundles = [];
        foreach ($types as $type) {
            $bundles[] = $type->id();
        }

        foreach ($bundles as $bundle) {

            $fields = $entityFieldManager->getFieldDefinitions($entity_type, $bundle);
            $rows = [];
            /** @var BaseFieldDefinition $field */
            foreach ($fields as $field) {
                if ($field->getName() === 'body' || str_starts_with($field->getName(), 'field_') && $field->getName() !== 'field_d7_nid' ) {
                    $rows[] = [$field->getLabel(), $field->getName(), $field->isRequired() ? 'Y' : '', $field->getType()];
                }
            }
            asort($rows);

            $build['table_' . $bundle . '_head'] = [
                '#markup' => "<h2>$bundle</h2>"
                ];
            $build['table_' . $bundle . '_table'] = [
                '#type' => 'table',
                '#header' => $header,
                '#rows' => $rows,
                '#empty' => t('No content has been found.'),
            ];
        }


      $list = \Drupal::service('entity_type.repository')->getEntityTypeLabels();

      $build['entity_type_header'] = [
        '#markup' => '<h2>List of all entity types</h2>',
      ];
      $keys = array_keys($list);
      foreach ($keys as $key) {
        $build['entity_type_' . $key] = [
          '#markup' => $key . '<br>',
        ];
      }

      return $build;
    }

}
