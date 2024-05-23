<?php

declare(strict_types=1);

namespace Drupal\sand_insidesd\Form;

use Drupal\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\sand_insidesd\Controller\SandInsidesdController;

/**
 * Provides a sand_insidesd form.
 */
final class SandInsideSDCleanupForm extends FormBase {

  protected string $table = 'sand_insidesd_cleanup';

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'sand_insidesd_cleanup';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['message'] = [
      '#markup' => $this->t('Use this form to add media or files ids that should not be deleted when building out InsideSD'),
    ];

    $form['id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Node ID'),
      '#size' => 10,
      '#required' => TRUE,
    ];

    $form['mid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Media ID'),
      '#size' => 10,
      ];

    $form['fid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('File ID'),
      '#size' => 10,
    ];

    $form['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#size' => 60,
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Save'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    //   if (mb_strlen($form_state->getValue('message')) < 10) {
    //     $form_state->setErrorByName(
    //       'message',
    //       $this->t('Message should be at least 10 characters.'),
    //     );
    //   }
    // @endcode
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $connection = \Drupal::service('database');
    $result = $connection->insert($this->table)
      ->fields([
        'id' => $form_state->getValue('id'),
        'mid' => $form_state->getValue('mid'),
        'fid' => $form_state->getValue('fid'),
        'bundle' => 'from form',
        'description' => $form_state->getValue('description'),
      ])
      ->execute();

    $this->messenger()->addStatus($this->t('Saved'));
  }

}
