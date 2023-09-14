<?php

namespace Drupal\sand_migrations\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drush\Commands\DrushCommands;
use Http\Client\Exception;

/**
 * A Drush commandfile.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 *
 * See these files for an example of injecting Drupal services:
 *   - http://cgit.drupalcode.org/devel/tree/src/Commands/DevelCommands.php
 *   - http://cgit.drupalcode.org/devel/tree/drush.services.yml
 */
class SandMigrationsCommands extends DrushCommands {

  private $ignore_role = [
    'administrator',
    'if_administrator',
    'administrator_email',
    'anonymous',
    'authenticated',
    'content_editor',
    'content_owner',
    'content_publish',
    'content_view_only',
    'digital_archives_photos',
    'event',
    'locations',
    'outreach2_article',
    'webform_results',
    'webform_results_photos_only',
  ];

  private $label_map = [
    'Library' => 'Public Library',
  ];

  /**
   * Command description here.
   *
   * @option option-name
   *   Description
   * @usage sand_migrations-commandName foo
   *   Usage description
   *
   * @command sand_migrations:prep
   * @aliases smp
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function sandMigrationsPrep() {
    $modules_install = [
      'migrate_upgrade',
      'media_migration',
      'bean_migrate',
      'webform_migrate',
      'migrate_sandbox',
      'yaml_editor',
    ];

    $modules_uninstall = [
      'sand_datalayer',
      'if_sdmigration',
      'if_sand_customphp',
    ];

    foreach ($modules_install as $module_install) {
      $this->output()->writeln('Enabling Module: ' . $module_install);
      \Drupal::service('module_installer')->install([$module_install]);
    }

    //now disable some sandiego.gov modules
    foreach ($modules_uninstall as $module_uninstall) {
      $this->output()->writeln('Enabling Module: ' . $module_uninstall);
      \Drupal::service('module_installer')->uninstall([$module_uninstall]);
    }

      $entity_types = [
        'node',
        'paragraph',
        'feeds_feed',
        'feeds_type',
        'webform',
        'taxonomy_term',
        'redirect',
        'search_api_task',
        'user',
        'role',
      ];
      foreach ($entity_types as $entity_type) {
        $this->output()->writeln('Deleting Enties of type: ' . $entity_type);
        $command = \Drupal::service('entity.commands');
        try {
          $command->delete($entity_type);
        }
        catch (\Exception $exception) {
          $this->output()->writeln($exception->getMessage());
        }
      }
      $this->logger()->success(dt('The D9 site has been prepped for migrations of citynet.'));
}

  /**
   * Command description here.
   *
   * @option option-name
   *   Description
   * @usage sand_migrations-commandName foo
   *   Usage description
   *
   * @command sand_migrations:roles-delete
   * @aliases smdr
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function sandMigrationsRolesDelete() {

    $roles = \Drupal\user\Entity\Role::loadMultiple();
    foreach ($roles as $role) {
      if (!in_array($role->id(), $this->ignore_role)) {
        $role->delete();
        $this->output()->writeln('Deleted role: ' . $role->id());
      }
    }

    $this->logger()->success(dt('Deleted Roles.')); 
  }


    /**
   * Command description here.
   *
   * @param $arg1
   *   Argument description.
   * @param array $options
   *   An associative array of options whose values come from cli, aliases, config, etc.
   * @option option-name
   *   Description
   * @usage sand_migrations-commandName foo
   *   Usage description
   *
   * @command sand_migrations:users-update
   * @aliases smt
   */
  public function sandMigrationsUsersUpdate($arg1 = 'No Arguments passed in.', $options = ['option-name' => 'default']) {
    
    $userStorage = \Drupal::entityTypeManager()->getStorage('user');
    $query = $userStorage->getQuery();
    $uids = $query
//      ->condition('status', '1')
//      ->condition('uid', 195093)
//      ->range(0,10)
      ->execute();

    // Get all users.
    $users = $userStorage->loadMultiple($uids);
    $rows = [];
    
    foreach ($users as $id => $user) {
      /** @var \Drupal\user\Entity\User $user */
      $roles = [];
      $labels = [];
      
      $current_roles = $user->getRoles();
      
      // Get all roles for the user
      foreach ($user->getRoles() as $key => $role_id) {
        if (in_array($role_id, $this->ignore_role)) {
          continue;
        }
        /** @var \Drupal\user\Entity\Role $role */
        $role = \Drupal\user\Entity\Role::load($role_id);
        $roles[] = $role->id();
        
        // Get the label for the role and do a lookup to translate it into it's taxonomy term name and see if it exists
        // if it exists add that term to the user.
        $label = $role->get('label');
        $labels[] = $label;
        $label_search = preg_replace('/^department - /', '', $label);
        if (isset($this->label_map[$label_search])) {
          $label_search = $this->label_map[$label_search]; 
        }
        
        // See if that label exists as a department taxonomy term via the label.
        /** @var \Drupal\taxonomy\Entity\Term $term */
        $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['name' => $label_search, 'vid' => 'department']);
        if (count($term) === 1) {
          // Found 1 term that matches, add it to the user if not already there.
          $term = reset($term);
//          $parent = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadParents($term->id());
          // If the term is not on the user, add it.
          $tid = $term->id();
          $current_terms = $user->get('field_department')->getValue();
          if (!in_array($tid, $current_terms)) {
            $new_terms = [$tid] + $current_terms;
            $user->set('field_department', $new_terms);
            $user->removeRole($role_id);
            $user->save();
          }
        } else {
          // Print out non-matching Roles so we can add to the lookup table or ignore table.
          $this->output()->writeln('Did not find: ' . $label_search); 
        }
      }
      $rows[] = [
        'ID' => $user->id(),
        'Name' => $user->getAccountName(),
        'Roles' => implode(",", $roles),
        'Labels' => implode(",", $labels),
      ];
    }
//    return new RowsOfFields($rows);
  }

  /**
   * An example of the table output format.
   *
   * @param array $options An associative array of options whose values come from cli, aliases, config, etc.
   *
   * @field-labels
   *   group: Group
   *   token: Token
   *   name: Name
   * @default-fields group,token,name
   *
   * @command sand_migrations:token
   * @aliases token
   *
   * @filter-default-field name
   * @return \Consolidation\OutputFormatters\StructuredData\RowsOfFields
   */
  public function token($options = ['format' => 'table']) {
    $all = \Drupal::token()->getInfo();
    foreach ($all['tokens'] as $group => $tokens) {
      foreach ($tokens as $key => $token) {
        $rows[] = [
          'group' => $group,
          'token' => $key,
          'name' => $token['name'],
        ];
      }
    }
    //    $this->output()->writeln($arg1);
    //    $this->logger()->success(dt('Achievement unlocked.'));
    return new RowsOfFields($rows);
  }
}
