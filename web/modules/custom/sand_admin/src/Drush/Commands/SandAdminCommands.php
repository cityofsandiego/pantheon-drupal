<?php

namespace Drupal\sand_admin\Drush\Commands;

use Drush\Commands\DrushCommands;

/**
 * A Drush commandline.
 */
class SandAdminCommands extends DrushCommands {

private $search_and_replace = [
  ['&amp;', '&'],
  ['&#44;', ','],
  ['&quot;', "'"],
  ['&#039;', "'"],
];

  /**
   * Updates node titles using predefined search and replace pairs.
   *
   * @command sand_admin:update_titles
   * @aliases sand-admin-updt
   * @usage sand_admin:update_titles
   *   Clean up node titles.
   */
  public function updateNodeTitles(): void {
    $this->updateTitles('node', 'title');
  }


  /**
   * Updates node titles using predefined search and replace pairs.
   *
   * @command sand_admin:update_media_titles
   * @aliases sand-admin-updmt
   * @usage sand_admin:update_media_titles
   *   Clean up media names.
   */
  public function updateMediaTitles(): void {
    $this->updateTitles('media', 'name');
  }


  /**
   * Updates node titles using predefined search and replace pairs.
   *
   * @command sand_admin:update_file_titles
   * @aliases sand-admin-updft
   * @usage sand_admin:update_file_titles
   *   Clean up file names.
   */
  public function updateFileTitles(): void {
    $this->updateTitles('file', 'filename');
  }


  /**
   * Update "titles" ($field_name) on the entity type given.
   *
   * @param $entity_type
   * @param $field_name
   *
   * @return void
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  private function updateTitles($entity_type, $field_name): void {

    $kount = 0;
    foreach ($this->search_and_replace as $pair) {
      [$search, $replace] = $pair;
      $entity_ids = \Drupal::entityQuery($entity_type)
        ->accessCheck(FALSE)
        ->condition($field_name, '%' . $search . '%', 'LIKE')
        ->execute();

      foreach ($entity_ids as $id) {
        /** @var \Drupal\media\Entity\Media $entity */
        $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($id);
        if ($entity) {
          $title = $entity->label();
          $newTitle = str_replace($search, $replace, $title);
          if ($title !== $newTitle) {
            $entity->set($field_name, $newTitle);
            $entity->save();
            $kount++;
            \Drupal::logger('sand_admin')->notice('@type ID @id title updated from @oldTitle to @newTitle.', [
              '@type' => ucfirst($entity_type),
              '@id' => $id,
              '@oldTitle' => $title,
              '@newTitle' => $newTitle,
            ]);
          }
        }
      }
    }
    $this->logger()->success(dt('@kount of @type titles have been updated.', [
      '@kount' => $kount,
      '@type' => ucfirst($entity_type)
    ]));
  }

}
