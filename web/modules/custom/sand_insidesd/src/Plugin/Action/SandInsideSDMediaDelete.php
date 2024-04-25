<?php

namespace Drupal\sand_insidesd\Plugin\Action;

use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\Session\AccountInterface;
use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;

/**
 * This logs any files that are missing from media objects.
 *
 * @Action(
 *   id = "sand_insidesd_media_delete",
 *   label = @Translation("Sand InsideSD Delete non-Inside San Diego Media"),
 *   type = "media",
 *   confirm = TRUE,
 *   api_version = "1",
 * )
 */
class SandInsideSDMediaDelete extends ViewsBulkOperationsActionBase {
  use MessengerTrait;


  protected string $table = 'sand_insidesd_cleanup';

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {

    $database = \Drupal::service('database');
    $number = $database->select($this->table)
      ->condition('mid', $entity->id())
      ->countQuery()
      ->execute()
      ->fetchField();

    // Delete the media entity if it's not in our table.
    if ($number == 0) {
     $entity->delete();
    } else {
      $this->messenger()->addMessage(\sprintf('Skipped media item because it is in InsideSD (Media id: %s)',
        $entity->id()
      ));
    }

  }

  /**
   * {@inheritdoc}
   */
  public function access($object, ?AccountInterface $account = NULL, $return_as_object = FALSE) {
    // @see Drupal\Core\Field\FieldUpdateActionBase::access().
    return $object->access('delete', $account, $return_as_object);
  }

}
