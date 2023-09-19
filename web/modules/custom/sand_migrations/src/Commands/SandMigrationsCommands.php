<?php

namespace Drupal\sand_migrations\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\user\RoleInterface;
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

  // Modules to install
  private $modules_install = [
    'entity_count',
    'registration',
    'migrate_upgrade',
    'media_migration',
    'bean_migrate',
    'webform_migrate',
    'migrate_sandbox',
    'yaml_editor',
  ];

  // Modules to UNinstall
  private $modules_uninstall = [
    'if_sand_customphp',
    'if_sdmigration',
    'registration',
    'sand_datalayer',
    'site_alert',
  ];
  
  // Themes to uninstall
  private $themes_uninstall = [
    'bartik',
    'claro',
  ];
  
  // Entity types to delete
  private $entity_types = [
    'node',
    'paragraph',
    'feeds_feed',
    'feeds_type',
    'webform',
    'taxonomy_term',
    'registration',
    'redirect',
    'sand_remote',
    'search_api_task',
  ];
  
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

  private function sandModuleInstall() {
    $installed_modules = array_keys(\Drupal::service('extension.list.module')->getAllInstalledInfo());
    foreach ($this->modules_install as $module_install) {
      if (!in_array($module_install, $installed_modules)) {
        $this->output()->writeln('Enabling Module: ' . $module_install);
        \Drupal::service('module_installer')->install([$module_install]);
      }
    }
  }

  private function sandModuleUnInstall() {
    $installed_modules = array_keys(\Drupal::service('extension.list.module')->getAllInstalledInfo());
    foreach ($this->modules_uninstall as $module_uninstall) {
      if (in_array($module_uninstall, $installed_modules)) {
        $this->output()->writeln('Disabling Module: ' . $module_uninstall);
        \Drupal::service('module_installer')->uninstall([$module_uninstall]);
      }
    }
  }

  private function sandModuleUnInstallViaDatabase() {
    // Uninstall site_alert via db in case there is still an issue with it
    $module_data = \Drupal::config("core.extension")->get("module");
    unset($module_data["site_alert"]);
    \Drupal::configFactory()
      ->getEditable("core.extension")
      ->set("module", $module_data)
      ->save();    
  }

  private function sandThemeUnInstall() {
    $installed_themes = array_keys(\Drupal::service('extension.list.theme')->getAllInstalledInfo());
    foreach ($this->themes_uninstall as $theme_uninstall) {
      if (in_array($theme_uninstall, $installed_themes)) {
        $this->output()->writeln('Enabling Module: ' . $theme_uninstall);
        \Drupal::service('theme_installer')->uninstall([$theme_uninstall]);
      }
    } 
  }
  
  private function sandDeleteEntities() {
    
    foreach ($this->entity_types as $entity_type) {
      // Create query object.
      try {
        $query = \Drupal::entityQuery($entity_type);
      }
      catch (\Exception $exception) {
        $this->output()->writeln('Entity type does not exist: ' . $entity_type);
        continue;
      }

      // Count number of entities.
      $count = $query->count()->execute();
      if ($count === 0) {
        $this->output()->writeln('No Enties of type: ' . $entity_type);
        continue;
      }
      else {
        $this->output()
          ->writeln('Number of Enties of type: ' . $entity_type . ' is: ' . $count);
      }

      // Try and delete them.
      $this->output()->writeln('Deleting Enties of type: ' . $entity_type);
      /** @var \Drush\Drupal\Commands\core\EntityCommands $command */
      $command = \Drupal::service('entity.commands');
      try {
        // Must supply bundle = null for taxonomy_term
        $options = ['bundle' => NULL, 'exclude' => NULL, 'chunks' => 50];
        $command->delete($entity_type, NULL, $options);
      }
      catch (\Exception $exception) {
        $this->output()->writeln($exception->getMessage());
      }
    }    
  }

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

    $this->sandDeleteEntities();
    $this->sandModuleInstall();
    $this->sandModuleUnInstall();
    $this->sandModuleUnInstallViaDatabase();
    $this->sandThemeUnInstall();
//    $this->sandMigrationsRolesDelete();
    $this->logger()
      ->success(dt('The D9 site has been prepped for migrations of citynet.'));
  }

  /**
   * Delete all roles except those in the ignore list.
   *
   * @usage sand_migrations:roles-delete
   *   Usage No arguments
   *
   * @command sand_migrations:roles-delete
   * @aliases smdr
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function sandMigrationsRolesDelete() {
    // Get all roles.
    $roles = \Drupal\user\Entity\Role::loadMultiple();
    foreach ($roles as $role) {
      // If not in ignore list, delete the role.
      if (!in_array($role->id(), $this->ignore_role)) {
        $role->delete();
        $this->output()->writeln('Deleted role: ' . $role->id());
      }
    }
    $this->logger()->success(dt('Deleted Roles.')); 
  }

  /**
   * List out any roles that do not have permissions.
   *
   * @usage sand_migrations:roles-permissions
   *   Usage No arguments
   *
   * @command sand_migrations:roles-permissions
   * @aliases smrp
   */
  public function sandMigrationsPermissionsForRole() {
    $roles = \Drupal\user\Entity\Role::loadMultiple();
    foreach ($roles as $role) {
      $permissions = $role->getPermissions();
      if (count($permissions) === 0) {
        $this->output()->writeln($role->id() . ' Has NO permissions');
      }
    }
  }


  /**
   * Update users and set a department taxonomy term on them equivalent to a role then remove that role from the user.
   *
   * @usage sand_migrations:users-update
   *   Usage No arguments
   *
   * @command sand_migrations:users-update
   * @aliases smt
   */
  public function sandMigrationsUsersUpdate() {
    
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
//      $rows[] = [
//        'ID' => $user->id(),
//        'Name' => $user->getAccountName(),
//        'Roles' => implode(",", $roles),
//        'Labels' => implode(",", $labels),
//      ];
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
