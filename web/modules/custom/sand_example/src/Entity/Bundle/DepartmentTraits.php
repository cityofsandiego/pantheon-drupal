<?php

namespace Drupal\sand_example\Entity\Bundle;

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
  
}
