<?php

namespace Drupal\sand_admin\Commands;

use Drush\Commands\DrushCommands;

/**
 * A Drush commandline.
 */
class SandAdminDrushCommands extends DrushCommands {

  /**
   * Updates node titles using predefined search and replace pairs.
   *
   * @command sand_admin:update_titles
   * @aliases sand-admin-updt
   * @usage sand_admin:update_titles
   *   Executes the sand_admin_update_node_titles function to update node titles.
   */
  public function updateTitles(): void {
    sand_admin_update_node_titles();
    $this->logger()->success(dt('Node titles have been updated.'));
  }

}
