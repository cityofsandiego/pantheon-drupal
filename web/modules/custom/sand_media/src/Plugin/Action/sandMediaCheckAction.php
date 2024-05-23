<?php

namespace Drupal\sand_media\Plugin\Action;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;
use Drupal\views_bulk_operations\Action\ViewsBulkOperationsPreconfigurationInterface;

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
class sandMediaCheckAction  extends ViewsBulkOperationsActionBase implements ViewsBulkOperationsPreconfigurationInterface, PluginFormInterface {

  private $filename;
  private $uri;

  private function createFile() {

    $this->filename = pathinfo( $this->configuration['sand_media_check_filename'], PATHINFO_FILENAME) . '.csv';
    $this->uri = 'public://' . $this->filename;
    if (!file_exists($this->uri)) {
      $file = File::create([
        'filename' => basename($this->filename),
        'uri' => $this->uri,
        'uid' => \Drupal::currentUser()->id(),
        'status' => 1,
      ]);
      $file->save();

      $media = Media::create([
        'name' => $file->label(),
        'bundle' => 'document',
        'uid' => \Drupal::currentUser()->id(),
        'field_media_document' => [
          'target_id' => $file->id(),
        ],
      ]);
      $media->save();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    $id = $entity->id();
    $fid = $entity->getSource()->getSourceFieldValue($entity);
    if (!is_numeric($fid)) {
      $this->createFile();
      $message = 'MediaID,' . $id . ',MissingFID,' . $fid . PHP_EOL;
      file_put_contents($this->uri, $message,FILE_APPEND);
      $this->messenger()->addMessage('Media id: ' . $id);
    } else {
      $file = File::load($fid);
      $uri = $file->getFileUri();
      if (!file_exists($uri)) {
        $this->createFile();
        $message = 'MediaID,' . $id . ',' . $uri . PHP_EOL;
        file_put_contents($this->uri, $message,FILE_APPEND);
        $this->messenger()->addMessage('Media id: ' . $id . ' file does not exist: ' . $uri);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildPreConfigurationForm(array $form, array $values, FormStateInterface $form_state): array {
    $form['sand_media_check_filename'] = [
      '#title' => $this->t('File name to write out results to'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => $values['sand_media_check_filename'] ?? '',
    ];
    return $form;
  }

  /**
   * Configuration form builder.
   *
   * Allow naming of output file.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\views_bulk_operations_example\Plugin\Action\Drupal\Core\Form\FormStateInterface $form_state
   *   The form state object.
   *
   * @return array
   *   The configuration form.
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $form['sand_media_check_filename'] = [
      '#title' => $this->t('File name WITHOUT extension for results of check'),
      '#description' => $this->t('Files that are not found will be listed here along with their media id.'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => $form_state->getValue('sand_media_check_filename'),
    ];
    return $form;
  }

  /**
   * Submit handler for the action configuration form.
   *
   * If not implemented, the cleaned form values will be
   * passed directly to the action $configuration parameter.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\views_bulk_operations_example\Plugin\Action\Drupal\Core\Form\FormStateInterface $form_state
   *   The form state object.
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state): void {
    $this->configuration['sand_media_check_filename'] = $form_state->getValue('sand_media_check_filename');
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
