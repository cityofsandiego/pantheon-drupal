<?php

namespace Drupal\sand_aws\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Sand aws settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sand_aws_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['sand_aws.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['version'] = [
      '#type' => 'textfield',
      '#title' => $this->t('AWS Client version'),
      '#default_value' => $this->config('sand_aws.settings')->get('version'),
    ];
    $form['region'] = [
      '#type' => 'textfield',
      '#title' => $this->t('AWS region'),
      '#default_value' => $this->config('sand_aws.settings')->get('region'),
    ];
    $form['key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('AWS Key'),
      '#default_value' => $this->config('sand_aws.settings')->get('key'),
    ];
    $form['secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('AWS secret'),
      '#default_value' => $this->config('sand_aws.settings')->get('secret'),
    ];
    $form['bucket'] = [
      '#type' => 'textfield',
      '#title' => $this->t('AWS bucket'),
      '#default_value' => $this->config('sand_aws.settings')->get('bucket'),
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
    $this->config('sand_aws.settings')
      ->set('version', $form_state->getValue('version'))
      ->set('region', $form_state->getValue('region'))
      ->set('key', $form_state->getValue('key'))
      ->set('secret', $form_state->getValue('secret'))
      ->set('bucket', $form_state->getValue('bucket'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
