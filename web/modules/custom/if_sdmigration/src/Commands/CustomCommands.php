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
   * Import fields: field_bucket, field_events_programs_initiative, field_featured_items, field_feature_video_img, field_resources, field_search_keymatch
   *
   * @command import:bucket
   *
   * @usage import:bucket
   */
  public function finalizeBucket() {
    $nodedata = [];
    $resourcedata = [];
    $eventpidata = [];
    $featured_items = [];
    $featured_cards = [];
    $cards = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/buckets.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'path' => str_replace('`', '', $data[1]),
          'resources' => str_replace('`', '', $data[15]),
          'search_keymatch' => str_replace('`', '', $data[16]),
          'image_department' => str_replace('`', '', $data[6]),
          'image_license' => str_replace('`', '', $data[7]),
          'image_alt' => str_replace('`', '', $data[8]),
          'image_d7id' => str_replace('`', '', $data[9]),
          'image_path' => str_replace('`', '', $data[10]),
          'bucket' => str_replace('`', '', $data[4]),
          'featured_cards' => str_replace('`', '', $data[11]),
          'event_pi_items' => str_replace('`', '', $data[13]),
          'featured_items' => str_replace('`', '', $data[15]),
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

    // Events PI field collection.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_bucket_events_pi_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $eventpidata[$id] = [
          'image_department' => str_replace('`', '', $data[1]),
          'image_license' => str_replace('`', '', $data[2]),
          'image_alt' => str_replace('`', '', $data[3]),
          'image_d7id' => str_replace('`', '', $data[4]),
          'image_path' => str_replace('`', '', $data[5]),
          'label' => str_replace('`', '', $data[6]),
          'url' => str_replace('`', '', $data[7]),
        ];
      }
      fclose($file);
    }

    // Featured items field collection.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_bucket_featured_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $featured_items[$id] = [
          'label' => str_replace('`', '', $data[1]),
          'url' => str_replace('`', '', $data[2]),
          'image_department' => str_replace('`', '', $data[3]),
          'image_license' => str_replace('`', '', $data[4]),
          'image_alt' => str_replace('`', '', $data[5]),
          'image_d7id' => str_replace('`', '', $data[6]),
          'image_path' => str_replace('`', '', $data[7]),
        ];
      }
      fclose($file);
    }

    // Featured cards field collection.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_bucket_featured_cards_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $featured_cards[$id] = [
          'title' => str_replace('`', '', $data[1]),
          'url' => str_replace('`', '', $data[2]),
          'cards' => str_replace('`', '', $data[3]),
        ];
      }
      fclose($file);
    }

    // Cards field collection.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_featured_cards_card.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $cards[$id] = [
          'image_department' => str_replace('`', '', $data[1]),
          'image_license' => str_replace('`', '', $data[2]),
          'image_alt' => str_replace('`', '', $data[3]),
          'image_d7id' => str_replace('`', '', $data[4]),
          'image_path' => str_replace('`', '', $data[5]),
          'description' => str_replace('`', '', $data[6]),
          'label' => str_replace('`', '', $data[7]),
          'url' => str_replace('`', '', $data[8]),
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
      $query->condition('type', 'bucket')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      // Set alias.
      $node->path = [
        'alias' => $data['path'],
        'pathauto' => PathautoState::SKIP,
      ];

      // Create and set resource paragraphs.
      $resources = explode('|', $data['resources']);
      $node->field_resources = [];
      foreach ($resources as $resource) {
        if (strpos($resourcedata[$resource]['url'], 'http') > -1) {
          $url = $resourcedata[$resource]['url'];
        }
        else {
          $url = 'https://www.sandiego.gov' . $resourcedata[$resource]['url'];
        }
        $paragraph = Paragraph::create([
          'type' => 'resources',
          'field_icon' => $resourcedata[$resource]['icon'],
          'field_label' => $resourcedata[$resource]['label'],
          'field_link' => [
            'uri' => $url,
          ],
        ]);
        $paragraph->save();
        $node->field_resources[] = $paragraph;
      }

      // Create and set featured card paragraphs.
      $node->field_featured_card = [];
      $items = explode('|', $data['featured_cards']);
      foreach ($items as $item) {
        if (strpos($featured_cards[$item]['url'], 'http') > -1) {
          $url = $featured_cards[$item]['url'];
        }
        else {
          $url = 'https://www.sandiego.gov' . $featured_cards[$item]['url'];
        }
        $paragraph = Paragraph::create([
          'type' => 'featured_cards',
          'field_section_title' => $featured_cards[$item]['label'],
          'field_link' => [
            'uri' => $url,
          ],
        ]);
        $paragraph->save();
        // Cards
        $card_ids = explode('|', $featured_cards[$item]['cards']);
        foreach ($card_ids as $card) {
          if (strpos($cards[$card]['url'], 'http') > -1) {
            $url = $cards[$card]['url'];
          }
          else {
            $url = 'https://www.sandiego.gov' . $cards[$card]['url'];
          }
          if (!empty($cards[$card]['image_path'])) {
            $prior_image = $this->checkMediaId($cards[$card]['image_d7id']);
            if ($prior_image == NULL) {
              $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $cards[$card]['image_path']);
              $file_data = file_get_contents($remote_file);
              // Fixes for irregular paths.
              $local_destination = str_replace('legacy/police/graphics', '', $cards[$card]['image_path']);
              $local_destination = str_replace('default_images', '', $local_destination);
              $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
              $local_destination = str_replace('public://', '', $local_destination);
              $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
              $image_department = [$this->taxonomyImportTasks->newTid($cards[$card]['image_department'], 'department')];

              $image = Media::create([
                'bundle' => 'image',
                'uid' => 0,
                'field_media_image' => [
                  'target_id' => $local_file->id(),
                  'alt' => $cards[$card]['image_alt']
                ],
                'field_d7_mid' => $cards[$card]['image_d7id'],
              ]);
              if (!empty($cards[$card]['image_license'])) {
                $image->field_license = $cards[$card]['image_license'];
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
          }
          else {
            $image = NULL;
          }
          $card_paragraph = Paragraph::create([
            'type' => 'card',
            'field_description' => $cards[$card]['description'],
            'field_label' => $cards[$card]['label'],
            'field_link' => [
              'uri' => $url,
            ],
            'field_image' => $image,
          ]);
          $card_paragraph->save();
          $paragraph->field_cards->appendItem($card_paragraph);
        }
        $paragraph->save();
        $node->field_featured_card[] = $paragraph;
      }

      // Create and set featured item paragraphs.
      $node->field_featured_items = [];
      $items = explode('|', $data['featured_items']);
      foreach ($items as $item) {
        if (strpos($featured_items[$item]['url'], 'http') > -1) {
          $url = $featured_cards[$item]['url'];
        }
        else {
          $url = 'https://www.sandiego.gov' . $featured_cards[$item]['url'];
        }
        if (!empty($featured_items[$item]['image_path'])) {
          $prior_image = $this->checkMediaId($featured_items[$item]['image_d7id']);
          if ($prior_image == NULL) {
            $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $featured_items[$item]['image_path']);
            $file_data = file_get_contents($remote_file);
            // Fixes for irregular paths.
            $local_destination = str_replace('legacy/police/graphics', '', $featured_items[$item]['image_path']);
            $local_destination = str_replace('default_images', '', $local_destination);
            $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
            $local_destination = str_replace('public://', '', $local_destination);
            $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
            $image_department = [$this->taxonomyImportTasks->newTid($featured_items[$item]['image_department'], 'department')];

            $image = Media::create([
              'bundle' => 'image',
              'uid' => 0,
              'field_media_image' => [
                'target_id' => $local_file->id(),
                'alt' => $featured_items[$item]['image_alt']
              ],
              'field_d7_mid' => $featured_items[$item]['image_d7id'],
            ]);
            if (!empty($featured_items[$item]['image_license'])) {
              $image->field_license = $featured_items[$item]['image_license'];
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
        }
        else {
          $image = NULL;
        }
        $paragraph = Paragraph::create([
          'type' => 'featured_item',
          'field_label' => $featured_items[$item]['label'],
          'field_link' => [
            'uri' => $url,
          ],
          'field_image' => $image,
        ]);
        $paragraph->save();
        $node->field_featured_items[] = $paragraph;
      }

      // Create and set events pi paragraphs.
      $node->field_events_programs_initiative = [];
      $items = explode('|', $data['event_pi_items']);
      foreach ($items as $item) {
        if (strpos($featured_items[$item]['url'], 'http') > -1) {
          $url = $featured_cards[$item]['url'];
        }
        else {
          $url = 'https://www.sandiego.gov' . $featured_cards[$item]['url'];
        }
        if (!empty($featured_items[$item]['image_path'])) {
          $prior_image = $this->checkMediaId($featured_items[$item]['image_d7id']);
          if ($prior_image == NULL) {
            $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $featured_items[$item]['image_path']);
            $file_data = file_get_contents($remote_file);
            // Fixes for irregular paths.
            $local_destination = str_replace('legacy/police/graphics', '', $featured_items[$item]['image_path']);
            $local_destination = str_replace('default_images', '', $local_destination);
            $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
            $local_destination = str_replace('public://', '', $local_destination);
            $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
            $image_department = [$this->taxonomyImportTasks->newTid($featured_items[$item]['image_department'], 'department')];

            $image = Media::create([
              'bundle' => 'image',
              'uid' => 0,
              'field_media_image' => [
                'target_id' => $local_file->id(),
                'alt' => $featured_items[$item]['image_alt']
              ],
              'field_d7_mid' => $featured_items[$item]['image_d7id'],
            ]);
            if (!empty($featured_items[$item]['image_license'])) {
              $image->field_license = $featured_items[$item]['image_license'];
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
        }
        else {
          $image = NULL;
        }
        $paragraph = Paragraph::create([
          'type' => 'featured_item',
          'field_label' => $featured_items[$item]['label'],
          'field_link' => [
            'uri' => $url,
          ],
          'field_image' => $image,
        ]);
        $paragraph->save();
        $node->field_events_programs_initiative[] = $paragraph;
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
        $node->field_feature_video_img = $image;
      }

      // Set taxonomy fields.
      $node->field_search_keymatch->setValue([]);
      foreach (explode('|', $data['search_keymatch']) as $search_keymatch) {
        $term = Term::load($this->taxonomyImportTasks->newTid($search_keymatch, 'search_keymatch'));
        $node->field_search_keymatch->appendItem($term);
      }

      $term = Term::load($this->taxonomyImportTasks->newTid($data['bucket'], 'bucket'));
      $node->field_bucket = $term;


      $node->save();
    }
  }

  /**
   * Import fields:
   * field_address, field_amenities, field_location_bucket, field_department,
   * field_exceptions, field_location_hours, field_location_location_type,
   * field_resources, field_restrictions, field_search_keymatch,
   * field_exceptions_2, field_location_hours2.
   *
   * @command import:location
   *
   * @usage import:location
   */
  public function finalizeLocation() {
    $nodedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/locations.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'path' => str_replace('`', '', $data[1]),
          'street' => str_replace('`', '', $data[3]),
          'additional' => str_replace('`', '', $data[4]),
          'city' => str_replace('`', '', $data[5]),
          'name' => str_replace('`', '', $data[8]),
          'postal_code' => str_replace('`', '', $data[9]),
          'province' => str_replace('`', '', $data[10]),
          'amenities' => explode('|', str_replace('`', '', $data[13])),
          'bucket' => str_replace('`', '', $data[15]),
          'department' => explode('|', str_replace('`', '', $data[18])),
          'secondary_exceptions' => explode('|', str_replace('`', '', $data[20])),
          'hours' => explode(' \ ', str_replace('`', '', $data[23])),
          'location_type' => str_replace('`', '', $data[25]),
          'resources' => explode('|', str_replace('`', '', $data[29])),
          'restrictions' => explode('|', str_replace('`', '', $data[30])),
          'secondary_hours' => explode(' \ ', str_replace('`', '', $data[31])),
          'search_keymatch' => explode('|', str_replace('`', '', $data[36])),
          'exceptions' => explode(' |', str_replace('`', '', $data[38])),
        ];
      }
      fclose($file);
    }

    // Load amenities_restrictions data.
    $ardata = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_location_amenities_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $ardata[$id] = [
          'description' => str_replace('`', '', $data[1]),
          'icon' => str_replace('`', '', $data[2]),
          'title' => str_replace('`', '', $data[3]),
        ];
      }
      fclose($file);
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_location_restrictions_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $ardata[$id] = [
          'description' => str_replace('`', '', $data[1]),
          'icon' => str_replace('`', '', $data[2]),
          'title' => str_replace('`', '', $data[3]),
        ];
      }
      fclose($file);
    }

    $resourcedata = [];
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

    // Exceptions + Secondary exceptions
    $exceptions = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_location_exceptions_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $exceptions[$id] = explode('|', str_replace('`', '', $data[1]));
      }
      fclose($file);
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_location_exceptions_coll2.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $exceptions[$id] = explode('|', str_replace('`', '', $data[1]));
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'location')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      // Set alias.
      $node->path = [
        'alias' => $data['path'],
        'pathauto' => PathautoState::SKIP,
      ];

      // Set address.
      $node->field_address = [
        'country_code' => 'US',
        'address_line1' => $data['street'],
        'address_line2' => $data['additional'],
        'locality' => $data['city'],
        'administrative_area' => 'CA',
        'postal_code' => str_pad($data['postal_code'], 5, '0', STR_PAD_LEFT),
      ];

      // Set hours.
      $hours = [];
      foreach ($data['hours'] as $hour_row) {
        $hour_row = explode(';', $hour_row);
        $day = $hour_row[0];
        $hour_row = explode('~', $hour_row[1]);
        $starthours = str_replace(':', '', $hour_row[0]);
        $endhours = str_replace(':', '', $hour_row[1]);
        $hours[] = [
          'day' => $day,
          'starthours' => $starthours,
          'endhours' => $endhours,
          'comment' => '',
        ];
      }
      $secondary_hours = [];
      foreach ($data['secondary_hours'] as $hour_row) {
        $hour_row = explode(';', $hour_row);
        $day = $hour_row[0];
        $hour_row = explode('~', $hour_row[1]);
        $starthours = str_replace(':', '', $hour_row[0]);
        $endhours = str_replace(':', '', $hour_row[1]);
        $secondary_hours[] = [
          'day' => $day,
          'starthours' => $starthours,
          'endhours' => $endhours,
          'comment' => '',
        ];
      }
      $node->field_location_hours = $hours;
      $node->field_location_hours2 = $secondary_hours;

      $node->field_restrictions = [];
      foreach ($data['restrictions'] as $restriction) {
        $paragraph = Paragraph::create([
          'type' => 'amenities_restrictions',
          'field_description' => $ardata[$restriction]['description'],
          'field_icon' => $ardata[$restriction]['icon'],
          'field_title' => $ardata[$restriction]['title'],
        ]);
        $paragraph->save();
        $node->field_restrictions[] = $paragraph;
      }

      $node->field_amenities = [];
      foreach ($data['amenities'] as $amenity) {
        $paragraph = Paragraph::create([
          'type' => 'amenities_restrictions',
          'field_description' => $ardata[$amenity]['description'],
          'field_icon' => $ardata[$amenity]['icon'],
          'field_title' => $ardata[$amenity]['title'],
        ]);
        $paragraph->save();
        $node->field_amenities[] = $paragraph;
      }

      $node->field_resources = [];
      foreach ($data['resources'] as $resource) {
        $paragraph = Paragraph::create([
          'type' => 'resources',
          'field_icon' => $resourcedata[$resource]['icon'],
          'field_label' => $resourcedata[$resource]['label'],
          'field_link' => [
            'uri' => $resourcedata[$resource]['url'],
          ],
        ]);
        $paragraph->save();
        $node->field_resources[] = $paragraph;
      }

      $node->field_department->setValue([]);
      foreach ($data['department'] as $department) {
        $term = Term::load($this->taxonomyImportTasks->newTid($department, 'department'));
        $node->field_department->appendItem($term);
      }

      $node->field_search_keymatch->setValue([]);
      foreach ($data['search_keymatch'] as $search_keymatch) {
        $term = Term::load($this->taxonomyImportTasks->newTid($search_keymatch, 'search_keymatch'));
        $node->field_search_keymatch->appendItem($term);
      }

      $term = Term::load($this->taxonomyImportTasks->newTid($data['bucket'], 'bucket'));
      $node->field_location_bucket = $term;

      $term = Term::load($this->taxonomyImportTasks->newTid($data['location_type'], 'location'));
      $node->field_location_location_type = $term;

      $node->field_exceptions = [];
      foreach ($data['exceptions'] as $exception) {
        if (!empty($exception)) {
          $times = $exceptions[$exception];
          foreach ($times as $time) {
            if (strpos($time, ' to ') !== FALSE) {
              $timerange = explode(' to ', $time);
              $value = strtotime($timerange[0]);
              $end_value = strtotime($timerange[1]);
            }
            else {
              $value = strtotime($time);
              $end_value = NULL;
            }
            $node->field_exceptions[] = [
              'value' => $value,
              'end_value' => $end_value,
            ];
          }
        }
      }

      $node->field_exceptions2 = [];
      foreach ($data['secondary_exceptions'] as $exception) {
        if (!empty($exception)) {
          $times = $exceptions[$exception];
          foreach ($times as $time) {
            if (strpos($time, ' to ') !== FALSE) {
              $timerange = explode(' to ', $time);
              $value = strtotime($timerange[0]);
              $end_value = strtotime($timerange[1]);
            }
            else {
              $value = strtotime($time);
              $end_value = NULL;
            }
            $node->field_exceptions2[] = [
              'value' => $value,
              'end_value' => $end_value,
            ];
          }
        }
      }

      $node->save();
    }
  }

  /**
   * Import fields:
   * field_image, field_category, field_search_keymatch
   *
   * @command import:mayoral-artifact
   *
   * @usage import:mayoral-artifact
   */
  public function finalizeMA() {
    $nodedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/mayoral-artifacts.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'category' => str_replace('`', '', $data[2]),
          'search_keymatch' => str_replace('`', '', $data[3]),
          'image_department' => str_replace('`', '', $data[4]),
          'image_license' => str_replace('`', '', $data[5]),
          'image_alt' => str_replace('`', '', $data[6]),
          'image_d7id' => str_replace('`', '', $data[7]),
          'image_path' => str_replace('`', '', $data[8]),
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
      $query->condition('type', 'mayoral_artifacts')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

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
          $local_destination = str_replace('mayoral-artifacts', '', $local_destination);
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

      $node->field_category = [];
      if (!empty($data['category'])) {
        foreach ($data['category'] as $category) {
          $term = Term::load($this->taxonomyImportTasks->newTid($category, 'categories'));
          $node->field_category->appendItem($term);
        }
      }

      $node->field_search_keymatch = [];
      if (!empty($data['search_keymatch'])) {
        foreach ($data['search_keymatch'] as $search_keymatch) {
          $term = Term::load($this->taxonomyImportTasks->newTid($search_keymatch, 'search_keymatch'));
          $node->field_search_keymatch->appendItem($term);
        }
      }
      $node->save();
    }
  }

  /**
   * Manual department node content fixes.
   *
   * @command import:department-fixes
   *
   * @usage import:department-fixes
   *
   */
  public function departmentFixes() {
    // Load nodes.
    $query = $this->entityTypeManager
      ->getStorage('node')
      ->getQuery();
    $query->condition('type', 'department');
    $nids = $query->execute();
    foreach ($nids as $id) {
      \Drupal::service('entity.memory_cache')->deleteAll();
      $node = Node::load($id);
      $sidebar_html = $node->field_sidebar->value;
      if (strpos($sidebar_html, 'src="/modules/file/icons/application-pdf.png"') !== FALSE) {
        echo $node->id(). PHP_EOL;
        $sidebar_html = str_replace('src="/modules/file/icons/application-pdf.png"', 'src="/core/themes/classy/images/icons/application-pdf.png"', $sidebar_html);
        $node->field_sidebar->value = $sidebar_html;
        $node->save();
      }
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

  /**
   * Delete all nodes of type.
   *
   * @command delete:nodes
   * @param $content_type (Content type to delete).
   *
   * @usage delete:nodes
   */
  public function deleteNodes($content_type) {
    $query = $this->entityTypeManager
      ->getStorage('node')
      ->getQuery();
    $query->condition('type', $content_type);
    $nids = $query->execute();
    foreach ($nids as $nid) {
      $node = Node::load($nid);
      $node->delete();
    }
  }
}
