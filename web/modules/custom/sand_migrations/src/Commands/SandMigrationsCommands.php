<?php

namespace Drupal\sand_migrations\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drush\Commands\DrushCommands;

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
    'digital_archives_photos',
    'event',
    'locations',
    'outreach2_article',
    'webform_results',
    'webform_results_photos_only',
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
   * @command sand_migrations:delete_roles
   * @aliases smdr
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function sandMigrationsDeleteRoles() {

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
   * @command sand_migrations:test
   * @aliases smt
   */
  public function sandMigrationsTest($arg1 = 'No Arguments passed in.', $options = ['option-name' => 'default']) {
    
    $userStorage = \Drupal::entityTypeManager()->getStorage('user');
    $query = $userStorage->getQuery();
    $uids = $query
      ->condition('status', '1')
      ->range(0,10)
      ->execute();

    $users = $userStorage->loadMultiple($uids);
    $rows = [];
    foreach ($users as $id => $user) {
      /** @var \Drupal\user\Entity\User $user */
      $roles = [];
      $labels = [];
      foreach ($user->getRoles() as $role_id) {
//        if (in_array($role_id, $this->ignore_role)) {
//          continue;
//        }
        /** @var \Drupal\user\Entity\Role $role */
        $role = \Drupal\user\Entity\Role::load($role_id);
        $roles[] = $role->id();
        $label = $role->get('label');
        $labels[] = $label;
      }
      $rows[] = [
        'ID' => $user->id(),
        'Name' => $user->getAccountName(),
        'Roles' => implode(",", $roles),
        'Labels' => implode(",", $labels),
      ];
    }
    return new RowsOfFields($rows);
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
