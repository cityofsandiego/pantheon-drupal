<?php

namespace Drupal\sand_weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure San Diego Weather settings for this site.
 */
class SettingsForm extends ConfigFormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId(): string
    {
        return 'sand_weather_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames(): array
    {
        return ['sand_weather.settings'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state): array
    {
        $form['weather_url'] = [
            '#type' => 'url',
            '#required' => true,
            '#title' => $this->t('URL'),
            '#description' => $this->t('URL that serves as the link for the weather widget'),
            '#default_value' => $this->config('sand_weather.settings')->get('weather_url'),
        ];
        $form['weather_api_key'] = [
            '#type' => 'textfield',
            '#required' => true,
            '#title' => $this->t('API Key'),
            '#description' => $this->t('You can get an API key on the account page in the Open Weather Map service. <a href="https://home.openweathermap.org/api_keys" target="_blank">Open Weather Map</a>'),
            '#default_value' => $this->config('sand_weather.settings')->get('weather_api_key'),
        ];
        $form['enable_logging'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Enable Logging'),
            '#description' => $this->t('Check this box to enable detailed logging for sand_weather.'),
            '#default_value' => $this->config('sand_weather.settings')->get('enable_logging'),
        ];

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state): void
    {
        $this->config('sand_weather.settings')
            ->set('weather_url', $form_state->getValue('weather_url'))
            ->set('enable_logging', $form_state->getValue('enable_logging'))
            ->set('weather_api_key', $form_state->getValue('weather_api_key'))  // Adding weather_api_key
            ->save();
        parent::submitForm($form, $form_state);
    }
}
