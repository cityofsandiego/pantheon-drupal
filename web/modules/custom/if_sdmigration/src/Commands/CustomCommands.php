<?php

namespace Drupal\if_sdmigration\Commands;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ExtensionList;
use Drupal\Core\File\FileSystemInterface;
use Drupal\node\Entity\Node;
use Drupal\media\Entity\Media;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\pathauto\PathautoState;
use Drupal\if_sdmigration\TaxonomyImportTasks;
use Drupal\taxonomy\Entity\Term;
use Drush\Commands\DrushCommands;

/**
 * Drush command file.
 */
class CustomCommands extends DrushCommands {

  /**
   * EntityTypeManagerInterface.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

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
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Entity type manager.
   * @param \Drupal\Core\Extension\ExtensionList $extensionList
   *   Extension list.
   * @param \Drupal\if_sdmigration\TaxonomyImportTasks $taxonomyImportTasks
   *   Taxonomy import tasks.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, ExtensionList $extensionList, TaxonomyImportTasks $taxonomyImportTasks) {
    $this->entityTypeManager = $entityTypeManager;
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
          $d7id = str_replace('`', '', $data[0]);
          $parent = str_replace('`', '', $data[1]);
          $term_info = [
            'parent' => $parent,
            'name' => str_replace('`', '', $data[2]),
          ];
          if (empty($parent)) {
            // No parent set, add term if it doesn't already exist.
            if (empty($this->taxonomyImportTasks->newTid($d7id, $vocabulary))) {
              $this->taxonomyImportTasks->createTerm($d7id, $vocabulary, $term_info);
            }
          }
          else {
            $termdata[$d7id] = $term_info;
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
   * Import fields: field_resources, field_search_keymatch, field_image, field_category, field_department, path
   *
   * @command import:department
   *
   * @usage import:department
   */
  public function finalizeDepartment() {
    $nodedata = [];
    $resourcedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/departments-small.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'path' => str_replace('`', '', $data[1]),
          'resources' => str_replace('`', '', $data[2]),
          'department' => str_replace('`', '', $data[3]),
          'category' => str_replace('`', '', $data[4]),
          'search_keymatch' => str_replace('`', '', $data[5]),
          'image_department' => str_replace('`', '', $data[6]),
          'image_license' => str_replace('`', '', $data[7]),
          'image_alt' => str_replace('`', '', $data[8]),
          'image_d7id' => str_replace('`', '', $data[9]),
          'image_path' => str_replace('`', '', $data[10]),
        ];
      }
      fclose($file);
    }

    // Resource field collection.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_dept_resources_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $resourcedata[$id] = [
          'icon' => str_replace('`', '', $data[1]),
          'label' => str_replace('`', '', $data[2]),
          'url' => str_replace('`', '', $data[3]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'department')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      // Set alias.
      $node->path = [
        'alias' => $data['path'],
        'pathauto' => PathautoState::SKIP,
      ];

      // Create and set resource paragraph.
      if (!empty($data['resources']) && isset($resourcedata[$data['resources']])) {
        $resource = $resourcedata[$data['resources']];
        $paragraph = Paragraph::create([
          'type' => 'resources',
          'field_icon' => $resource['icon'],
          'field_label' => $resource['label'],
          'field_link' => [
            'uri' => $resource['url'],
          ],
        ]);
        $paragraph->save();
        $node->field_resources = $paragraph;
      }

      // Create (if not pre-existing) and set image.
      if (!empty($data['image_path'])) {
        $prior_image = $this->checkMediaId($data['image_d7id']);
        if ($prior_image == NULL) {
          $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $data['image_path']);
          $file_data = file_get_contents($remote_file);
          // Fixes for irregular paths.
          $local_destination = str_replace('legacy/police/graphics', '', $data['image_path']);
          $local_destination = str_replace('default_images', '', $local_destination);
          $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
          $local_destination = str_replace('public://', '', $local_destination);
          $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
          $image_department = [$this->taxonomyImportTasks->newTid($data['image_department'], 'department')];

          $image = Media::create([
            'bundle' => 'image',
            'uid' => 0,
            'field_media_image' => [
              'target_id' => $local_file->id(),
              'alt' => $data['image_alt']
            ],
            'field_d7_mid' => $data['image_d7id'],
          ]);
          if (!empty($data['image_license'])) {
            $image->field_license = $data['image_license'];
          }
          foreach ($image_department as $department) {
            $image->field_department->appendItem([
              'target_id' => $department,
            ]);
          }
          $image->save();
        }
        else {
          $image = Media::load($prior_image);
        }
        $node->field_image = $image;
      }
      // Set three taxonomies.
      $node->field_department->setValue([]);
      foreach (explode(' |', $data['department']) as $department) {
        $term = Term::load($this->taxonomyImportTasks->newTid($department, 'department'));
        $node->field_department->appendItem($term);
      }
      $node->field_category->setValue([]);
      foreach (explode('|', $data['category']) as $category) {
        $term = Term::load($this->taxonomyImportTasks->newTid($category, 'categories'));
        $node->field_category->appendItem($term);
      }
      $node->field_search_keymatch->setValue([]);
      foreach (explode('|', $data['search_keymatch']) as $search_keymatch) {
        $term = Term::load($this->taxonomyImportTasks->newTid($search_keymatch, 'search_keymatch'));
        $node->field_search_keymatch->appendItem($term);
      }

      $node->save();
    }
  }

  /**
   * Import fields: field_resources, field_search_keymatch, field_image, field_category, field_department, path, field_social_links, field_feature_video_img
   *
   * @command import:department-parent
   *
   * @usage import:department-parent
   */
  public function finalizeDepartmentParent() {
    $nodedata = [];
    $resourcedata = [];
    $socialdata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/department-parents.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'path' => str_replace('`', '', $data[1]),
          'resources' => str_replace('`', '', $data[2]),
          'department' => str_replace('`', '', $data[3]),
          'category' => str_replace('`', '', $data[4]),
          'search_keymatch' => str_replace('`', '', $data[5]),
          'image_department' => str_replace('`', '', $data[6]),
          'image_license' => str_replace('`', '', $data[7]),
          'image_alt' => str_replace('`', '', $data[8]),
          'image_d7id' => str_replace('`', '', $data[9]),
          'image_path' => str_replace('`', '', $data[10]),
          'social_links' => str_replace('`', '', $data[15]),
          'featured_image_department' => str_replace('`', '', $data[16]),
          'featured_image_license' => str_replace('`', '', $data[17]),
          'featured_image_alt' => str_replace('`', '', $data[18]),
          'featured_image_d7id' => str_replace('`', '', $data[19]),
          'featured_image_path' => str_replace('`', '', $data[20]),
        ];
      }
      fclose($file);
    }

    // Resource field collection.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_dept_resources_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $resourcedata[$id] = [
          'icon' => str_replace('`', '', $data[1]),
          'label' => str_replace('`', '', $data[2]),
          'url' => str_replace('`', '', $data[3]),
        ];
      }
      fclose($file);
    }

    // Social media field collection.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_dept_par_social_links_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $socialdata[$id] = [
          'type' => str_replace('`', '', $data[1]),
          'url' => str_replace('`', '', $data[2]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'department_parent')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      // Set alias.
      $node->path = [
        'alias' => $data['path'],
        'pathauto' => PathautoState::SKIP,
      ];

      // Create and set resource paragraph.
      if (!empty($data['resources']) && isset($resourcedata[$data['resources']])) {
        $resource = $resourcedata[$data['resources']];
        $paragraph = Paragraph::create([
          'type' => 'resources',
          'field_icon' => $resource['icon'],
          'field_label' => $resource['label'],
          'field_link' => [
            'uri' => $resource['url'],
          ],
        ]);
        $paragraph->save();
        $node->field_resources = $paragraph;
      }

      // Create and set social links
      if (!empty($data['social_links'])) {
        $social_links = explode('| ', $data['social_links']);
        if (NULL !== $node->field_social_links) {
          $node->field_social_links->setValue([]);
        }
        foreach ($social_links as $social_link) {
          if (isset($socialdata[$social_link])) {
            $data = $socialdata[$social_link];
            $paragraph = Paragraph::create([
              'type' => 'social_links',
              'field_type' => $data['type'],
              'field_link' => [
                'uri' => $data['url'],
              ],
            ]);
            $paragraph->save();
            $node->field_social_links->appendItem($paragraph);
          }
        }
      }

      // Create (if not pre-existing) and set image.
      if (!empty($data['image_path'])) {
        $prior_image = $this->checkMediaId($data['image_d7id']);
        if ($prior_image == NULL) {
          $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $data['image_path']);
          $file_data = file_get_contents($remote_file);
          // Fixes for irregular paths.
          $local_destination = str_replace('legacy/police/graphics', '', $data['image_path']);
          $local_destination = str_replace('default_images', '', $local_destination);
          $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
          $local_destination = str_replace('public://', '', $local_destination);
          $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
          $image_department = [$this->taxonomyImportTasks->newTid($data['image_department'], 'department')];

          $image = Media::create([
            'bundle' => 'image',
            'uid' => 0,
            'field_media_image' => [
              'target_id' => $local_file->id(),
              'alt' => $data['image_alt']
            ],
            'field_d7_mid' => $data['image_d7id'],
          ]);
          if (!empty($data['image_license'])) {
            $image->field_license = $data['image_license'];
          }
          foreach ($image_department as $department) {
            $image->field_department->appendItem([
              'target_id' => $department,
            ]);
          }
          $image->save();
        }
        else {
          $image = Media::load($prior_image);
        }
        $node->field_image = $image;
      }
      // Create (if not pre-existing) and set image.
      if (!empty($data['featured_image_path']) && strpos('youtube://', $data['featured_image_path']) < 0) {
        // TODO: Youtube?
        $prior_image = $this->checkMediaId($data['featured_image_d7id']);
        if ($prior_image == NULL) {
          $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $data['featured_image_path']);
          $file_data = file_get_contents($remote_file);
          // Fixes for irregular paths.
          $local_destination = str_replace('legacy/police/graphics', '', $data['featured_image_path']);
          $local_destination = str_replace('default_images', '', $local_destination);
          $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
          $local_destination = str_replace('public://', '', $local_destination);
          $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
          $image_department = [$this->taxonomyImportTasks->newTid($data['featured_image_department'], 'department')];

          $image = Media::create([
            'bundle' => 'image',
            'uid' => 0,
            'field_media_image' => [
              'target_id' => $local_file->id(),
              'alt' => $data['featured_image_alt']
            ],
            'field_d7_mid' => $data['featured_image_d7id'],
          ]);
          if (!empty($data['featured_image_license'])) {
            $image->field_license = $data['featured_image_license'];
          }
          foreach ($image_department as $department) {
            $image->field_department->appendItem([
              'target_id' => $department,
            ]);
          }
          $image->save();
        }
        else {
          $image = Media::load($prior_image);
        }
        $node->field_feature_video_img = $image;
      }
      // Set three taxonomies.
      $node->field_department->setValue([]);
      foreach (explode(' |', $data['department']) as $department) {
        $term = Term::load($this->taxonomyImportTasks->newTid($department, 'department'));
        $node->field_department->appendItem($term);
      }
      $node->field_category->setValue([]);
      foreach (explode('|', $data['category']) as $category) {
        $term = Term::load($this->taxonomyImportTasks->newTid($category, 'categories'));
        $node->field_category->appendItem($term);
      }
      $node->field_search_keymatch->setValue([]);
      foreach (explode('|', $data['search_keymatch']) as $search_keymatch) {
        $term = Term::load($this->taxonomyImportTasks->newTid($search_keymatch, 'search_keymatch'));
        $node->field_search_keymatch->appendItem($term);
      }

      $node->save();
    }
  }

  /**
   * Deletes all image media.
   *
   * @command import:delete-images
   *
   * @usage import:delete-images
   */
  public function deleteImages() {
    $query = $this->entityTypeManager
      ->getStorage('media')
      ->getQuery();
    $query->condition('bundle', 'image');
    $images = $query->execute();
    foreach ($images as $image) {
      $media = Media::load($image);
      $media->delete();
    }
  }

  /**
   * Checks if image media was already imported; returns media id if it was.
   */
  public function checkMediaId($d7id) {
    $query = $this->entityTypeManager
      ->getStorage('media')
      ->getQuery();
    $query->condition('bundle', 'image')
      ->condition('field_d7_mid', $d7id);
    $image_id = $query->execute();
    if (count($image_id) == 1) {
      return reset($image_id);
    }
    else {
      return NULL;
    }
  }
}
