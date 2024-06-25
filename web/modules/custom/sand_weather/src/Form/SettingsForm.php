<?php

namespace Drupal\sand_weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure San Diego Weather settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'sand_weather_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['sand_weather.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['weather_url'] = [
      '#type' => 'url',
      '#required' => true,
      '#title' => $this->t('URL'),
      '#description' => $this->t('URL for getting weather, returns XML that is parsed'),
      '#default_value' => $this->config('sand_weather.settings')->get('weather_url'),
    ];
    $form['interval'] = [
      '#type' => 'number',
      '#required' => true,
      '#title' => $this->t('Interval'),
      '#description' => $this->t('The interval at which the weather is refreshed. This is in seconds.'),
      '#default_value' => $this->config('sand_weather.settings')->get('interval'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('interval') < 100) {
      $form_state->setErrorByName('interval', $this->t('Must be at least 100 seconds.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('sand_weather.settings')
      ->set('weather_url', $form_state->getValue('weather_url'))
      ->set('interval', $form_state->getValue('interval'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
