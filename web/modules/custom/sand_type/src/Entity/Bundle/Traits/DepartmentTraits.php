<?php

namespace Drupal\sand_type\Entity\Bundle\Traits;

trait DepartmentTraits {

  public function getDepartments(): ?string {
    if ($this->hasField('field_department')) {
      $departments_name = [];
      $departments = $this->get('field_department')->getValue();
      foreach ($departments as $key => $department) {
        $term = \Drupal::entityTypeManager()
          ->getStorage('taxonomy_term')
          ->load($department['target_id']);
        $departments_name[] = $term->getName();
      }
      return implode(',', $departments_name);
    } else {
      return NULL;
    }
  }

    public function getDepartmentsTID($include_parents = FALSE): ?array {
        if ($this->hasField('field_department')) {
            $departments_tids = [];
            $departments = $this->get('field_department')->getValue();
            foreach ($departments as $key => $department) {
                $departments_tids[] = $department['target_id'];
                if ($include_parents) {
                    $ancestors = \Drupal::service('entity_type.manager')->getStorage("taxonomy_term")->loadAllParents($department['target_id']);
                    $departments_tids += array_keys($ancestors);
                }
            }
            return array_unique($departments_tids);
        } else {
            return [];
        }
    }
  
}
