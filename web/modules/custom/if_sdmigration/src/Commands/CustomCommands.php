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
use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\redirect\Entity\Redirect;
use Drupal\system\Entity\Menu;
use Drupal\taxonomy\Entity\Term;
use Drupal\user\Entity\User;
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
   *
   * @command import:registration
   * @param $after_id (Node ID to resume after).
   *
   * @usage import:registration
   */
  public function finalizeRegistration($after_id = 0) {
    $nodedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/registration.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'display_to' => explode('|', str_replace('`', '', $data[4])),
          'event_location' => str_replace('`', '', $data[5]),
          'updated' => str_replace('`', '', $data[8]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      if ($d7id < $after_id) continue;
      echo 'Current memory used: ' . $this->memoryUsage(memory_get_usage(true)) . '| Current D7 ID: ' . $d7id . PHP_EOL;
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'registration')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);
      if ($data['event_location'] == 4256) {
        $event_location = 5069;
      }
      elseif ($data['event_location'] == 4257) {
        $event_location = 5068;
      }
      else {
        $event_location = NULL;
      }
      $term = Term::load($event_location);
      $node->field_reg_event_location->setValue([]);
      $node->field_reg_event_location->appendItem($term);
      $node->set('changed', strtotime($data['updated']));
      $node->set('field_reg_display_to_role', $data['display_to']);
      $node->save();
    }
  }

  /**
   *
   * @command import:business_resource
   * @param $after_id (Node ID to resume after).
   *
   * @usage import:business_resource
   */
  public function finalizeBusinessResource($after_id = 0) {
    $nodedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/business-resource.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'organization' => explode('|', str_replace('`', '', $data[3])),
          'target_business' => explode('|', str_replace('`', '', $data[8])),
          'type_of_assistance' => explode('|', str_replace('`', '', $data[9])),
          'updated' => str_replace('`', '', $data[11]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      if ($d7id < $after_id) continue;
      echo 'Current memory used: ' . $this->memoryUsage(memory_get_usage(true)) . '| Current D7 ID: ' . $d7id . PHP_EOL;
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'business_resource')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      // Set three taxonomies.
      $node->field_business_organization->setValue([]);
      foreach ($data['organization'] as $organization) {
        $term = Term::load($this->taxonomyImportTasks->newTid($organization, 'business_resources_organization'));
        $node->field_business_organization->appendItem($term);
      }
      $node->field_business_target_business->setValue([]);
      foreach ($data['target_business'] as $target_business) {
        $term = Term::load($this->taxonomyImportTasks->newTid($target_business, 'business_resources_target_bus'));
        $node->field_business_target_business->appendItem($term);
      }
      $node->field_business_typeof_assistance->setValue([]);
      foreach ($data['type_of_assistance'] as $type_of_assistance) {
        $term = Term::load($this->taxonomyImportTasks->newTid($type_of_assistance, 'business_resources_type_assist'));
        $node->field_business_typeof_assistance->appendItem($term);
      }
      $node->set('changed', strtotime($data['updated']));
      $node->save();
    }
  }

  /**
   * Import fields: field_search_keymatch, field_image, field_category, field_department
   *
   * @command import:outreach2_article
   * @param $after_id (Node ID to resume after).
   *
   * @usage import:outreach2_article
   */
  public function finalizeOutreach2Article($after_id = 0) {
    $nodedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/outreach2-article.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'department' => str_replace('`', '', $data[1]),
          'category' => str_replace('`', '', $data[2]),
          'search_keymatch' => str_replace('`', '', $data[3]),
          'image_department' => str_replace('`', '', $data[11]),
          'image_license' => str_replace('`', '', $data[12]),
          'image_alt' => str_replace('`', '', $data[13]),
          'image_d7id' => str_replace('`', '', $data[14]),
          'image_path' => str_replace('`', '', $data[15]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      if ($d7id < $after_id) continue;
      echo 'Current memory used: ' . $this->memoryUsage(memory_get_usage(true)) . '| Current D7 ID: ' . $d7id . PHP_EOL;
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'outreach_article2')
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
          $local_destination = str_replace('public://', '', $local_destination);
          $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
          $image_department = [$this->taxonomyImportTasks->newTid($data['image_department'], 'department')];
          if (is_object($local_file)) {
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
            echo 'Image saved.' . PHP_EOL;
          }
          else {
            $image = NULL;
          }
        }
        else {
          $image = Media::load($prior_image);
          echo 'Image re-used.' . PHP_EOL;
        }
        $node->field_image = $image;
      }
      // Set three taxonomies.
      $node->field_department->setValue([]);
      foreach (explode('|', $data['department']) as $department) {
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
   * Import fields: field_resources, field_search_keymatch, field_image, field_category, field_department, path
   *
   * @command import:department
   * @param $after_id (Node ID to resume after).
   *
   * @usage import:department
   */
  public function finalizeDepartment($after_id = 0) {
    $nodedata = [];
    $resourcedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/departments.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'resources' => str_replace('`', '', $data[6]),
          'department' => str_replace('`', '', $data[7]),
          'category' => str_replace('`', '', $data[9]),
          'search_keymatch' => str_replace('`', '', $data[15]),
          'image_department' => str_replace('`', '', $data[16]),
          'image_license' => str_replace('`', '', $data[17]),
          'image_alt' => str_replace('`', '', $data[18]),
          'image_d7id' => str_replace('`', '', $data[19]),
          'image_path' => str_replace('`', '', $data[20]),
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
      if ($d7id < $after_id) continue;
      echo 'Current memory used: ' . $this->memoryUsage(memory_get_usage(true)) . '| Current D7 ID: ' . $d7id . PHP_EOL;
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'department')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);


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
          if (is_object($local_file)) {
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
            echo 'Image saved.' . PHP_EOL;
          }
          else {
            $image = NULL;
          }
        }
        else {
          $image = Media::load($prior_image);
          echo 'Image re-used.' . PHP_EOL;
        }
        $node->field_image = $image;
      }
      // Set three taxonomies.
      $node->field_department->setValue([]);
      foreach (explode('|', $data['department']) as $department) {
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
          'resources' => str_replace('`', '', $data[1]),
          'department' => explode('|', str_replace('`', '', $data[2])),
          'category' => explode('|', str_replace('`', '', $data[3])),
          'search_keymatch' => explode('|', str_replace('`', '', $data[4])),
          'image_department' => str_replace('`', '', $data[5]),
          'image_license' => str_replace('`', '', $data[6]),
          'image_alt' => str_replace('`', '', $data[7]),
          'image_d7id' => str_replace('`', '', $data[8]),
          'image_path' => str_replace('`', '', $data[9]),
          'social_links' => str_replace('`', '', $data[14]),
          'featured_image_department' => str_replace('`', '', $data[15]),
          'featured_image_license' => str_replace('`', '', $data[16]),
          'featured_image_alt' => str_replace('`', '', $data[17]),
          'featured_image_d7id' => str_replace('`', '', $data[18]),
          'featured_image_path' => str_replace('`', '', $data[19]),
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
        $image = NULL;
        if (str_starts_with($data['image_path'], 'youtube://')) {
          $youtube = str_replace('youtube://v/', 'https://www.youtube.com/watch?v=', $data['image_path']);
          $image = Media::create([
            'bundle' => 'remote_video',
            'uid' => 0,
            'field_media_oembed_video' => $youtube,
          ]);
          $image->save();
        }
        else {
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
        }
        $node->field_image = $image;
      }
      // Create (if not pre-existing) and set image.
      if (!empty($data['featured_image_path'])) {
        $image = NULL;
        if (str_starts_with($data['featured_image_path'], 'youtube://')) {
          $youtube = str_replace('youtube://v/', 'https://www.youtube.com/watch?v=', $data['featured_image_path']);
          $image = Media::create([
            'bundle' => 'remote_video',
            'uid' => 0,
            'field_media_oembed_video' => $youtube,
          ]);
          $image->save();
        }
        else {
          $prior_image = $this->checkMediaId($data['featured_image_d7id']);
          if ($prior_image == NULL) {
            $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $data['featured_image_path']);
            $file_data = file_get_contents($remote_file);
            // Fixes for irregular paths.
            $local_destination = str_replace('legacy/police/graphics', '', $data['featured_image_path']);
            $local_destination = str_replace('legacy/humanresources/graphics', '', $local_destination);
            $local_destination = str_replace('legacy/riskmanagement/graphics', '', $local_destination);
            $local_destination = str_replace('legacy/empopp/graphics', '', $local_destination);
            $local_destination = str_replace('legacy/petcopark/graphics', '', $local_destination);
            $local_destination = str_replace('legacy/planning-commission/graphics', '', $local_destination);
            $local_destination = str_replace('default_images', '', $local_destination);
            $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
            $local_destination = str_replace('legacy/parkandrecboard/graphics', '', $local_destination);
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
        }
        $node->field_feature_video_img = $image;
      }
      // Set three taxonomies.
      $node->field_department->setValue([]);
      if (!empty($data['department'])) {
        foreach ($data['department'] as $department) {
          $term = Term::load($this->taxonomyImportTasks->newTid($department, 'department'));
          $node->field_department->appendItem($term);
        }
      }
      $node->field_category->setValue([]);
      if (!empty($data['category'])) {
        foreach ($data['category'] as $category) {
          $term = Term::load($this->taxonomyImportTasks->newTid($category, 'categories'));
          $node->field_category->appendItem($term);
        }
      }
      $node->field_search_keymatch->setValue([]);
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
    $exceptions2 = [];
    $nodedata_exceptions = [];
    $nodedata_exceptions2 = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_data_field_location_exceptions_coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $entity_id = str_replace('"', '', $data[3]);
        $delta = str_replace('"', '', $data[6]);
        $field_collection_id = str_replace('"', '', $data[7]);
        $exceptions[$field_collection_id] = [
          'entity_id' => $entity_id,
          'delta' => $delta,
        ];
      }
      fclose($file);
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_data_field_location_exceptions_coll2.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $entity_id = str_replace('"', '', $data[3]);
        $delta = str_replace('"', '', $data[6]);
        $field_collection_id = str_replace('"', '', $data[7]);
        $exceptions2[$field_collection_id] = [
          'entity_id' => $entity_id,
          'delta' => $delta,
        ];
      }
      fclose($file);
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_data_field_office_exception_date.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $field_collection_id = str_replace('"', '', $data[3]);
        if (array_key_exists($field_collection_id, $exceptions)) {
          $extra_data = explode(';', str_replace('"', '', $data[9]));
          if (array_key_exists(1, $extra_data)) {
            $recur_interval = str_replace('RRULE:FREQ=', '', $extra_data[0]);
            $recur_number = str_replace('INTERVAL=', '', $extra_data[1]);
            $nodedata_exceptions[$exceptions[$field_collection_id]['entity_id']][$exceptions[$field_collection_id]['delta']] = [
              'start' => str_replace('"', '', $data[7]),
              'end' => str_replace('"', '', $data[8]),
              'recur_number' => $recur_number,
              'recur_interval' => $recur_interval,
            ];
          }
        }
      }
      fclose($file);
      if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field_data_field_office_exception_date2.csv', 'r')) {
        fgets($file);
        while ($data = fgetcsv($file)) {
          $field_collection_id = str_replace('"', '', $data[3]);
          if (array_key_exists($field_collection_id, $exceptions2)) {
            $extra_data = explode(';', str_replace('"', '', $data[9]));
            if (array_key_exists(1, $extra_data)) {
              $recur_interval = str_replace('RRULE:FREQ=', '', $extra_data[0]);
              $recur_number = str_replace('INTERVAL=', '', $extra_data[1]);
              $nodedata_exceptions2[$exceptions2[$field_collection_id]['entity_id']][$exceptions2[$field_collection_id]['delta']] = [
                'start' => str_replace('"', '', $data[7]),
                'end' => str_replace('"', '', $data[8]),
                'recur_number' => $recur_number,
                'recur_interval' => $recur_interval,
              ];
            }
          }
        }
        fclose($file);
      }
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
        if (array_key_exists(1, $hour_row)) {
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
      }
      $secondary_hours = [];
      foreach ($data['secondary_hours'] as $hour_row) {
        $hour_row = explode(';', $hour_row);
        if (array_key_exists(1, $hour_row)) {
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
      }
      $node->field_location_hours = $hours;
      $node->field_location_hours2 = $secondary_hours;

      $node->field_restrictions = [];
      foreach ($data['restrictions'] as $restriction) {
        if (array_key_exists($restriction, $ardata)) {
          $paragraph = Paragraph::create([
            'type' => 'amenities_restrictions',
            'field_description' => $ardata[$restriction]['description'],
            'field_icon' => $ardata[$restriction]['icon'],
            'field_title' => $ardata[$restriction]['title'],
          ]);
          $paragraph->save();
          $node->field_restrictions[] = $paragraph;
        }
      }

      $node->field_amenities = [];
      foreach ($data['amenities'] as $amenity) {
        if (array_key_exists($amenity, $ardata)) {
          $paragraph = Paragraph::create([
            'type' => 'amenities_restrictions',
            'field_amend_restrict_description' => $ardata[$amenity]['description'],
            'field_icon' => $ardata[$amenity]['icon'],
            'field_title' => $ardata[$amenity]['title'],
          ]);
          $paragraph->save();
          $node->field_amenities[] = $paragraph;
        }
      }

      $node->field_resources = [];
      foreach ($data['resources'] as $resource) {
        if (array_key_exists($resource, $resourcedata)) {
          if ($resourcedata[$resource]['url'] !== NULL) {
            $uri = $resourcedata[$resource]['url'];
            if (!str_starts_with($uri, 'http') && !str_starts_with($uri, '//')) {
              $uri = 'internal:' . $uri;
            }
            $paragraph = Paragraph::create([
              'type' => 'resources',
              'field_icon' => $resourcedata[$resource]['icon'],
              'field_label' => $resourcedata[$resource]['label'],
              'field_link' => [
                'uri' => $uri,
              ],
            ]);
            $paragraph->save();
            $node->field_resources[] = $paragraph;
          }
        }
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
      $node->field_location_type = $term;

      $node->field_exceptions = [];
      if (array_key_exists($d7id, $nodedata_exceptions)) {
        foreach ($nodedata_exceptions[$d7id] as $exception) {
          $node->field_exceptions[] = [
            'value' => strtotime($exception['start']),
            'end_value' => strtotime($exception['end']),
            'interval' => $exception['recur_number'],
            'repeat' => $exception['recur_interval'],
          ];
        }
      }

      $node->field_exceptions2 = [];
      if (array_key_exists($d7id, $nodedata_exceptions2)) {
        foreach ($nodedata_exceptions2[$d7id] as $exception) {
          $node->field_exceptions2[] = [
            'value' => strtotime($exception['start']),
            'end_value' => strtotime($exception['end']),
            'interval' => $exception['recur_number'],
            'repeat' => $exception['recur_interval'],
          ];
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
   * Finalize outreach node import (field collection).
   *
   * @command import:outreach
   *
   * @usage import:outreach
   */
  public function finalizeOutreach() {
    $nodedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/outreach.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'department' => explode('|', str_replace('`', '', $data[2])),
          'search_keymatch' => explode('|', str_replace('`', '', $data[3])),
          'sections' => explode('|', str_replace('`', '', $data[4])),
        ];
      }
      fclose($file);
    }

    // Load sections data.
    $sectiondata = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field-outreach-sections-coll.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $id = str_replace('`', '', $data[0]);
        $id = str_replace(',', '', $id);
        $sectiondata[$id] = [
          'image_department' => str_replace('`', '', $data[1]),
          'image_license' => str_replace('`', '', $data[2]),
          'image_alt' => str_replace('`', '', $data[3]),
          'image_d7id' => str_replace('`', '', $data[4]),
          'image_path' => str_replace('`', '', $data[5]),
          'body' => str_replace('`', '', $data[6]),
          'minimum_height' => str_replace('`', '', $data[7]),
          'background_color' => str_replace('`', '', $data[8]),
          'centered' => str_replace('`', '', $data[9]),
          'full_width_mobile' => str_replace('`', '', $data[10]),
          'image_scroll_ratio' => str_replace('`', '', $data[11]),
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
      $query->condition('type', 'outreach')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      $node->field_sections->setValue([]);
      foreach ($data['sections'] as $section) {
        if (!empty($sectiondata[$section]['image_path'])) {
          $prior_image = $this->checkMediaId($sectiondata[$section]['image_d7id']);
          if ($prior_image == NULL) {
            $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $sectiondata[$section]['image_path']);
            $file_data = file_get_contents($remote_file);
            // Fixes for irregular paths.
            $local_destination = str_replace('legacy/police/graphics', '', $sectiondata[$section]['image_path']);
            $local_destination = str_replace('default_images', '', $local_destination);
            $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
            $local_destination = str_replace('hero', '', $local_destination);
            $local_destination = str_replace('public://', '', $local_destination);
            $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
            $image_department = [$this->taxonomyImportTasks->newTid($sectiondata[$section]['image_department'], 'department')];

            $image = Media::create([
              'bundle' => 'image',
              'uid' => 0,
              'field_media_image' => [
                'target_id' => $local_file->id(),
                'alt' => $sectiondata[$section]['image_alt']
              ],
              'field_d7_mid' => $sectiondata[$section]['image_d7id'],
            ]);
            if (!empty($sectiondata[$section]['image_license'])) {
              $image->field_license = $sectiondata[$section]['image_license'];
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
        echo '>>' . $section . PHP_EOL;
        $paragraph = Paragraph::create([
          'type' => 'sections',
          'field_bg_color' => $sectiondata[$section]['background_color'],
          'field_body' => [
            'value' => $sectiondata[$section]['body'],
            'format' => 'full_html',
          ],
          'field_centered' => $sectiondata[$section]['centered'],
          'field_image' => $image,
          'field_full_width_mobile' => $sectiondata[$section]['full_width_mobile'],
          'field_image_scroll_ratio' => $sectiondata[$section]['image_scroll_ratio'],
          'field_minimum_height' => $sectiondata[$section]['minimum_height'],
        ]);
        $paragraph->save();
        $node->field_sections->appendItem($paragraph);
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

      $node->save();
      echo $node->id() . PHP_EOL;
    }
  }

  /**
   * Import external data nodes into manageable chunks.
   *
   * @command import:external_data
   * @param $import_file (Data file to work off of).
   * @param $after_id (Node ID to resume after).
   *
   * @usage import:external_data
   */
  public function externalDataImport($import_file = NULL, $after_id = 0) {
    if ($import_file == NULL) {
      echo 'No input file specified.' . PHP_EOL;
    }
    else {
      if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/' . $import_file, 'r')) {
        fgets($file);
        while ($data = fgetcsv($file)) {
          $d7id = str_replace('`', '', $data[0]);
          if ($d7id < $after_id) continue;

          echo 'Current memory used: ' . $this->memoryUsage(memory_get_usage(true)) . '| Current D7 ID: ' . $d7id . ' ';

          // Check if node is already imported.
          $query = $this->entityTypeManager
            ->getStorage('node')
            ->getQuery();
          $query->condition('type', 'external_data')
            ->condition('field_d7_nid', $d7id);
          $nids = $query->execute();
          if (empty($nids)) {

            // Manually fix date fields.
            $field_back_date = str_replace('`', '', $data[5]);
            $field_back_date = str_replace(' 00:00:00', '', $field_back_date);
            $field_doc_date = str_replace('`', '', $data[9]);
            $field_doc_date = str_replace(' 00:00:00', '', $field_doc_date);
            $field_import_date = str_replace('`', '', $data[18]);
            $field_import_date = str_replace(' ', 'T', $field_import_date);
            $field_pn_end_date_date = str_replace('`', '', $data[27]);
            $field_pn_end_date_date = str_replace(' 00:00:00', '', $field_pn_end_date_date);
            $field_r_modify_date = str_replace('`', '', $data[28]);
            $field_r_modify_date = str_replace(' ', 'T', $field_r_modify_date);

            // Search Keymatch taxonomy fields.
            $search_keymatch_tids = explode('|', str_replace('`', '', $data[1]));

            // PDF File attachment.
            $pdf_file = str_replace('`', '', $data[34]);
            if (!empty($pdf_file)) {
              $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $pdf_file);
              $remote_file = str_replace(' ', '%20', $remote_file);
              $file_data = file_get_contents($remote_file);
              // Fixes for irregular paths.
              $local_destination = str_replace('legacy/police/graphics', '', $pdf_file);
              $local_destination = str_replace('default_images', '', $local_destination);
              $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
              $local_destination = str_replace('hero', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy10_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy11_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy12_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy13_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy14_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy15_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy16_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy17_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy18_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy19_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/fy20_pdf/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/reports/memo_pdf', '', $local_destination);
              $local_destination = str_replace('legacy/auditor/pdf', '', $local_destination);
              $local_destination = str_replace('legacy/police/pdf/2012', '', $local_destination);
              $local_destination = str_replace('legacy/police/pdf/2013', '', $local_destination);
              $local_destination = str_replace('legacy/police/pdf/2015', '', $local_destination);
              $local_destination = str_replace('legacy/development-services/pdf/industry/infobulletin', '', $local_destination);
              $local_destination = str_replace('legacy/development-services/pdf/industry/forms', '', $local_destination);
              $local_destination = str_replace('public://', '', $local_destination);
              $local_destination = str_replace(' ', '%20', $local_destination);
              $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
              if (is_object($local_file)) {
                $document = Media::create([
                  'bundle' => 'document',
                  'uid' => 0,
                  'field_media_document' => [
                    'target_id' => $local_file->id(),
                  ],
                ]);
                $document->save();
                if ($document !== NULL) {
                  $pdf_file = ['target_id' => $document->id()];
                }
                else {
                  $pdf_file = NULL;
                }
              }
              else {
                $pdf_file = NULL;
              }
            }
            else {
              $pdf_file = NULL;
            }

            $node = Node::create([
              'type' => 'external_data',
              'title' => substr(str_replace('`', '', $data[2]), 0, 255),
              'field_d7_nid' => $d7id,
              'field_action' => str_replace('`', '', $data[4]),
              'field_a_webc_url' => str_replace('`', '', $data[3]),
              'field_back_date' => $field_back_date,
              'body' => [
                'value' => str_replace('`', '', $data[6]),
                'format' => 'full_html'
              ],
              'field_body_status' => str_replace('`', '', $data[7]),
              'field_committee' => str_replace('`', '', $data[8]),
              'field_doc_date' => $field_doc_date,
              'field_doc_date_num' => str_replace('`', '', $data[10]),
              'field_doc_date_year' => str_replace('`', '', $data[11]),
              'field_doc_num' => str_replace('`', '', $data[12]),
              'field_doc_set' => str_replace('`', '', $data[13]),
              'field_doc_type' => str_replace('`', '', $data[14]),
              'field_document_url' => str_replace('`', '', $data[15]),
              'field_flag_color' => str_replace('`', '', $data[16]),
              'field_flag_text' => str_replace('`', '', $data[17]),
              'field_import_date' => $field_import_date,
              'field_internal_notes' => str_replace('`', '', $data[19]),
              'field_muni_code_chapter' => str_replace('`', '', $data[20]),
              'field_object_name' => str_replace('`', '', $data[21]),
              'field_path' => str_replace('`', '', $data[22]),
              'field_pdf' => $pdf_file,
              'field_pn_category' => str_replace('`', '', $data[23]),
              'field_pn_comm_plan_group' => str_replace('`', '', $data[24]),
              'field_pn_council_district' => str_replace('`', '', $data[25]),
              'field_pn_end_date' => str_replace('`', '', $data[26]),
              'field_pn_end_date_date' => $field_pn_end_date_date,
              'field_r_modify_date' => $field_r_modify_date,
              'field_r_object_id' => str_replace('`', '', $data[29]),
              'field_sort1' => str_replace('`', '', $data[30]),
              'field_source' => str_replace('`', '', $data[31]),
              'field_source_name' => str_replace('`', '', $data[32]),
              'field_validated' => str_replace('`', '', $data[33]),
              'moderation_state' => [
                'target_id' => 'published',
              ],
              'uid' => 0
            ]);
            foreach ($search_keymatch_tids as $search_keymatch) {
              $term = Term::load($this->taxonomyImportTasks->newTid($search_keymatch, 'search_keymatch'));
              $node->field_search_keymatch->appendItem($term);
            }
            $node->save();
            echo '(imported).' . PHP_EOL;
          }
          else {
            echo '(already imported; skipping).' . PHP_EOL;
          }
        }
        fclose($file);
      }
    }
  }

  /**
   * Import redirects (from D7 redirect table dump).
   *
   * @command import:redirect
   * @param $after_id (Redirect ID to resume after).
   *
   * @usage import:redirect
   */
  public function importRedirects($after_id = 0) {
    $previous = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/redirect.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        if ($data[0] < $after_id) continue;
        $source = $data[4];
        $redirect = $data[6];
        if (!str_starts_with($redirect, 'file/')) {
          // ignore direct file redirects
          // now convert to D9 node ID
          if (str_starts_with($redirect, 'node/')) {
            $d7id = str_replace('node/', '', $redirect);
            $query = $this->entityTypeManager
              ->getStorage('node')
              ->getQuery();
            $query->condition('field_d7_nid', $d7id);
            $nid = reset($query->execute());
            $redirect = 'internal:/node/' . $nid;
          }
          // now convert D9 taxo ID
          elseif (str_starts_with($redirect, 'taxonomy/term/')) {
            $d7id = str_replace('taxonomy/term/', '', $redirect);
            $query = $this->entityTypeManager
              ->getStorage('taxonomy_term')
              ->getQuery();
            $query->condition('field_field_d7_tid', $d7id);
            $tid = reset($query->execute());
            $redirect = 'internal:/taxonomy/term/' . $tid;
          }
          // if internal link, remove prepended frontslash, add internal:
          elseif (str_starts_with($redirect, '/')) {
            $redirect = 'internal:' . $redirect;
          }
          elseif (!str_starts_with($redirect, 'http')) {
            $redirect = 'internal:/' . $redirect;
          }
          if (!in_array($redirect, $previous)) {
            Redirect::create([
              'redirect_source' => $source,
              'redirect_redirect' => $redirect,
              'status_code' => 301,
            ])->save();
            $previous[] = $redirect;
            echo $data[0] . ' saved.' . PHP_EOL;
          }
        }
      }
      fclose($file);
    }
  }

  /**
   * Finalize department document node import.
   *
   * @command import:department_document
   * @param $after_id (Node ID to resume after).
   *
   * @usage import:department_document
   */
  public function finalizeDepartmentDocument($after_id = 0) {
    $nodedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/department-document.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'department' => explode('|', str_replace('`', '', $data[1])),
          'category' => explode('|', str_replace('`', '', $data[2])),
          'path' => str_replace('`', '', $data[5]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      if ($after_id > $d7id) continue; // Skip if told to.
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'department_document')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);
      $node->field_department->setValue([]);
      foreach ($data['department'] as $department) {
        $term = Term::load($this->taxonomyImportTasks->newTid($department, 'department'));
        $node->field_department->appendItem($term);
      }
      $node->field_category->setValue([]);
      foreach ($data['category'] as $category) {
        $term = Term::load($this->taxonomyImportTasks->newTid($category, 'categories'));
        $node->field_category->appendItem($term);
      }
      if (!empty($data['path'])) {
        $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $data['path']);
        $remote_file = str_replace(' ', '%20', $remote_file);
        $file_data = file_get_contents($remote_file);
        // Fixes for irregular paths.
        $local_destination = str_replace('legacy/police/graphics', '', $data['path']);
        $local_destination = str_replace('default_images', '', $local_destination);
        $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
        $local_destination = str_replace('hero', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy10_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy11_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy12_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy13_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy14_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy15_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy16_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy17_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy18_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy19_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/fy20_pdf/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/reports/memo_pdf', '', $local_destination);
        $local_destination = str_replace('legacy/auditor/pdf', '', $local_destination);
        $local_destination = str_replace('legacy/police/pdf/2012', '', $local_destination);
        $local_destination = str_replace('legacy/police/pdf/2013', '', $local_destination);
        $local_destination = str_replace('legacy/police/pdf/2015', '', $local_destination);
        $local_destination = str_replace('legacy/development-services/pdf/industry/infobulletin', '', $local_destination);
        $local_destination = str_replace('legacy/development-services/pdf/industry/forms', '', $local_destination);
        $local_destination = str_replace('public://', '', $local_destination);
        $local_destination = str_replace(' ', '%20', $local_destination);
        $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
        if (is_object($local_file)) {
          $document = Media::create([
            'bundle' => 'document',
            'uid' => 0,
            'field_media_document' => [
              'target_id' => $local_file->id(),
            ],
          ]);
          $document->save();
          if ($document !== NULL) {
            $node->field_attachment = ['target_id' => $document->id()];
          }
        }
      }

      $node->save();
      echo 'Memory: ' . $this->memoryUsage(memory_get_usage(true)) . ' Node: ' . $node->id() . 'D7 ID: ' . $d7id . PHP_EOL;
    }
  }

  /**
   * Finalize outreach2 node import.
   *
   * @command import:outreach2
   *
   * @usage import:outreach2
   */
  public function finalizeOutreach2() {
    $nodedata = [];
    $paradata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/outreach2.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'department' => explode('|', str_replace('`', '', $data[1])),
          'search_keymatch' => explode('|', str_replace('`', '', $data[3])),
          'sections' => explode('|', str_replace('`', '', $data[4])),
        ];
      }
      fclose($file);
    }

    // Get outreach2 paragraph data.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/fieldcollections/field-outreach-sections-coll2.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $paradata[str_replace('`', '', $data[0])] = [
          'image_department' => explode(' |', str_replace('`', '', $data[1])),
          'image_license' => str_replace('`', '', $data[2]),
          'image_alt' => str_replace('`', '', $data[3]),
          'image_d7id' => str_replace('`', '', $data[4]),
          'image_path' => str_replace('`', '', $data[5]),
          'body' => str_replace('`', '', $data[6]),
          'min_height' => str_replace('`', '', $data[7]),
          'bg_color' => str_replace('`', '', $data[8]),
          'centered' => str_replace('`', '', $data[9]),
          'full_width' => str_replace('`', '', $data[10]),
          'scroll_ratio' => str_replace('`', '', $data[11]),
          'adjustment_width' => str_replace('`', '', $data[12]),
          'bg_size' => str_replace('`', '', $data[13]),
          'bottom_border' => str_replace('`', '', $data[14]),
          'direction' => str_replace('`', '', $data[15]),
          'hide_on_mobile' => str_replace('`', '', $data[18]),
          'horizontal' => str_replace('`', '', $data[19]),
          'image_height' => str_replace('`', '', $data[20]),
          'mobile_size' => str_replace('`', '', $data[21]),
          'drop_shadow' => str_replace('`', '', $data[22]),
          'styling' => str_replace('`', '', $data[23]),
          'opacity' => str_replace('`', '', $data[24]),
          'rate' => str_replace('`', '', $data[25]),
          'repeat' => str_replace('`', '', $data[26]),
          'vertical_offset' => str_replace('`', '', $data[27]),
          'vertical' => str_replace('`', '', $data[28]),
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
      $query->condition('type', 'outreach2')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);
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
      $node->field_sections_outreach2->setValue([]);
      foreach ($data['sections'] as $section) {
        if (array_key_exists($section, $paradata)) {
          $p = $paradata[$section];
          if (!empty($p['image_path'])) {
            $prior_image = $this->checkMediaId($p['image_d7id']);
            if ($prior_image == NULL) {
              $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $p['image_path']);
              $file_data = file_get_contents($remote_file);
              // Fixes for irregular paths.
              $local_destination = str_replace('legacy/police/graphics', '', $p['image_path']);
              $local_destination = str_replace('default_images', '', $local_destination);
              $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
              $local_destination = str_replace('hero', '', $local_destination);
              $local_destination = str_replace('public://', '', $local_destination);
              $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
              $image_department = [];
              foreach ($p['image_department'] as $department) {
                $image_department[] = $this->taxonomyImportTasks->newTid($department, 'department');
              }

              $image = Media::create([
                'bundle' => 'image',
                'uid' => 0,
                'field_media_image' => [
                  'target_id' => $local_file->id(),
                  'alt' => $p['image_alt']
                ],
                'field_d7_mid' => $p['image_d7id'],
              ]);
              if (!empty($p['image_license'])) {
                $image->field_license = $p['image_license'];
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
            'type' => 'sections_outreach2',
            'field_body' => [
              'value' => $p['body'],
              'format' => 'full_html'
            ],
            'field_adjustment_width' => $p['adjustment_width'],
            'field_background_size' => $p['bg_size'],
            'field_bg_color' => $p['bg_color'],
            'field_bottom_border' => $p['bottom_border'],
            'field_centered' => $p['centered'],
            'field_direction' => $p['direction'],
            'field_full_width_mobile' => $p['full_width'],
            'field_hide_on_mobile' => $p['hide_on_mobile'],
            'field_horizontal' => $p['horizontal'],
            'field_image_height' => $p['image_height'],
            'field_image_scroll_ratio' => $p['scroll_ratio'],
            'field_minimum_height' => $p['min_height'],
            'field_mobile_size' => $p['mobile_size'],
            'field_no_drop_shadow' => $p['drop_shadow'],
            'field_no_styling' => $p['styling'],
            'field_opacity' => $p['opacity'],
            'field_rate' => $p['rate'],
            'field_repeat' => $p['repeat'],
            'field_vertical_offset' => $p['vertical_offset'],
            'field_vertical' => $p['vertical'],
            'field_image' => $image,
          ]);
          $paragraph->save();
          $node->field_sections_outreach2->appendItem($paragraph);
        }
      }
      $node->save();
      echo 'Memory: ' . $this->memoryUsage(memory_get_usage(true)) . ' Node: ' . $node->id() . PHP_EOL;
    }
  }

  /**
   * Finalize hero node import.
   *
   * @command import:hero
   *
   * @usage import:hero
   */
  public function finalizeHero() {
    $nodedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/hero.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'department' => explode('|', str_replace('`', '', $data[1])),
          'image_department' => str_replace('`', '', $data[2]),
          'image_license' => str_replace('`', '', $data[3]),
          'image_alt' => str_replace('`', '', $data[4]),
          'image_d7id' => str_replace('`', '', $data[5]),
          'image_path' => str_replace('`', '', $data[6]),
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
      $query->condition('type', 'hero')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      $node->field_department->setValue([]);
      foreach ($data['department'] as $department) {
        $term = Term::load($this->taxonomyImportTasks->newTid($department, 'department'));
        $node->field_department->appendItem($term);
      }

      if (!empty($data['image_path'])) {
        $prior_image = $this->checkMediaId($data['image_d7id']);
        if ($prior_image == NULL) {
          $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $data['image_path']);
          $file_data = file_get_contents($remote_file);
          // Fixes for irregular paths.
          $local_destination = str_replace('legacy/police/graphics', '', $data['image_path']);
          $local_destination = str_replace('default_images', '', $local_destination);
          $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
          $local_destination = str_replace('hero', '', $local_destination);
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
      }
      else {
        $image = NULL;
      }
      $node->field_image = $image;

      $node->save();
      echo $node->id() . PHP_EOL;
    }
  }

  /**
   * Finalize blog import.
   *
   * @command import:blog
   * @param $after_id (D7 Node ID to resume after).
   *
   * @usage import:blog
   */
  public function finalizeBlog($after_id = 0) {
    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/blog.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'department' => explode('|', str_replace('`', '', $data[1])),
          'category' => explode('|', str_replace('`', '', $data[2])),
          'search_keymatch' => explode('|', str_replace('`', '', $data[3])),
          'image_department' => str_replace('`', '', $data[16]),
          'image_license' => str_replace('`', '', $data[17]),
          'image_alt' => str_replace('`', '', $data[18]),
          'image_d7id' => str_replace('`', '', $data[19]),
          'image_path' => str_replace('`', '', $data[20]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      if ($d7id < $after_id) continue;
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'blog')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      $node->field_department->setValue([]);
      foreach ($data['department'] as $department) {
        $term = Term::load($this->taxonomyImportTasks->newTid($department, 'department'));
        $node->field_department->appendItem($term);
      }

      $node->field_category->setValue([]);
      foreach ($data['category'] as $category) {
        $term = Term::load($this->taxonomyImportTasks->newTid($category, 'category'));
        $node->field_category->appendItem($term);
      }

      $node->field_search_keymatch->setValue([]);
      foreach ($data['search_keymatch'] as $search_keymatch) {
        $term = Term::load($this->taxonomyImportTasks->newTid($search_keymatch, 'search_keymatch'));
        $node->field_search_keymatch->appendItem($term);
      }

      $image = NULL;

      if (!empty($data['image_path'])) {
        if (str_starts_with($data['image_path'], 'youtube://')) {
          $youtube = str_replace('youtube://v/', 'https://www.youtube.com/watch?v=', $data['image_path']);
          $image = Media::create([
            'bundle' => 'remote_video',
            'uid' => 0,
            'field_media_oembed_video' => $youtube,
          ]);
          $image->save();
        }
        else {
          $prior_image = $this->checkMediaId($data['image_d7id']);
          if ($prior_image == NULL) {
            $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $data['image_path']);
            $file_data = file_get_contents($remote_file);
            $local_destination = explode('/', $data['image_path']);
            $local_destination = $local_destination[count($local_destination) - 1];
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
        }
      }
      else {
        $image = NULL;
      }
      $node->field_feature_video_img = $image;
      $node->save();

      echo 'D7 ID | ' . $d7id . PHP_EOL;
    }
  }

  /**
   * Finalize article import.
   *
   * @command import:article
   * @param $after_id (D7 Node ID to resume after).
   *
   * @usage import:article
   */
  public function finalizeArticle($after_id = 0) {
    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/article.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[5])] = [
          'department' => explode('|', str_replace('`', '', $data[4])),
          'category' => explode('|', str_replace('`', '', $data[3])),
          'search_keymatch' => explode('|', str_replace('`', '', $data[7])),
          'image_department' => str_replace('`', '', $data[14]),
          'image_license' => str_replace('`', '', $data[13]),
          'image_alt' => str_replace('`', '', $data[15]),
          'image_d7id' => str_replace('`', '', $data[16]),
          'image_path' => str_replace('`', '', $data[17]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      if ($d7id < $after_id) continue;
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'article')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      $node->field_department->setValue([]);
      foreach ($data['department'] as $department) {
        $term = Term::load($this->taxonomyImportTasks->newTid($department, 'department'));
        $node->field_department->appendItem($term);
      }

      $node->field_category->setValue([]);
      foreach ($data['category'] as $category) {
        $term = Term::load($this->taxonomyImportTasks->newTid($category, 'category'));
        $node->field_category->appendItem($term);
      }

      $node->field_search_keymatch->setValue([]);
      foreach ($data['search_keymatch'] as $search_keymatch) {
        $term = Term::load($this->taxonomyImportTasks->newTid($search_keymatch, 'search_keymatch'));
        $node->field_search_keymatch->appendItem($term);
      }

      $image = NULL;

      if (!empty($data['image_path'])) {
        if (str_starts_with($data['image_path'], 'youtube://')) {
          $youtube = str_replace('youtube://v/', 'https://www.youtube.com/watch?v=', $data['image_path']);
          $image = Media::create([
            'bundle' => 'remote_video',
            'uid' => 0,
            'field_media_oembed_video' => $youtube,
          ]);
          $image->save();
        }
        else {
          $prior_image = $this->checkMediaId($data['image_d7id']);
          if ($prior_image == NULL) {
            $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $data['image_path']);
            $file_data = file_get_contents($remote_file);
            $local_destination = explode('/', $data['image_path']);
            $local_destination = $local_destination[count($local_destination) - 1];
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
        }
      }
      else {
        $image = NULL;
      }
      $node->field_image = $image;
      $node->save();

      echo 'D7 ID | ' . $d7id . PHP_EOL;
    }
  }

//  /**
//   * Manual node full_html content fixes.
//   *
//   * @command import:class-fixes
//   *
//   * @usage import:class-fixes
//   *
//   */
//  public function contentFixes() {
//    // Load nodes.
//    $query = $this->entityTypeManager
//      ->getStorage('node')
//      ->getQuery();
//    $query->condition('type', ['department', 'location'], 'IN');
//    $nids = $query->execute();
//    foreach ($nids as $id) {
//      \Drupal::service('entity.memory_cache')->deleteAll();
//      $node = Node::load($id);
//      if ($node->hasField('field_sidebar')) {
//        $sidebar_html = $node->field_sidebar->value;
//      }
//      else {
//        $sidebar_html = NULL;
//      }
//      $body_html = $node->body->value;
//      if (strpos($sidebar_html, 'src="/modules/file/icons/application-pdf.png"') !== FALSE) {
//        $sidebar_html = str_replace('src="/modules/file/icons/application-pdf.png"', 'src="/core/themes/classy/images/icons/application-pdf.png"', $sidebar_html);
//        $node->field_sidebar->value = $sidebar_html;
//        $node->save();
//        echo 'Node #' . $node->id() . ' updated.' . PHP_EOL;
//      }
//      if (strpos($body_html, 'src="/modules/file/icons/application-pdf.png"') !== FALSE) {
//        $body_html = str_replace('src="/modules/file/icons/application-pdf.png"', 'src="/core/themes/classy/images/icons/application-pdf.png"', $body_html);
//        $node->body->value = $body_html;
//        $node->save();
//        echo 'Node #' . $node->id() . ' updated.' . PHP_EOL;
//      }
//      if (strpos($body_html, 'class="row') !== FALSE || strpos($body_html, 'columns') !== FALSE) {
//        $body_html = str_replace('  ', ' ', $body_html);
//        $body_html = str_replace('class="row', 'class="grid-x grid-margin-x', $body_html);
//        $body_html = str_replace('class="one columns', 'class="cell medium-1', $body_html);
//        $body_html = str_replace('class="two columns', 'class="cell medium-2', $body_html);
//        $body_html = str_replace('class="three columns', 'class="cell medium-3', $body_html);
//        $body_html = str_replace('class="four columns', 'class="cell medium-4', $body_html);
//        $body_html = str_replace('class="five columns', 'class="cell medium-5', $body_html);
//        $body_html = str_replace('class="six columns', 'class="cell medium-6', $body_html);
//        $body_html = str_replace('class="seven columns', 'class="cell medium-7', $body_html);
//        $body_html = str_replace('class="eight columns', 'class="cell medium-8', $body_html);
//        $body_html = str_replace('class="nine columns', 'class="cell medium-9', $body_html);
//        $body_html = str_replace('class="ten columns', 'class="cell medium-10', $body_html);
//        $body_html = str_replace('class="eleven columns', 'class="cell medium-11', $body_html);
//        $body_html = str_replace('class="twelve columns', 'class="cell medium-12', $body_html);
//        $body_html = str_replace('class="sm-two columns', 'class="cell small-2', $body_html);
//        $body_html = str_replace('class="sm-three columns', 'class="cell small-3', $body_html);
//        $body_html = str_replace('class="sm-seven columns', 'class="cell small-7', $body_html);
//        $body_html = str_replace('class="sm-ten columns', 'class="cell small-10', $body_html);
//        $body_html = str_replace('class="two sm-two columns', 'class="cell medium-2 small-2', $body_html);
//        $body_html = str_replace('class="ten sm-ten columns', 'class="cell medium-10 small-10', $body_html);
//        $node->body->value = $body_html;
//        $node->save();
//        echo 'Node #' . $node->id() . ' updated.' . PHP_EOL;
//      }
//    }
//
//    // Load paragraphs.
//    $query = $this->entityTypeManager
//      ->getStorage('paragraph')
//      ->getQuery();
//    $query->condition('type', ['sections_outreach2'], 'IN');
//    $pids = $query->execute();
//    foreach ($pids as $id) {
//      \Drupal::service('entity.memory_cache')->deleteAll();
//      $paragraph = Paragraph::load($id);
//      $body_html = $paragraph->field_body->value;
//      if (strpos($body_html, 'src="/modules/file/icons/application-pdf.png"') !== FALSE) {
//        $body_html = str_replace('src="/modules/file/icons/application-pdf.png"', 'src="/core/themes/classy/images/icons/application-pdf.png"', $body_html);
//        $paragraph->field_body->value = $body_html;
//        $paragraph->save();
//        echo 'Paragraph #' . $paragraph->id() . ' updated.' . PHP_EOL;
//      }
//      if (strpos($body_html, 'class="row') !== FALSE || strpos($body_html, 'columns') !== FALSE) {
//        $body_html = str_replace('  ', ' ', $body_html);
//        $body_html = str_replace('class="row', 'class="grid-x grid-margin-x', $body_html);
//        $body_html = str_replace('class="one columns', 'class="cell medium-1', $body_html);
//        $body_html = str_replace('class="two columns', 'class="cell medium-2', $body_html);
//        $body_html = str_replace('class="three columns', 'class="cell medium-3', $body_html);
//        $body_html = str_replace('class="four columns', 'class="cell medium-4', $body_html);
//        $body_html = str_replace('class="five columns', 'class="cell medium-5', $body_html);
//        $body_html = str_replace('class="six columns', 'class="cell medium-6', $body_html);
//        $body_html = str_replace('class="seven columns', 'class="cell medium-7', $body_html);
//        $body_html = str_replace('class="eight columns', 'class="cell medium-8', $body_html);
//        $body_html = str_replace('class="nine columns', 'class="cell medium-9', $body_html);
//        $body_html = str_replace('class="ten columns', 'class="cell medium-10', $body_html);
//        $body_html = str_replace('class="eleven columns', 'class="cell medium-11', $body_html);
//        $body_html = str_replace('class="twelve columns', 'class="cell medium-12', $body_html);
//        $body_html = str_replace('class="sm-two columns', 'class="cell small-2', $body_html);
//        $body_html = str_replace('class="sm-three columns', 'class="cell small-3', $body_html);
//        $body_html = str_replace('class="sm-seven columns', 'class="cell small-7', $body_html);
//        $body_html = str_replace('class="sm-ten columns', 'class="cell small-10', $body_html);
//        $body_html = str_replace('class="two sm-two columns', 'class="cell medium-2 small-2', $body_html);
//        $body_html = str_replace('class="ten sm-ten columns', 'class="cell medium-10 small-10', $body_html);
//        $paragraph->field_body->value = $body_html;
//        $paragraph->save();
//        echo 'Paragraph #' . $paragraph->id() . ' updated.' . PHP_EOL;
//      }
//    }
//  }

  /**
   * Import "reusable component" content type which are legacy D7 blocks.
   *
   * @command import:reusable-components
   *
   * @usage import:reusable-components
   */
  public function importReusableComponents() {

    // Delete any previously imported sidebar block contexts data.
    $query = $this->entityTypeManager
      ->getStorage('node')
      ->getQuery();
    $query->condition('type', 'sidebar_block_context');
    $nids = $query->execute();
    foreach ($nids as $nid) {
      $node = Node::load($nid);
      $node->delete();
    }

    // Load exported D7 block data.
    $reusable_components = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/blocks/block-content.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $reusable_components[str_replace('`', '', $data[1])] = [
          'id' => str_replace('`', '', $data[0]),
          'label' => str_replace('`', '', $data[2]),
          'body' => str_replace('`', '', $data[3]),
        ];
      }
      fclose($file);
    }

    // Process contexts mysql table dump for block placement based on taxonomy.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/blocks/contexts.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $conditions = unserialize($data[3]);
        $departments = NULL;
        $departments_subs = NULL;
        $paths = NULL;
        if (array_key_exists('node_taxonomy', $conditions)) {
          foreach ($conditions['node_taxonomy']['values'] as $dtid) {
            $d9_tid = $this->taxonomyImportTasks->newTid($dtid, 'department');
            if (!empty($d9_tid)) {
              $departments[] = $d9_tid;
            }
          }
        }
        if (array_key_exists('taxonomy_descendants_condition', $conditions)) {
          foreach ($conditions['taxonomy_descendants_condition']['values'] as $dtid) {
            $d9_tid = $this->taxonomyImportTasks->newTid($dtid, 'department');
            if (!empty($d9_tid)) {
              $departments_subs[] = $d9_tid;
            }
          }
        }
        if (array_key_exists('path', $conditions)) {
          foreach ($conditions['path'] as $path) {
            $paths[] = $path;
          }
        }
        $blocks = unserialize($data[4]);
        if (array_key_exists('block', $blocks) && count($blocks['block']['blocks']) > 0) {
          $node = Node::create([
            'type' => 'sidebar_block_context',
            'title' => $data[0],
            'field_department' => $departments,
            'field_department_subs' => $departments_subs,
            'field_path' => $paths,
            'moderation_state' => [
              'target_id' => 'published',
            ],
            'uid' => 0
          ]);
          foreach ($blocks['block']['blocks'] as $delta => $block) {
            if ($block['region'] == 'sidebar' || $block['region'] == 'sidebar_bottom') {
              if (array_key_exists($block['delta'], $reusable_components) && !empty($reusable_components[$block['delta']])) {
                $paragraph = Paragraph::create([
                  'type' => 'block',
                  'field_body' => [
                    'value' => $reusable_components[$block['delta']]['body'],
                    'format' => 'full_html'
                  ],
                  'field_label' => $reusable_components[$block['delta']]['label'],
                  'field_weight' => $block['weight'],
                  'field_region' => $block['region'],
                ]);
                $paragraph->save();
                $node->field_block->appendItem($paragraph);
              }
            }
            if ($block['module'] == 'menu') {
              if ($block['region'] == 'sidebar') {
                $node->field_sidebar_menu_id = $block['delta'];
              }
              else if ($block['region'] == 'sub-navigation') {
                $node->field_top_menu_id = $block['delta'];
              }
            }
          }

          // Only save node if there are actually valid blocks or a menu.
          if (count($node->field_block->getValue()) > 0 || count($node->field_sidebar_menu_id->getValue()) > 0 || count($node->field_top_menu_id->getValue()) > 0) {
            $node->save();
          }
        }
      }
      fclose($file);
    }
  }

  /**
   * Delete D7 menus to delete all links.
   *
   * @command import:delete-menus
   *
   * @usage import:delete-menus
   */
  public function deleteMenus() {
    $ignore_list = [
      'devel',
      'features',
      'main-menu',
      'management',
      'navigation',
      'user-menu',
    ];
    $menu = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/menu_custom.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $menu_id = str_replace('`', '', $data[0]);
        if (!in_array($menu_id, $ignore_list)) {
          $menu[$menu_id] = str_replace('`', '', $data[1]);
        }
      }
      fclose($file);
    }
    foreach ($menu as $menu_id => $label) {
      $menu_entity = $this->entityTypeManager->getStorage('menu')
        ->loadByProperties(['id' => $menu_id]);
      if (!empty($menu_entity)) {
        // Delete menu.
        $menu_entity = reset($menu_entity);
        $menu_entity->delete();
      }
    }
  }

  /**
   * Recreate D7 menus.
   *
   * @command import:menus
   *
   * @usage import:menus
   */
  public function importMenus() {
    $ignore_list = [
      'devel',
      'features',
      'main-menu',
      'management',
      'navigation',
      'user-menu',
    ];

    // Create menu item link array first so empty menus aren't imported.
    $menu_links = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/menu_links.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $hidden = str_replace('`', '', $data[8]);
        if ($hidden == 1) {
          // This is a hidden link; ignore.
          continue;
        }
        $menu_name = str_replace('`', '', $data[0]);
        if (in_array($menu_name, $ignore_list)) {
          continue;
        }
        $link_path = str_replace('`', '', $data[3]);
        // Convert to D9 node id.
        if (strpos($link_path, 'node/') == 0) {
          $d7id = str_replace('node/', '', $link_path);
          $query = $this->entityTypeManager
            ->getStorage('node')
            ->getQuery();
          $query->condition('field_d7_nid', $d7id);
          $nid = reset($query->execute());
          if (!empty($nid)) {
            $link_path = 'internal:/node/' . $nid;
          }
          else {
            // Node not imported yet or was unpublished; ignore this link.
            continue;
          }
        }
        elseif ($link_external == 0) {
          $link_path = 'internal:/' . $link_path;
        }
        $link_title = str_replace('`', '', $data[5]);
        $link_expanded = str_replace('`', '', $data[11]);
        $link_external = str_replace('`', '', $data[9]);
        $link_weight = str_replace('`', '', $data[12]);
        $link_d7id = str_replace('`', '', $data[1]);
        $link_parent = str_replace('`', '', $data[2]);
        $menu_links[$menu_name][$link_d7id] = [
          'path' => $link_path,
          'title' => $link_title,
          'expanded' => $link_expanded,
          'external' => $link_external,
          'weight' => $link_weight,
          'parent' => $link_parent
        ];
      }
      fclose($file);
    }

    // Note: commented out as this only needs to be run once locally to create
    // menu config export files.

//    // Get menu IDs + Labels array. Only get necessary menus.
//    $menu = [];
//    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/menu_custom.csv', 'r')) {
//      fgets($file);
//      while ($data = fgetcsv($file)) {
//        $menu_id = str_replace('`', '', $data[0]);
//        if (!in_array($menu_id, $ignore_list) && array_key_exists($menu_id, $menu_links)) {
//          $menu[$menu_id] = str_replace('`', '', $data[1]);
//        }
//      }
//      fclose($file);
//    }
//
//    // Create menus.
//    foreach ($menu as $menu_id => $label) {
//      $menu_entity = $this->entityTypeManager->getStorage('menu')
//        ->loadByProperties(['id' => $menu_id]);
//      if (!empty($menu_entity)) {
//        // Delete any previously migrated menu so it is recreated.
//        $menu_entity = reset($menu_entity);
//        $menu_entity->delete();
//      }
//      // Create new menu.
//      $menu_entity = Menu::create([
//        'id' => $menu_id,
//        'label' => $label,
//      ]);
//      $menu_entity->save();
//    }

    // Populate menus.
    $menu_d7id_uuid = [];
    foreach ($menu_links as $menu_id => $items) {
      foreach ($items as $d7id => $item) {

        if ($item['parent'] == $d7id || $item['parent'] == 0) {
          $parent = NULL;
        }
        else {
          $parent = $menu_d7id_uuid[$item['parent']];
        }

        // Create menu link.
        $menu_link = MenuLinkContent::create([
          'title' => $item['title'],
          'weight' => $item['weight'],
          'link' => ['uri' => $item['path']],
          'menu_name' => $menu_id,
          'parent' => $parent,
          'expanded' => $item['expanded'],
        ]);
        $menu_link->save();

        // Save D7 ID with new D9 UUID to potentially set as parent for future.
        $menu_d7id_uuid[$d7id] = $menu_link->getPluginId();
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

  /**
   * Change owner to user 1 for all media entities.
   *
   * @command media:owner
   * @param int $media_id (Media id to start aft).
   *
   * @usage media:owner
   */
  public function mediaOwner($media_id = 0): void {
    $query = $this->entityTypeManager
      ->getStorage('media')
      ->getQuery();
    $query->condition('mid', $media_id, '>')
      ->sort('mid', 'ASC');
    $mids = $query->execute();
    foreach ($mids as $mid) {
      $media = Media::load($mid);
      $media->set('uid', 1);
      $media->save();
      echo $mid . PHP_EOL;
    }
  }

  public function memoryUsage($size) {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
  }

  /**
   * Generate docdate file to cut down on time to fix external_data nodes.
   *
   * SHOULD ONLY BE EXECUTED LOCALLY.
   *
   * @command external_data:doc_date:generatecsv
   *
   * @usage external_data:doc_date:generatecsv
   */
  public function generateDocDateCSV() {
    $docdate = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_0.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 0. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_1.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 1. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_2.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 2. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_3.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 3. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_4.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 4. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_5.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 5. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_6.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 6. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_7.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 7. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_8.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 8. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_9.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 9. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_10.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 10. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_11.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 11. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/external_data_12.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $docdate[str_replace('`', '', $data[0])] = str_replace(' 00:00:00', '', str_replace('`', '', $data[9]));
      }
      fclose($file);
      echo 'Processed file 12. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    $module_path = \Drupal::service('extension.path.resolver')->getPath('module', 'if_sdmigration');
    file_put_contents($module_path . '/migration_files/nodes/external_data/docdates.json', json_encode($docdate));
    echo 'Generated JSON file.' . PHP_EOL;
  }

  /**
   * Properly add doc date to external_data nodes.
   *
   * @command external_data:doc_date:fixnodes
   * @param $after_id (Node ID to resume after).
   *
   * @usage external_data:doc_date:fixnodes
   */
  public function addDocDate($after_id = 0) {
    $module_path = \Drupal::service('extension.path.resolver')->getPath('module', 'if_sdmigration');
    $docdate = json_decode(file_get_contents($module_path . '/migration_files/nodes/external_data/docdates.json'));
    $editdate = [];
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/external_data/editdates.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $editdate[str_replace('`', '', $data[0])] = [
          'created' => strtotime(str_replace('`', '', $data[1])),
          'changed' => strtotime(str_replace('`', '', $data[2])),
        ];
      }
      fclose($file);
      echo 'Processed node creation dates. Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
    foreach ($docdate as $d7id => $date) {
      if ($d7id < $after_id) continue;
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'external_data')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);
      $node->set('field_doc_date', rtrim($date, ' '));
      if (NULL !== $editdate[$d7id]['created']) {
        $node->set('created', $editdate[$d7id]['created']);
      }
      if (NULL !== $editdate[$d7id]['changed']) {
        $node->set('changed', $editdate[$d7id]['changed']);
      }
      $node->save();
      echo 'Saved D7 id: ' . $d7id . ' D9 id: ' . $node->id() . ' Memory usage: ' . $this->memoryUsage(memory_get_usage(true)) . PHP_EOL;
    }
  }

  /**
   * Import users
   *
   * @command import:users
   *
   * @usage import:users
   */
  public function importUsers() {
    // Role mapping.
    $roles = [];
    $roles['content owner'] = 'content_owner';
    $roles['Locations'] = 'locations';
    $roles['administrator'] = 'administrator';
    $roles['content editor'] = 'content_editor';
    $roles['Outreach2 Article'] = 'outreach2_article';
    $roles['Event'] = 'event';
    $roles['Digital Archives Photos'] = 'digital_archives_photos';
    $roles['webform results (view only)'] = 'webform_results';

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/users.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $users[str_replace('`', '', $data[0])] = [
          'name' => str_replace('`', '', $data[1]),
          'mail' => str_replace('`', '', $data[3]),
          'created' => str_replace('`', '', $data[2]),
          'roles' => explode('|', str_replace('`', '', $data[4])),
        ];
      }
      fclose($file);
    }

    // Manually add or update each user.
    foreach ($users as $d7id => $userdata) {
      // Load user (if existing).
      $query = $this->entityTypeManager
        ->getStorage('user')
        ->getQuery();
      $query->condition('field_d7_uid', $d7id);
      $uid = reset($query->execute());
      if (!empty($uid)) {
        // user exists; update.
        $user = $this->entityTypeManager->getStorage('user')->load($uid);
        $user->setEmail($userdata['mail']);
        $user->setUsername($userdata['name']);
        $user->set('created', strtotime($userdata['created']));
      }
      else {
        $user = User::create([
          'name' => $userdata['name'],
          'mail' => $userdata['mail'],
          'field_d7_uid' => $d7id,
          'created' => strtotime($userdata['created']),
        ]);
      }

      // Manage user roles and department entity fields.
      $user->set('field_department', []);
      foreach($userdata['roles'] as $role_id) {
        if (array_key_exists($role_id, $roles)) {
          $user->addRole($roles[$role_id]);
        }
        if (str_starts_with($role_id, 'department - ')) {
          $department = str_replace('department - ', '', $role_id);
          // Switches because role name =/= taxonomy name.
          if ($department == 'Homeless Services') {
            $department = 'Homelessness Strategies and Solutions';
          }
          elseif ($department == 'Real Estate Assets') {
            $department = 'Real Estate and Airport Management';
          }
          elseif ($department == 'City Council Offices') {
            $department = 'City Council';
          }
          elseif ($department == 'Park and Recreation') {
            $department = 'Parks & Recreation';
          }
          elseif ($department == 'Library') {
            $department = 'Public Library';
          }
          elseif ($department == 'Personnel') {
            $department = 'Personnel Department';
          }
          elseif ($department == 'Capital Improvements Program') {
            $department = 'Capital Improvements Program (CIP)';
          }
          elseif ($department == 'Citizens\' Review Board on Police Practices') {
            $department = 'Commission on Police Practices';
          }
          elseif ($department == 'Storm Water') {
            $department = 'Stormwater';
          }
          elseif ($department == 'Homeland Security (Office of)') {
            $department = 'Office of Emergency Services';
          }
          elseif ($department == 'Airports') {
            $department = 'Airport Management';
          }
          elseif ($department == 'Public Works') {
            $department = 'Z-Public Works (DO NOT USE)';
          }
          elseif ($department == 'San Diego Unmanned Aircraft Systems') {
            $department = 'Z-San Diego Unmanned Aircraft Systems (DO NOT USE)';
          }
          elseif ($department == 'Reservoir Lakes') {
            $department = 'Reservoirs and Lakes';
          }
          elseif ($department == 'Citizens Advisory Board On Police/Community Relatio') {
            $department = 'Citizens Advisory Board On Police/Community Relations';
          }
          elseif ($department == 'Financial Management') {
            $department = 'Z-Financial Management (DO NOT USE)';
          }
          elseif ($department == 'Office of the City Comptroller') {
            $department = 'Z-Office of the City Comptroller (DO NOT USE)';
          }
          elseif ($department == 'A Department Taxonomy') {
            continue;
          }
          if ($this->getTidByName($department) != 0) {
            $user->field_department->appendItem($this->getTidByName($department));
          }
        }
      }

      // Save.
      $user->save();
    }
  }

  /**
   * Set author and remove &#44; from node titles.
   *
   * @command import:node-set-author
   *
   * @usage import:node-set-author
   */
  public function setAuthor($d9id = 0) {
    // Get D9 and D7 UID lookup table.
    $uids = [];
    $query = $this->entityTypeManager
      ->getStorage('user')
      ->getQuery();
    $alluids = $query->execute();
    foreach ($alluids as $uid) {
      $user = User::load($uid);
      if (!array_key_exists(0, $user->get('field_d7_uid')->getValue())) {
        continue;
      }
      $d7id = $user->get('field_d7_uid')->getValue()[0]['value'];
      $uids[$d7id] = $user->id();
    }

    // Read node author data
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/node-authors.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $authors[str_replace('`', '', $data[0])] = [
          'd7_uid' => str_replace('`', '', $data[1]),
          'updated' => str_replace('`', '', $data[2]),
        ];
      }
      fclose($file);
    }

    // Update each node (except external data).
    $query = $this->entityTypeManager
      ->getStorage('node')
      ->getQuery();
    $query->condition('type', 'external_data', 'NOT IN')
      ->sort('nid', 'ASC');
    $nids = $query->execute();
    foreach ($nids as $nid) {
      if ($nid < $d9id) continue;
      $node = Node::load($nid);
      if (!$node->hasField('field_d7_nid') || !array_key_exists(0, $node->get('field_d7_nid')->getValue())) {
        continue;
      }
      $d7id = $node->get('field_d7_nid')->getValue()[0]['value'];
      $original_title = $node->getTitle();
      $updated_title = str_replace('&#44;', ',', $original_title);
      if ($original_title !== $updated_title || array_key_exists($d7id, $authors)) {
        if ($original_title !== $updated_title) {
          $node->setTitle($updated_title);
        }
        if (array_key_exists($d7id, $authors)) {
          $author_info = $authors[$d7id];
          $author_id = $uids[$author_info['d7_uid']];
          $updated = strtotime($author_info['updated']);
          $node->set('uid', $author_id);
          $node->set('changed', $updated);
        }
        $node->save();
        echo 'Saved: D7: ' . $d7id . ' | D9: ' . $node->id() . ' | Author ID: ' . $author_id . PHP_EOL;
      }
    }
  }

  /**
   * Utility: find term by name and vid.
   *
   * @param string $name
   *   Term name.
   *
   * @param string $vid
   *   Vocabulary id (default to department).
   *
   * @return int
   *   Term id, or 0 if none.
   */
  public static function getTidByName($name = NULL, $vid = 'department') {
    if (empty($name)) {
      return 0;
    }
    $properties = [
      'name' => $name,
      'vid' => $vid,
    ];
    $terms = \Drupal::service('entity_type.manager')->getStorage('taxonomy_term')->loadByProperties($properties);
    $term = reset($terms);
    return !empty($term) ? $term->id() : 0;
  }


  /**
   *
   * @command import:event
   * @param $after_id (Node ID to resume after).
   *
   * @usage import:event
   */
  public function finalizeEvent($after_id = 0) {
    $nodedata = [];
    $imagedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/event.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'event_type' => str_replace('`', '', $data[7]),
          'event_start' => str_replace(' ', 'T', str_replace('`', '', $data[13])) . ':00',
          'event_end' =>  str_replace(' ', 'T', str_replace('`', '', $data[14])) . ':00',
          'event_repeat' => str_replace('`', '', $data[15]),
          'setup_date' => str_replace(' ', 'T', str_replace('`', '', $data[36])) . ':00',
          'department' => explode('|', str_replace('`', '', $data[16])),
          'image' => str_replace('`', '', $data[40]),
          'support_images' => explode('|', str_replace('`', '', $data[41])),
          'location_address1' => str_replace('`', '', $data[54]),
          'location_address2' => str_replace('`', '', $data[45]),
          'location_city' => str_replace('`', '', $data[46]),
          'location_name' => str_replace('`', '', $data[51]),
          'location_postal_code' => str_replace('`', '', $data[52]),
          'location_province' => str_replace('`', '', $data[53]),
          'updated' => str_replace('`', '', $data[8]),
        ];
      }
      fclose($file);
    }

    // Get image data.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/image-media.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $imagedata[str_replace('`', '', $data[3])] = [
          'image_department' => str_replace('`', '', $data[0]),
          'image_license' => str_replace('`', '', $data[1]),
          'image_alt' => str_replace('`', '', $data[2]),
          'image_path' => str_replace('`', '', $data[4]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      if ($d7id < $after_id) {
        continue;
      }
      echo 'Current memory used: ' . $this->memoryUsage(memory_get_usage(TRUE)) . '| Current D7 ID: ' . $d7id . PHP_EOL;
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'event')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);
      // Set three taxonomies.
      $node->field_department->setValue([]);
      foreach ($data['department'] as $department) {
        $term = Term::load($this->taxonomyImportTasks->newTid($department, 'department'));
        $node->field_department->appendItem($term);
      }
      $node->field_event_type->setValue([]);
      if ($data['event_type'] == 6068) {
        $term = Term::load(5005);
        $node->field_event_type->appendItem($term);
      }
      elseif ($data['event_type'] == 6069) {
        $term = Term::load(5006);
        $node->field_event_type->appendItem($term);
      }
      $node->field_event_location = [
        'country_code' => 'US',
        'organization' => $data['location_name'],
        'address_line1' => $data['location_address1'],
        'address_line2' => $data['location_address2'],
        'locality' => $data['location_city'],
        'administrative_area' => $data['location_province'],
        'postal_code' => str_pad($data['location_postal_code'], 5, '0', STR_PAD_LEFT),
      ];
      $node->set('changed', strtotime($data['updated']));
      $node->field_event_setup_dt = $data['setup_date'];

      $recur_interval = '';
      $recur_number = '';
      if (!empty($data['event_repeat'])) {
        $extra_data = explode(';', str_replace('"', '', $data['event_repeat']));

        if (array_key_exists(1, $extra_data)) {
          $recur_interval = str_replace('RRULE:FREQ=', '', $extra_data[0]);
          $recur_number = str_replace('INTERVAL=', '', $extra_data[1]);
        }
      }
      if (strtotime($data['event_start']) == strtotime($data['event_end'])) {
        $event_start = explode('T', $data['event_start']);
        $event_start = strtotime($event_start[0] . 'T00:00:00');
        $event_end = explode('T', $data['event_end']);
        $event_end = strtotime($event_end[0] . 'T23:59:00');
        $duration = 1439;
        echo 'Set duration of ' . $node->id() . ' to all day.' . PHP_EOL;
      }
      else {
        $event_start = strtotime($data['event_start']);
        $event_end = strtotime($data['event_end']);
        $duration = 0;
      }
      $node->field_event_date = [
        'value' => $event_start,
        'end_value' => $event_end,
        'rrule_index' => $recur_number,
        'rrule' => $recur_interval,
        'duration' => $duration,
      ];


      if (!empty($data['image'])) {
        $image = NULL;
        $prior_image = $this->checkMediaId($data['image']);
        if ($prior_image == NULL) {
          $image_info = $imagedata[$data['image']];
          if ($image_info == NULL) continue;
          $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $image_info['image_path']);
          $file_data = file_get_contents($remote_file);
          // Fixes for irregular paths.
          $local_destination = str_replace('legacy/police/graphics', '', $image_info['image_path']);
          $local_destination = str_replace('default_images', '', $local_destination);
          $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
          $local_destination = str_replace('public://', '', $local_destination);
          $local_destination = str_replace('events/image_main', '', $local_destination);
          $local_destination = str_replace('events/image_support', '', $local_destination);
          $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
          $image_department = [$this->taxonomyImportTasks->newTid($image_info['image_department'], 'department')];
          if (is_object($local_file)) {
            $image = Media::create([
              'bundle' => 'image',
              'uid' => 0,
              'field_media_image' => [
                'target_id' => $local_file->id(),
                'alt' => $image_info['image_alt']
              ],
              'field_d7_mid' => $data['image'],
            ]);
            if (!empty($image_info['image_license'])) {
              $image->field_license = $image_info['image_license'];
            }
            foreach ($image_department as $department) {
              $image->field_department->appendItem([
                'target_id' => $department,
              ]);
            }
            $image->save();
            echo 'Image saved.' . PHP_EOL;
          }
          else {
            $image = NULL;
          }
        }
        else {
          $image = Media::load($prior_image);
          echo 'Image re-used.' . PHP_EOL;
        }
        $node->field_image = $image;
      }

      if (!empty($data['support_images'])) {
        $node->field_images->setValue([]);
        foreach ($data['support_images'] as $support_image) {
          $prior_image = $this->checkMediaId($support_image);
          if ($prior_image == NULL) {
            $image_info = $imagedata[$support_image];
            $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $image_info['image_path']);
            $file_data = file_get_contents($remote_file);
            // Fixes for irregular paths.
            $local_destination = str_replace('legacy/police/graphics', '', $image_info['image_path']);
            $local_destination = str_replace('default_images', '', $local_destination);
            $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
            $local_destination = str_replace('public://', '', $local_destination);
            $local_destination = str_replace('events/image_main', '', $local_destination);
            $local_destination = str_replace('events/image_support', '', $local_destination);
            $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
            $image_department = [$this->taxonomyImportTasks->newTid($image_info['image_department'], 'department')];
            if (is_object($local_file)) {
              $image = Media::create([
                'bundle' => 'image',
                'uid' => 0,
                'field_media_image' => [
                  'target_id' => $local_file->id(),
                  'alt' => $image_info['image_alt']
                ],
                'field_d7_mid' => $support_image,
              ]);
              if (!empty($image_info['image_license'])) {
                $image->field_license = $image_info['image_license'];
              }
              foreach ($image_department as $department) {
                $image->field_department->appendItem([
                  'target_id' => $department,
                ]);
              }
              $image->save();
              echo 'Image saved.' . PHP_EOL;
            }
            else {
              $image = NULL;
            }
          }
          else {
            $image = Media::load($prior_image);
            echo 'Image re-used.' . PHP_EOL;
          }
          $node->field_images->appendItem($image);
        }
      }

      $node->save();
    }
  }

  /**
   *
   * @command import:gallery
   * @param $after_id (Node ID to resume after).
   *
   * @usage import:gallery
   */
  public function finalizeGallery($after_id = 0) {
    $nodedata = [];
    $imagedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/gallery.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'department' => str_replace('`', '', $data[1]),
          'folder_image' => str_replace('`', '', $data[8]),
          'gallery_items' => explode('|', str_replace('`', '', $data[9])),
          'updated' => str_replace('`', '', $data[8]),
        ];
      }
      fclose($file);
    }

    // Get image data.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/image-media.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $imagedata[str_replace('`', '', $data[3])] = [
          'image_department' => str_replace('`', '', $data[0]),
          'image_license' => str_replace('`', '', $data[1]),
          'image_alt' => str_replace('`', '', $data[2]),
          'image_path' => str_replace('`', '', $data[4]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      if ($d7id < $after_id) {
        continue;
      }
      echo 'Current memory used: ' . $this->memoryUsage(memory_get_usage(TRUE)) . '| Current D7 ID: ' . $d7id . PHP_EOL;
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'sand_gallery')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);
      $term = Term::load($this->taxonomyImportTasks->newTid($data['department'], 'department'));
      $node->field_department->setValue([]);
      $node->field_department->appendItem($term);

      if (!empty($data['folder_image'])) {
        $image = NULL;
        $prior_image = $this->checkMediaId($data['folder_image']);
        if ($prior_image == NULL) {
          $image_info = $imagedata[$data['folder_image']];
          if ($image_info == NULL) continue;
          $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $image_info['image_path']);
          $file_data = file_get_contents($remote_file);
          // Fixes for irregular paths.
          $local_destination = str_replace('legacy/police/graphics', '', $image_info['image_path']);
          $local_destination = str_replace('default_images', '', $local_destination);
          $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
          $local_destination = str_replace('sand_gallery', '', $local_destination);
          $local_destination = str_replace('public://', '', $local_destination);
          $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
          $image_department = [$this->taxonomyImportTasks->newTid($image_info['image_department'], 'department')];
          if (is_object($local_file)) {
            $image = Media::create([
              'bundle' => 'image',
              'uid' => 0,
              'field_media_image' => [
                'target_id' => $local_file->id(),
                'alt' => $image_info['image_alt']
              ],
              'field_d7_mid' => $data['folder_image'],
            ]);
            if (!empty($image_info['image_license'])) {
              $image->field_license = $image_info['image_license'];
            }
            foreach ($image_department as $department) {
              $image->field_department->appendItem([
                'target_id' => $department,
              ]);
            }
            $image->save();
            echo 'Image saved.' . PHP_EOL;
          }
          else {
            $image = NULL;
          }
        }
        else {
          $image = Media::load($prior_image);
          echo 'Image re-used.' . PHP_EOL;
        }
        $node->field_sand_gallery_folderimage = $image;
      }

      if (!empty($data['gallery_items'])) {
        $node->field_sand_gallery_items->setValue([]);
        foreach ($data['gallery_items'] as $support_image) {
          $image = NULL;
          $prior_image = $this->checkMediaId($support_image);
          if ($prior_image == NULL) {
            $image_info = $imagedata[$support_image];
            $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $image_info['image_path']);
            if ($remote_file == NULL) continue;
            $file_data = file_get_contents($remote_file);
            // Fixes for irregular paths.
            $local_destination = str_replace('legacy/police/graphics', '', $image_info['image_path']);
            $local_destination = str_replace('default_images', '', $local_destination);
            $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
            $local_destination = str_replace('public://', '', $local_destination);
            $local_destination = str_replace('sand_gallery', '', $local_destination);
            $local_destination = str_replace('legacy/digitalarchives/graphics', '', $local_destination);
            $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
            $image_department = [$this->taxonomyImportTasks->newTid($image_info['image_department'], 'department')];
            if (is_object($local_file)) {
              $image = Media::create([
                'bundle' => 'image',
                'uid' => 0,
                'field_media_image' => [
                  'target_id' => $local_file->id(),
                  'alt' => $image_info['image_alt']
                ],
                'field_d7_mid' => $support_image,
              ]);
              if (!empty($image_info['image_license'])) {
                $image->field_license = $image_info['image_license'];
              }
              foreach ($image_department as $department) {
                $image->field_department->appendItem([
                  'target_id' => $department,
                ]);
              }
              $image->save();
              echo 'Image saved.' . PHP_EOL;
            }
            else {
              $image = NULL;
            }
          }
          else {
            $image = Media::load($prior_image);
            echo 'Image re-used.' . PHP_EOL;
          }
          $node->field_sand_gallery_items->appendItem($image);
        }
      }
      $node->set('changed', strtotime($data['updated']));
      $node->save();
    }
  }

  /**
   *
   * @command import:digital_archives_photos
   * @param $after_id (Node ID to resume after).
   *
   * @usage import:digital_archives_photos
   */
  public function finalizeDigitalArchivesPhotos($after_id = 0) {
    $nodedata = [];
    $imagedata = [];

    // Read extra field data for manual creation/update.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/nodes/digital-archives-photos.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $nodedata[str_replace('`', '', $data[0])] = [
          'category' => explode('|', str_replace('`', '', $data[1])),
          'image' => str_replace('`', '', $data[4]),
          'updated' => str_replace('`', '', $data[13]),
        ];
      }
      fclose($file);
    }

    // Get image data.
    if ($file = fopen($this->extensionList->getPath('if_sdmigration') . '/migration_files/image-media.csv', 'r')) {
      fgets($file);
      while ($data = fgetcsv($file)) {
        $imagedata[str_replace('`', '', $data[3])] = [
          'image_department' => str_replace('`', '', $data[0]),
          'image_license' => str_replace('`', '', $data[1]),
          'image_alt' => str_replace('`', '', $data[2]),
          'image_path' => str_replace('`', '', $data[4]),
        ];
      }
      fclose($file);
    }

    // Manually update each node.
    foreach ($nodedata as $d7id => $data) {
      if ($d7id < $after_id) {
        continue;
      }
      echo 'Current memory used: ' . $this->memoryUsage(memory_get_usage(TRUE)) . '| Current D7 ID: ' . $d7id . PHP_EOL;
      // Load node.
      $query = $this->entityTypeManager
        ->getStorage('node')
        ->getQuery();
      $query->condition('type', 'digital_archives_photos')
        ->condition('field_d7_nid', $d7id);
      $nid = reset($query->execute());
      $node = Node::load($nid);

      $node->field_category->setValue([]);
      foreach ($data['category'] as $category) {
        $term = Term::load($this->taxonomyImportTasks->newTid($category, 'categories'));
        $node->field_category->appendItem($term);
      }

      if (!empty($data['image'])) {
        $image = NULL;
        $prior_image = $this->checkMediaId($data['image']);
        if ($prior_image == NULL) {
          $image_info = $imagedata[$data['image']];
          if ($image_info == NULL) continue;
          $remote_file = str_replace('public://', 'https://www.sandiego.gov/sites/default/files/', $image_info['image_path']);
          $file_data = file_get_contents($remote_file);
          // Fixes for irregular paths.
          $local_destination = str_replace('legacy/police/graphics', '', $image_info['image_path']);
          $local_destination = str_replace('default_images', '', $local_destination);
          $local_destination = str_replace('legacy/park-and-recreation/graphics', '', $local_destination);
          $local_destination = str_replace('sand_gallery', '', $local_destination);
          $local_destination = str_replace('digital-archives-photos', '', $local_destination);
          $local_destination = str_replace('public://', '', $local_destination);
          $local_file = file_save_data($file_data, 'public://' . $local_destination, FileSystemInterface::EXISTS_REPLACE);
          $image_department = [$this->taxonomyImportTasks->newTid($image_info['image_department'], 'department')];
          if (is_object($local_file)) {
            $image = Media::create([
              'bundle' => 'image',
              'uid' => 0,
              'field_media_image' => [
                'target_id' => $local_file->id(),
                'alt' => $image_info['image_alt']
              ],
              'field_d7_mid' => $data['image'],
            ]);
            if (!empty($image_info['image_license'])) {
              $image->field_license = $image_info['image_license'];
            }
            foreach ($image_department as $department) {
              $image->field_department->appendItem([
                'target_id' => $department,
              ]);
            }
            $image->save();
            echo 'Image saved.' . PHP_EOL;
          }
          else {
            $image = NULL;
          }
        }
        else {
          $image = Media::load($prior_image);
          echo 'Image re-used.' . PHP_EOL;
        }
        $node->field_image = $image;
      }

      $node->set('changed', strtotime($data['updated']));
      $node->save();
    }
  }

  /**
   *
   * @command import:fix-doc-urls
   *
   * @usage import:fix-doc-urls
   */
  public function fixDocUrls() {
    $query = \Drupal::database()->select('node__field_url', 'f')
      ->fields('f', ['field_url_uri'])
      ->condition('field_url_uri', 'http%', 'NOT LIKE')
      ->condition('field_url_uri', '/%', 'LIKE');
    $internal_links = $query->execute();

    while ($result = $internal_links->fetchAssoc()) {
      $internal_uri = 'internal:' . $result['field_url_uri'];
      \Drupal::database()->update('node__field_url')
        ->condition('field_url_uri', $result['field_url_uri'])
        ->fields([
          'field_url_uri' => $internal_uri,
        ])
        ->execute();
    }

    $query = \Drupal::database()->select('node__field_url', 'f')
      ->fields('f', ['field_url_uri'])
      ->condition('field_url_uri', 'http%', 'NOT LIKE')
      ->condition('field_url_uri', 'internal:%', 'NOT LIKE');
    $public_links = $query->execute();

    while ($result = $public_links->fetchAssoc()) {
      $public_uri = 'public:' . $result['field_url_uri'];
      \Drupal::database()->update('node__field_url')
        ->condition('field_url_uri', $result['field_url_uri'])
        ->fields([
          'field_url_uri' => $public_uri,
        ])
        ->execute();
    }
  }

}