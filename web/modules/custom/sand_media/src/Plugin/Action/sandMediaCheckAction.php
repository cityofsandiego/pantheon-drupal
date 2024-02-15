<?php

namespace Drupal\sand_media\Plugin\Action;

use Drupal\Core\Session\AccountInterface;
use Drupal\file\Entity\File;
use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;

/**
 * This logs any files that are missing from media objects.
 *
 * @Action(
 *   id = "sand_media_check",
 *   label = @Translation("Sand Media Check that file exists"),
 *   type = "media",
 *   confirm = TRUE,
 *   api_version = "1",
 * )
 */
class sandMediaCheckAction extends ViewsBulkOperationsActionBase {

  private $filename = 'public://missing_files.txt';

  private function createFile() {

    if (!file_exists($this->filename)) {
      $file = File::create([
        'filename' => basename($this->filename),
        'uri' => $this->filename,
        'status' => 1,
      ]);
      $file->save();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    $id = $entity->id();
    $fid = $entity->getSource()->getSourceFieldValue($entity);
    if (!is_numeric($fid)) {
      $message = 'MediaID,' . $id . ',MissingFID,' . $fid . PHP_EOL;
      file_put_contents($this->filename, $message,FILE_APPEND);
      $this->messenger()->addMessage('Media id: ' . $id . ' file does not exist: ' . $uri);
    } else {
      $file = File::load($fid);
      $uri = $file->getFileUri();
      if (!file_exists($uri)) {
        $this->createFile();
        $message = 'MediaID,' . $id . ',' . $uri . PHP_EOL;
        file_put_contents($this->filename, $message,FILE_APPEND);
        $this->messenger()->addMessage('Media id: ' . $id . ' file does not exist: ' . $uri);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, ?AccountInterface $account = NULL, $return_as_object = FALSE) {
    // If certain fields are updated, access should be checked against them
    // as well. @see Drupal\Core\Field\FieldUpdateActionBase::access().
    return $object->access('update', $account, $return_as_object);
  }

}
