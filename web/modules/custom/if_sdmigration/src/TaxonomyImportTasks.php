<?php

namespace Drupal\if_sdmigration;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\taxonomy\Entity\Term;

/**
 * Taxonomy functions for drush import command.
 */
class TaxonomyImportTasks {

  /**
   * EntityTypeManagerInterface.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * TemplateUpdatesReferences constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Checks to see if a term exists from a prior import.
   */
  public function newTid($d7id, $vocabulary) {
    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition('vid', $vocabulary)
      ->condition('field_field_d7_tid', $d7id);
    $tids = $query->execute();
    if (empty($tids)) {
      $tid = '';
    }
    else {
      $tid = array_shift(array_values($tids));
    }
    return $tid;
  }

  /**
   * Import a taxonomy term.
   */
  public function createTerm($d7id, $vocabulary, $termdata) {
    if (empty($termdata['name'])) {
      // Invalid empty name term.
      return;
    }
    $term = Term::create([
      'name' => $termdata['name'],
      'vid' => $vocabulary,
      'field_field_d7_tid' => $d7id,
    ]);
    if (!empty($termdata['parent'])) {
      $parent_tid = $this->newTid($termdata['parent'], $vocabulary);
      $term->parent = $parent_tid;
    }
    $term->save();
  }

}
