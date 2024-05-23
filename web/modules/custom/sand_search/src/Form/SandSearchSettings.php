<?php

namespace Drupal\sand_search\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a sand_search form.
 */
class SandSearchSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'sand_search.settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['sand_search.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['sand_search_log'] = [
      '#type' => 'checkbox',
      '#required' => FALSE,
      '#title' => $this->t('Write Search debug settings to the log'),
      '#description' => $this->t('If you are wondering what is being submitted during an index run, enabling this will tell you the exact ids'),
      '#default_value' => $this->config('sand_search.settings')->get('sand_search_log'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save field default_department to config.
    $this->config('sand_search.settings')
      ->set('sand_search_log', $form_state->getValue('sand_search_log'))
      ->save();
    parent::submitForm($form, $form_state);
  }



}
