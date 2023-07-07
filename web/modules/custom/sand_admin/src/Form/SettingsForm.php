<?php

namespace Drupal\sand_admin\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Sand admin settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'sand_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['sand_admin.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    
    $form['skip_remove_button'] = [
      '#type' => 'textarea',
      '#required' => FALSE,
      '#title' => $this->t('Skip adding remove button on these widgets'),
      '#description' => $this->t('We are using the contrib module: multiple_fields_remove_button. In addition to the widgets this skips automatically, add any here that it does not work on like term_reference_fancytree widget'),
      '#default_value' => $this->config('sand_admin.settings')->get('skip_remove_button'),
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
    $this->config('sand_admin.settings')
      ->set('skip_remove_button', $form_state->getValue('skip_remove_button'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
