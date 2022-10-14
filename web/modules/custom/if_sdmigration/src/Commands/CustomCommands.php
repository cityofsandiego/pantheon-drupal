<?php

namespace Drupal\if_sdmigration\Commands;

use Drupal\Core\Extension\ExtensionList;
use Drupal\if_sdmigration\TaxonomyImportTasks;
use Drush\Commands\DrushCommands;

/**
 * Drush command file.
 */
class CustomCommands extends DrushCommands {

  /**
   * ExtensionList.
   *
   * @var \Drupal\Core\Extension\ExtensionList
   */
  protected $extensionList;
  /**
   * TaxonomyImportTasks.
   *
   * @var \Drupal\if_sdmigration\TaxonomyImportTasks
   */
  protected $taxonomyImportTasks;

  /**
   * TemplateUpdatesReferences constructor.
   *
   * @param \Drupal\Core\Extension\ExtensionList $extensionList
   *   Extension list.
   */
  public function __construct(ExtensionList $extensionList, TaxonomyImportTasks $taxonomyImportTasks) {
    $this->extensionList = $extensionList;
    $this->taxonomyImportTasks = $taxonomyImportTasks;
  }

  /**
   * Imports/updates taxonomy terms.
   *
   * @command import:taxonomy
   * @param $vocabulary (Vocabulary and CSV file to import).
   *
   * @usage import:taxonomy
   */
  public function importTaxonomy($vocabulary) {
    if (!empty($vocabulary)) {
      if ($taxonomy_file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/vocabularies/' . $vocabulary . '.csv', 'r')) {
        $termdata = [];
        fgets($taxonomy_file);
        while ($data = fgetcsv($taxonomy_file)) {
          $term_info = [
            'parent' => $data[1],
            'name' => $data[2],
          ];
          if (empty($data[1])) {
            // No parent set, add term if it doesn't already exist.
            if (empty($this->taxonomyImportTasks->newTid($data[0], $vocabulary))) {
              $this->taxonomyImportTasks->createTerm($data[0], $vocabulary, $term_info);
            }
          }
          else {
            $termdata[$data[0]] = $term_info;
          }
        }
        /* Keep iterating as parent terms are added and there are no more child terms remaining. */
        while (count($termdata) > 0) {
          $pending = [];
          foreach ($termdata as $d7id => $data) {
            if (!empty($this->taxonomyImportTasks->newTid($data['parent'], $vocabulary))) {
              // Check if term's parent exists, if it does add term if not already added.
              if (empty($this->taxonomyImportTasks->newTid($d7id, $vocabulary))) {
                $this->taxonomyImportTasks->createTerm($d7id, $vocabulary, $data);
              }
            }
            else {
              // No parent set, add term if it doesn't already exist.
              $pending[$d7id] = $data;
            }
          }
          $termdata = $pending;
        }
        fclose($taxonomy_file);
      }
    }
  }

    /**
     * Import fields: field_resources, field_search_keymatch, field_image, field_category, field_department
     *
     * @command import:department
     *
     * @usage import:department
     */
  public function finalizeDepartment() {
    $text = 'test123';
    echo iconv("UTF-8", "ISO-8859-1", $text), PHP_EOL;
  }
}
